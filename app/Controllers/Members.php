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
        $data['members'] = $model->findAll();
        return view('members/index', $data);  // Menampilkan daftar member
    }

    // Tampilkan form untuk menambah member
    public function create()
    {
        return view('members/create');  // Menampilkan form tambah member
    }

    // Menyimpan data member baru
    public function store()
    {
        $model = new MembersModel();
        
        // Validasi input
        if (!$this->validate([
            'id_groups'    => 'required|integer',
            'user_id'      => 'required|integer',
            'member_level' => 'required|in_list[admin,member]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Data yang akan dimasukkan ke dalam tabel
        $data = [
            'id_groups'    => $this->request->getPost('id_groups'),
            'user_id'      => $this->request->getPost('user_id'),
            'member_level' => $this->request->getPost('member_level'),
        ];

        // Insert data ke database
        $model->insert($data);

        return redirect()->to('/members')->with('success', 'Member berhasil ditambahkan.');
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
            'user_id'      => 'required|integer',
            'member_level' => 'required|in_list[admin,member]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Data yang akan diperbarui
        $data = [
            'id_groups'    => $this->request->getPost('id_groups'),
            'user_id'      => $this->request->getPost('user_id'),
            'member_level' => $this->request->getPost('member_level'),
        ];

        // Update data member berdasarkan ID
        $model->update($id, $data);

        return redirect()->to('/members')->with('success', 'Member berhasil diperbarui.');
    }

    // Hapus data member
    public function delete($id)
    {
        $model = new MembersModel();
        $model->delete($id);  // Menghapus member berdasarkan ID
        return redirect()->to('/members')->with('success', 'Member berhasil dihapus.');
    }
}
