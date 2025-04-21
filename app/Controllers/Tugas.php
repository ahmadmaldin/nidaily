<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TugasModel;
use App\Models\AttachmentModel;
use App\Models\UserModel;
use App\Models\GroupsModel;
use App\Models\SharedModel;
use CodeIgniter\Controller;

class Tugas extends BaseController
{
    public function index()
    {
        $model = new TugasModel();
        $tugas = $model->findAll();

        $now = strtotime(date('Y-m-d H:i:s'));

        foreach ($tugas as &$item) {
            $dueTime = strtotime($item['date_due'] . ' ' . $item['time_due']);
            $item['overdue'] = ($item['status'] != 'Done' && $dueTime < $now);
        }

        return view('tugas/index', ['tugas' => $tugas]);
    }

    public function create()
    {
        return view('tugas/create');
    }

    public function store()
    {
        $model = new TugasModel();

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

        $model->save($data);
        return redirect()->to('/tugas');
    }

    public function edit($id)
    {
        $model = new TugasModel();
        return view('tugas/edit', ['tugas' => $model->find($id)]);
    }

    public function update($id)
    {
        $model = new TugasModel();

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

        $model->update($id, $data);
        return redirect()->to('/tugas');
    }

    public function delete($id)
    {
        $model = new TugasModel();
        $model->delete($id);
        return redirect()->to('/tugas');
    }

    public function detail($id)
    {
        $tugasModel = new TugasModel();
        $attachmentModel = new AttachmentModel();
        $userModel = new UserModel();
        $groupsModel = new GroupsModel();
        $sharedModel = new SharedModel(); // Menambahkan model SharedModel untuk shared tasks
        
        // Ambil data tugas
        $tugas = $tugasModel->find($id);
        
        // Ambil data attachment terkait tugas
        $attachments = $attachmentModel->where('id_tugas', $id)->findAll();
        
        // Ambil semua user
        $users = $userModel->findAll();
    
        // Ambil semua grup (atau sesuai kebutuhan kamu bisa menambah filter untuk grup)
        $groups = $groupsModel->findAll();
        
        // Ambil daftar shared users
        $sharedUsers = $sharedModel
                        ->join('user', 'user.id_user = shared.id_user') // Join dengan tabel user untuk mendapatkan nama penerima
                        ->where('id_tugas', $id)
                        ->findAll();

        // Kirimkan data tugas, attachment, user, grup, dan shared users ke view
        return view('tugas/detail', [
            'title' => 'Detail Tugas',
            'tugas' => $tugas,
            'attachments' => $attachments,
            'users' => $users,
            'groups' => $groups,
            'sharedUsers' => $sharedUsers // Menambahkan shared users ke view
        ]);
    }

    public function show($id)
    {
        $tugasModel = new TugasModel();
        $tugas = $tugasModel->getTugasWithCreator($id);
        return view('tugas/detail', ['tugas' => $tugas]);
    }

    public function share($id = null)
    {
        if ($id === null) {
            return redirect()->to('/tugas')->with('error', 'ID tugas tidak ditemukan.');
        }

        $tugasModel = new TugasModel();
        $userModel = new UserModel();

        $data['tugas'] = $tugasModel->find($id);
        if (!$data['tugas']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Tugas dengan ID $id tidak ditemukan.");
        }

        $data['users'] = $userModel->where('id_user !=', session()->get('id_user'))->findAll();
        return view('tugas/shared', $data);
    }

    public function storeShare($id)
    {
        $sharedModel = new SharedModel();
        $userId = $this->request->getPost('user_id');
        $currentUserId = session()->get('id_user');
    
        // Cek apakah sudah dibagikan
        $alreadyShared = $sharedModel
            ->where('id_tugas', $id)
            ->where('id_user', $userId)
            ->first();
    
        if ($alreadyShared) {
            return redirect()->back()->with('error', 'Tugas sudah pernah dibagikan ke user ini.');
        }
    
        $sharedModel->save([
            'id_tugas' => $id,
            'id_user' => $userId,
            'shared_by_user_id' => $currentUserId,
            'accepted' => 'pending',
            'share_date' => date('Y-m-d H:i:s'),
            'accept_date' => null,
        ]);
    
        // Set flash message untuk sukses dan ID tugas
        session()->setFlashdata('message', 'Tugas berhasil dibagikan!');
        session()->setFlashdata('task_id', $id);
    
        return redirect()->to('/dashboard'); // atau kemanapun Anda ingin redirect setelah tugas dibagikan
    }
    

    
}
