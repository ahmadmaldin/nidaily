<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TugasModel;
use App\Models\AttachmentModel;
use App\Models\UserModel;
use App\Models\GroupsModel;
use App\Models\SharedModel;
use App\Models\FriendshipModel;

class Tugas extends BaseController
{
    protected $tugasModel;
    protected $sharedModel;

    public function __construct()
    {
        $this->tugasModel = new TugasModel();
        $this->sharedModel = new SharedModel();
    }

    // Menampilkan daftar tugas milik pengguna
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
            'title' => 'Daftar Tugas Saya',
            'tugas' => $tugas,
            'pager' => $this->tugasModel->pager,
            'keyword' => $keyword
        ];

        return view('tugas/index', $data);
    }

    // Halaman untuk membuat tugas baru
    public function create()
    {
        return view('tugas/create');
    }

    // Menyimpan tugas baru ke database
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
            'creator_id' => session()->get('id_user')
        ];

        $this->tugasModel->save($data);
        return redirect()->to('/tugas');
    }

    // Halaman untuk mengedit tugas
    public function edit($id)
    {
        $tugas = $this->tugasModel->find($id);

        if (!$tugas) {
            return redirect()->to('/tugas')->with('error', 'Tugas tidak ditemukan.');
        }

        return view('tugas/edit', ['tugas' => $tugas]);
    }

    // Memperbarui tugas yang sudah ada
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

    // Menghapus tugas
    public function delete($id)
    {
        $this->tugasModel->delete($id);
        return redirect()->to('/tugas');
    }

    // Menampilkan detail tugas
    public function detail($id)
    {
        $attachmentModel = new AttachmentModel();
        $userModel = new UserModel();
        $groupsModel = new GroupsModel();
        $sharedModel = new SharedModel();

        // Ambil data tugas
        $tugas = $this->tugasModel->find($id);

        if (!$tugas) {
            return redirect()->to('/tugas')->with('error', 'Tugas tidak ditemukan.');
        }

        // Mengambil lampiran tugas
        $attachments = $attachmentModel->where('id_tugas', $id)->findAll();

        // Mengambil daftar teman dan grup
        $users = $userModel->findAll();
        $groups = $groupsModel->findAll();

        // Mengambil pengguna yang telah berbagi tugas
        $sharedUsers = $sharedModel
            ->join('user', 'user.id_user = shared.id_user')
            ->where('shared.id_tugas', $id)
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

    // Menampilkan tugas yang dibagikan kepada pengguna
    public function sharedToMe()
    {
        $id_user = session()->get('id_user');
        $sharedTugas = $this->sharedModel
            ->join('tugas', 'tugas.id = shared.id_tugas')
            ->select('shared.*, tugas.tugas, tugas.id as tugas_id')
            ->where('shared.id_user', $id_user)
            ->findAll();
    
        $userModel = new UserModel();
        $users = [];
    
        foreach ($sharedTugas as $shared) {
            $user = $userModel->find($shared['shared_by_user_id']);
            if ($user) {
                $users[$shared['shared_by_user_id']] = $user['username'];
            }
        }
    
        return view('tugas/sharedtome', [
            'shared_tugas' => $sharedTugas,
            'users' => $users
        ]);
    }
    
    public function acceptTask($sharedId)
    {
        $shared = $this->sharedModel->find($sharedId);
    
        if (!$shared) {
            return redirect()->to('/tugas/sharedtome')->with('error', 'Tugas tidak ditemukan.');
        }
    
        $this->sharedModel->update($sharedId, [
            'accepted' => 1,
            'accept_date' => date('Y-m-d H:i:s')
        ]);
    
        return redirect()->to('/tugas/sharedtome')->with('message', 'Tugas berhasil diterima.');
    }
    
    // Menampilkan form berbagi tugas
    public function share($taskId)
    {
        $task = $this->tugasModel->find($taskId);

        if (!$task) {
            return redirect()->to('/tugas')->with('error', 'Tugas tidak ditemukan.');
        }

        $friendshipModel = new FriendshipModel();
        $groupsModel = new GroupsModel();
        $friends = $friendshipModel->getFriends(session()->get('id_user')); // Ambil teman berdasarkan id_user
        $groups = $groupsModel->findAll(); // Ambil semua grup

        return view('tugas/share', [
            'task' => $task,
            'friends' => $friends,
            'groups' => $groups
        ]);
    }

    // Memproses pembagian tugas
    public function processShare($taskId)
    {
        // Periksa apakah taskId valid
        if (!$taskId || !is_numeric($taskId)) {
            return redirect()->to('/tugas')->with('error', 'ID tugas tidak valid.');
        }

        // Ambil data teman dan grup yang dipilih
        $friendsSelected = $this->request->getPost('friends');
        $groupsSelected = $this->request->getPost('groups');

        if (!empty($friendsSelected)) {
            foreach ($friendsSelected as $friendId) {
                $this->shareTaskToFriend($taskId, $friendId);
            }
        }

        if (!empty($groupsSelected)) {
            foreach ($groupsSelected as $groupId) {
                $this->shareTaskToGroup($taskId, $groupId);
            }
        }

        return redirect()->to('/tugas')->with('message', 'Tugas berhasil dibagikan.');
    }

    public function shareTaskToFriend($taskId, $friendId)
    {
        $sharedData = [
            'id_tugas' => $taskId,
            'id_user' => $friendId,
            'shared_by_user_id' => session()->get('id_user'),
            'share_date' => date('Y-m-d H:i:s'),
            'accept_date' => null
        ];
    
        $this->sharedModel->save($sharedData);
    }
    

    // Membagikan tugas ke grup
    public function shareTaskToGroup($taskId, $groupId)
    {
        // Logic untuk membagikan tugas ke grup akan ditambahkan sesuai kebutuhan
    }

}
