<?php

namespace App\Controllers;

use App\Models\MembersModel;
use CodeIgniter\Controller;

class Members extends Controller
{
    // Menampilkan semua members
    public function index()
    {
        $model = new MembersModel();
        $data['members'] = $model->findAll(); // Mengambil semua member dari database
        
        // Mendapatkan session user ID
        $sessionUserId = session()->get('user_id');  // Pastikan 'user_id' sesuai dengan yang disimpan dalam sesi

        // Mengirimkan sessionUserId ke view
        return view('members/index', ['members' => $data['members'], 'sessionUserId' => $sessionUserId]);
    }

    // Tampilkan form untuk menambah member
    public function create($groupId)
    {
        // Mengirimkan ID grup dan session user ke view
        $sessionUserId = session()->get('user_id');
        return view('members/create', ['groupId' => $groupId, 'sessionUserId' => $sessionUserId]);
    }

    // Menyimpan data member baru
    public function store()
    {
        $model = new MembersModel();
        
        // Validasi input
        if (!$this->validate([
            'id_groups'    => 'required|integer',
            'id_user'      => 'required|integer',
            'member_level' => 'required|in_list[admin,member]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Data yang akan dimasukkan ke dalam tabel
        $data = [
            'id_groups'    => $this->request->getPost('id_groups'),
            'id_user'      => $this->request->getPost('id_user'),
            'member_level' => $this->request->getPost('member_level'),
        ];

        // Insert data ke database
        if ($model->insert($data)) {
            // Redirect ke halaman detail grup setelah berhasil menambahkan member
            return redirect()->to('/groups/detail/' . $data['id_groups'])->with('success', 'Member berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan member.');
        }
    }

    // Form untuk edit member
    public function edit($id)
    {
        $model = new MembersModel();
        $data['member'] = $model->find($id);  // Mengambil data member berdasarkan ID
        
        // Jika data member tidak ditemukan
        if (!$data['member']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Member tidak ditemukan');
        }

        return view('members/edit', $data);  // Menampilkan form edit member
    }

    // Update data member
    public function update($id)
    {
        $model = new MembersModel();
        
        // Validasi input
        if (!$this->validate([
            'id_groups'    => 'required|integer',
            'id_user'      => 'required|integer',
            'member_level' => 'required|in_list[admin,member]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Data yang akan diperbarui
        $data = [
            'id_groups'    => $this->request->getPost('id_groups'),
            'id_user'      => $this->request->getPost('id_user'),
            'member_level' => $this->request->getPost('member_level'),
        ];

        // Update data member berdasarkan ID
        if ($model->update($id, $data)) {
            return redirect()->to('/members')->with('success', 'Member berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui member.');
        }
    }

    // Hapus data member
    public function delete($id)
    {
        $model = new MembersModel();

        // Cek apakah member ada sebelum dihapus
        $member = $model->find($id);
        if (!$member) {
            return redirect()->to('/members')->with('error', 'Member tidak ditemukan.');
        }

        // Hapus member berdasarkan ID
        if ($model->delete($id)) {
            return redirect()->to('/members')->with('success', 'Member berhasil dihapus.');
        } else {
            return redirect()->to('/members')->with('error', 'Gagal menghapus member.');
        }
    }
}
