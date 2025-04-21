<?php

namespace App\Controllers;

use App\Models\GroupsModel;
use App\Models\MembersModel; // Menggunakan MembersModel sesuai permintaan
use App\Models\UserModel; // Model untuk data user
use CodeIgniter\Controller;

class Groups extends Controller
{
    protected $groupsModel;
    protected $membersModel; // Menggunakan MembersModel
    protected $userModel;

    public function __construct()
    {
        $this->groupsModel = new GroupsModel();
        $this->membersModel = new MembersModel(); // Menyambungkan dengan MembersModel
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $groups = $this->groupsModel->getGroupsWithCreatorName();

        return view('groups/index', [
            'title'  => 'Daftar Grup',
            'groups' => $groups
        ]);
    }
    public function getGroupsWithCreatorName()
{
    return $this->select('groups.*, user.username AS creator_name')
                ->join('user', 'user.id_user = groups.created_by')
                ->findAll();
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
            'photo'      => 'uploaded[photo]|is_image[photo]|max_size[photo,1024]|mime_in[photo,image/jpg,image/jpeg,image/png]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'group_name'   => $this->request->getVar('group_name'),
            'created_by'   => 1, // Sesuaikan dengan session user jika tersedia
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

        $password = $this->request->getVar('password');
        if ($password) {
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
        $photoPath = ROOTPATH . 'public/uploads/groups/' . $photo;
        if (file_exists($photoPath)) {
            unlink($photoPath);
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
        'title' => 'Tambah Member ke Grup',
        'group' => $group,
        'users' => $users
    ]);
}


    public function storeMember($id_groups)
    {
        $user_id = $this->request->getVar('user_id');
        $member_level = $this->request->getVar('member_level');
    
        if (!$user_id || !$member_level) {
            return redirect()->back()->with('errors', 'User dan level member wajib dipilih.');
        }
    
        $data = [
            'id_groups'    => $id_groups,
            'user_id'      => $user_id,
            'member_level' => $member_level,
        ];
    
        $this->membersModel->insert($data);
    
        return redirect()->to('/groups/members/' . $id_groups)->with('success', 'Member berhasil ditambahkan.');
    }

    public function members($id_groups)
    {
        $group = $this->groupsModel->find($id_groups);
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Grup tidak ditemukan.');
        }

        // Ambil data member dengan join
        $members = $this->membersModel->select('members.*, user.username')
                                      ->join('user', 'user.id_user = members.user_id')
                                      ->where('id_groups', $id_groups)
                                      ->findAll();

        return view('groups/members', [
            'title'   => 'Daftar Member di Grup: ' . esc($group['group_name']),
            'group'   => $group,
            'members' => $members
        ]);
    }

    public function detail($id_groups)
    {
        // Ambil ID user dari session
        $session = session();
        $sessionUserId = $session->get('id_user'); // Pastikan 'id_user' memang diset saat login
    
        // Ambil data grup dengan join ke user untuk dapatkan nama pembuat (creator_name)
        $group = $this->groupsModel
            ->select('groups.*, user.username AS creator_name')
            ->join('user', 'user.id_user = groups.created_by')
            ->where('groups.id_groups', $id_groups)
            ->first();
    
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Grup tidak ditemukan.');
        }
    
        // Ambil daftar member dengan join ke user
        $members = $this->membersModel
            ->join('user', 'user.id_user = members.user_id')
            ->where('id_groups', $id_groups)
            ->findAll();
    
        return view('groups/detail', [
            'title'         => 'Detail Grup: ' . esc($group['group_name']),
            'group'         => $group,
            'members'       => $members,
            'sessionUserId' => $sessionUserId, // Kirim ke view kalau mau dicek di sana
        ]);
    }
    

}
