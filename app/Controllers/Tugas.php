<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TugasModel;
use App\Models\AttachmentModel;
use App\Models\UserModel;
use App\Models\GroupsModel;
use App\Models\SharedModel;

class Tugas extends BaseController
{
    protected $tugasModel;

    public function __construct()
    {
        $this->tugasModel = new TugasModel();
    }

    public function index()
    {
        $userId = session()->get('id_user');
        $keyword = $this->request->getGet('keyword');
        $perPage = 10;

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $query = $this->tugasModel->where('creator_id', $userId);

        if ($keyword) {
            $query->like('tugas', $keyword);
        }

        $tugas = $query->paginate($perPage);

        $data = [
            'title'  => 'Daftar Tugas Saya',
            'tugas' => $tugas,
            'pager'  => $this->tugasModel->pager,
            'keyword' => $keyword
        ];

        return view('tugas/index', $data);
    }

    public function create()
    {
        return view('tugas/create');
    }

    public function store()
    {
        $data = [
            'tugas' => $this->request->getPost('tugas'),
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu' => $this->request->getPost('waktu'),
            'status' => $this->request->getPost('status'),
            'alarm' => $this->request->getPost('alarm'),
            'created' => time(),
            'date_due' => $this->request->getPost('date_due'),
            'time_due' => $this->request->getPost('time_due'),
            'date_finished' => $this->request->getPost('date_finished'),
            'time_finished' => $this->request->getPost('time_finished'),
            'creator_id' => session()->get('id_user')
        ];

        $this->tugasModel->save($data);
        return redirect()->to('/tugas');
    }

    public function edit($id)
    {
        return view('tugas/edit', ['tugas' => $this->tugasModel->find($id)]);
    }

    public function update($id)
    {
        $data = [
            'tugas' => $this->request->getPost('tugas'),
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu' => $this->request->getPost('waktu'),
            'status' => $this->request->getPost('status'),
            'alarm' => $this->request->getPost('alarm'),
            'date_due' => $this->request->getPost('date_due'),
            'time_due' => $this->request->getPost('time_due'),
            'date_finished' => $this->request->getPost('date_finished'),
            'time_finished' => $this->request->getPost('time_finished'),
            'creator_id' => session()->get('id_user')
        ];

        $this->tugasModel->update($id, $data);
        return redirect()->to('/tugas');
    }

    public function delete($id)
    {
        $this->tugasModel->delete($id);
        return redirect()->to('/tugas');
    }

    public function detail($id)
{
    $attachmentModel = new AttachmentModel();
    $userModel = new UserModel();
    $groupsModel = new GroupsModel();
    $sharedModel = new SharedModel();

    $tugas = $this->tugasModel->find($id);
    $attachments = $attachmentModel->where('id_tugas', $id)->findAll();
    $users = $userModel->findAll();
    $groups = $groupsModel->findAll();
    $sharedUsers = $sharedModel
                    ->join('user', 'user.id_user = shared.id_user')
                    ->where('id_tugas', $id)
                    ->findAll();

    return view('tugas/detail', [
        'title' => 'Detail Tugas',
        'tugas' => $tugas,
        'attachments' => $attachments,
        'users' => $users,
        'groups' => $groups,
        'sharedUsers' => $sharedUsers
    ]);

    
}

    public function show($id)
    {
        $tugas = $this->tugasModel->getTugasWithCreator($id);
        return view('tugas/detail', ['tugas' => $tugas]);
    }

    public function share($id = null)
    {
        if ($id === null) {
            return redirect()->to('/tugas')->with('error', 'ID tugas tidak ditemukan.');
        }
    
        $userModel = new UserModel();
        $friendshipModel = new FriendshipModel();
        $groupsModel = new GroupsModel();
        
        $data['tugas'] = $this->tugasModel->find($id);
    
        if (!$data['tugas']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Tugas dengan ID $id tidak ditemukan.");
        }
    
        // Ambil teman dan grup
        $data['friends'] = $friendshipModel->getFriends(session()->get('id_user'));
        $data['groups'] = $groupsModel->findAll(); // Atau sesuaikan jika grup memiliki relasi tertentu
    
        return view('tugas/shared', $data);
    }
    public function storeShareToGroup($id)
    {
        $sharedModel = new SharedModel();
        $groupId = $this->request->getPost('group_id');  // Ambil group ID yang dipilih
        $groupsModel = new GroupsModel();
        
        // Ambil semua anggota dari grup yang dipilih
        $members = $groupsModel->getGroupMembers($groupId);
    
        foreach ($members as $member) {
            $userId = $member['id_user'];  // Ambil ID user dari anggota grup
            // Cek apakah sudah pernah dibagikan
            $alreadyShared = $sharedModel->where('id_tugas', $id)->where('id_user', $userId)->first();
    
            if (!$alreadyShared) {
                $sharedModel->save([
                    'id_tugas' => $id,
                    'id_user' => $userId,
                    'shared_by_user_id' => session()->get('id_user'),
                    'accepted' => 'pending',
                    'share_date' => date('Y-m-d H:i:s')
                ]);
            }
        }
    
        return redirect()->to('/tugas/detail/' . $id)->with('success', 'Tugas berhasil dibagikan ke grup.');
    }
    public function storeShareToFriend($id)
    {
        $sharedModel = new SharedModel();
        $friendId = $this->request->getPost('friend_id');  // Ambil friend ID yang dipilih
        $currentUserId = session()->get('id_user');
    
        // Cek apakah sudah dibagikan sebelumnya
        $alreadyShared = $sharedModel->where('id_tugas', $id)->where('id_user', $friendId)->first();
    
        if ($alreadyShared) {
            return redirect()->back()->with('error', 'Tugas sudah pernah dibagikan ke teman ini.');
        }
    
        $sharedModel->save([
            'id_tugas' => $id,
            'id_user' => $friendId,
            'shared_by_user_id' => $currentUserId,
            'accepted' => 'pending',
            'share_date' => date('Y-m-d H:i:s'),
            'accept_date' => null
        ]);
    
        session()->setFlashdata('message', 'Tugas berhasil dibagikan ke teman!');
        return redirect()->to('/dashboard');
    }
            

    
}
