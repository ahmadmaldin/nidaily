<?php

namespace App\Controllers;

use App\Models\GroupsModel;
use App\Models\MembersModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Groups extends Controller
{
    protected $groupsModel;
    protected $membersModel;
    protected $userModel;

    public function __construct()
    {
        $this->groupsModel = new GroupsModel();
        $this->membersModel = new MembersModel();
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $groups = $this->groupsModel
            ->select('groups.*, user.username AS creator_name')
            ->join('user', 'user.id_user = groups.created_by')
            ->findAll();

        return view('groups/index', [
            'title' => 'Daftar Grup',
            'groups' => $groups
        ]);
    }

    public function create()
    {
        return view('groups/create', ['title' => 'Tambah Grup']);
    }

    public function store()
    {
        if (!$this->validate([
            'group_name' => 'required|max_length[100]',
            'password'   => 'permit_empty|min_length[6]',
            'photo'      => 'permit_empty|is_image[photo]|max_size[photo,1024]|mime_in[photo,image/jpg,image/jpeg,image/png]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'group_name'   => $this->request->getVar('group_name'),
            'created_by'   => session()->get('id_user') ?? 1,
            'created_date' => date('Y-m-d H:i:s'),
            'password'     => $this->hashPassword($this->request->getVar('password')),
            'description'  => $this->request->getVar('description'),
        ];

        if ($photo = $this->uploadPhoto()) {
            $data['photo'] = $photo;
        }

        $this->groupsModel->insert($data);
        return redirect()->to('/groups')->with('success', 'Grup berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $group = $this->groupsModel->find($id);
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Grup tidak ditemukan.');
        }

        return view('groups/edit', [
            'title' => 'Edit Grup',
            'group' => $group
        ]);
    }

    public function update($id)
    {
        $group = $this->groupsModel->find($id);
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Grup tidak ditemukan.');
        }

        $data = [
            'group_name'  => $this->request->getVar('group_name'),
            'description' => $this->request->getVar('description'),
        ];

        if ($photo = $this->uploadPhoto()) {
            $data['photo'] = $photo;
        }

        if ($password = $this->request->getVar('password')) {
            $data['password'] = $this->hashPassword($password);
        }

        $this->groupsModel->update($id, $data);
        return redirect()->to('/groups')->with('success', 'Grup berhasil diperbarui.');
    }

    public function delete($id)
    {
        $group = $this->groupsModel->find($id);
        if ($group && $group['photo']) {
            $this->deletePhoto($group['photo']);
        }

        $this->groupsModel->delete($id);
        return redirect()->to('/groups')->with('success', 'Grup berhasil dihapus.');
    }

    private function uploadPhoto()
    {
        $file = $this->request->getFile('photo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/groups', $newName);
            return $newName;
        }
        return null;
    }

    private function deletePhoto($photo)
    {
        $path = ROOTPATH . 'public/uploads/groups/' . $photo;
        if (file_exists($path)) {
            unlink($path);
        }
    }

    private function hashPassword($password)
    {
        return $password ? password_hash($password, PASSWORD_DEFAULT) : null;
    }

    public function addMember($id_groups)
    {
        $group = $this->groupsModel->find($id_groups);
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Grup tidak ditemukan.');
        }

        $users = $this->userModel->findAll();
        return view('groups/add_member', [
            'title' => 'Tambah Member',
            'group' => $group,
            'users' => $users
        ]);
    }

    public function storeMember($id_groups)
    {
        $id_user = $this->request->getVar('id_user');
        $level = $this->request->getVar('member_level');

        if (!$id_user || !$level) {
            return redirect()->back()->with('errors', 'User dan level wajib diisi.');
        }

        $this->membersModel->insert([
            'id_groups' => $id_groups,
            'id_user' => $id_user,
            'member_level' => $level,
        ]);

        return redirect()->to('/groups/detail/' . $id_groups)->with('success', 'Member berhasil ditambahkan.');
    }

    public function removeMember($id_groups, $id_user)
    {
        $this->membersModel
            ->where('id_groups', $id_groups)
            ->where('id_user', $id_user)
            ->delete();

        return redirect()->to('/groups/detail/' . $id_groups)->with('success', 'Member berhasil dihapus.');
    }

    public function detail($id_groups)
    {
        $session = session();
        $sessionUserId = $session->get('id_user');
    
        $group = $this->groupsModel
            ->select('groups.*, user.username AS creator_name')
            ->join('user', 'user.id_user = groups.created_by')
            ->where('groups.id_groups', $id_groups)
            ->first();
    
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Grup tidak ditemukan.');
        }
    
        // SELECT yang lengkap biar yakin semua kolom dibawa
        $members = $this->membersModel
            ->select('members.id_user, members.member_level, user.username')
            ->join('user', 'user.id_user = members.id_user')
            ->where('members.id_groups', $id_groups)
            ->findAll();
    
        return view('groups/detail', [
            'title'         => 'Detail Grup: ' . esc($group['group_name']),
            'group'         => $group,
            'members'       => $members,
            'sessionUserId' => $sessionUserId,
        ]);
    }
    
    
}
