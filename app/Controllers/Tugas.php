<?php

namespace App\Controllers;

use App\Models\TugasModel;
use App\Models\AttachmentModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Tugas extends BaseController
{
    public function index()
{
    $model = new TugasModel();
    $tugas = $model->findAll();

    $now = strtotime(date('Y-m-d H:i:s'));

    foreach ($tugas as &$item) {
        // Gabungkan tanggal dan waktu deadline
        $dueTime = strtotime($item['date_due'] . ' ' . $item['time_due']);

        // Cek apakah overdue (lewat waktu dan belum selesai)
        if ($item['status'] != 'Done' && $dueTime < $now) {
            $item['overdue'] = true;
        } else {
            $item['overdue'] = false;
        }
    }

    $data['tugas'] = $tugas;

    return view('tugas/index', $data);
}


    public function create()
    {
        return view('tugas/create'); // Menampilkan form untuk menambah tugas baru
    }

    public function store()
    {
        $model = new TugasModel();

        // Mengambil data dari form
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
        $data['tugas'] = $model->find($id);
        return view('tugas/edit', $data);
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
    
        $tugas = $tugasModel->find($id);
        $attachments = $attachmentModel->where('id_tugas', $id)->findAll();
        $users = $userModel->findAll();
    
        $data = [
            'title' => 'Detail Tugas',
            'tugas' => $tugas,
            'attachments' => $attachments,
            'users' => $users,
        ];
    
        return view('tugas/detail', $data);
    }
    
    public function show($id)
    {
        $tugasModel = new TugasModel();
        $tugas = $tugasModel->getTugasWithCreator($id);  // Ambil tugas beserta nama creator

        return view('tugas/detail', ['tugas' => $tugas]);
    }
    public function share($id = null)
    {
        if ($id === null) {
            return redirect()->to('/tugas')->with('error', 'ID tugas tidak ditemukan.');
        }
    
        $tugasModel = new TugasModel();
        $userModel = new UserModel();
    
        // Mencari tugas berdasarkan ID
        $data['tugas'] = $tugasModel->find($id); 
    
        if (!$data['tugas']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Tugas dengan ID $id tidak ditemukan.");
        }
    
        // Ambil semua user kecuali user yang sedang login
        $data['users'] = $userModel->where('id_user !=', session()->get('id_user'))->findAll();
    
        return view('tugas/shared', $data); // Tampilkan view share dan kirim data
    }
    
    public function storeShare($id)
    {
        $sharedModel = new SharedModel();
        $userId = $this->request->getPost('user_id');  // ID user yang dipilih
        $currentUserId = session()->get('id_user');   // ID user yang sedang login
    
        // Simpan data sharing
        $sharedModel->save([
            'id_tugas' => $id,
            'id_user' => $userId,
            'shared_by_user_id' => $currentUserId,
            'accepted' => 'pending',
            'share_date' => date('Y-m-d H:i:s'),
            'accept_date' => null,
        ]);
    
        return redirect()->to('/tugas/detail/' . $id)->with('success', 'Tugas berhasil dibagikan.');
    }
    

    



}
