<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ShareModel;

class Share extends BaseController
{
    protected $shareModel;

    public function __construct()
    {
        $this->shareModel = new ShareModel();
    }

    // Tampilkan semua data
    public function index()
    {
        $data['sharedTasks'] = $this->shareModel->findAll();
        return view('share/index', $data);
    }

    // Tampilkan form create
    public function create()
    {
        return view('share/create');
    }

    // Simpan data baru
    public function store()
    {
        $shareModel = new \App\Models\ShareModel();
    
        $data = [
            'id_task' => $this->request->getPost('id_task'),
            'id_user' => $this->request->getPost('id_user'),
            'shared_by_user_id' => $this->request->getPost('shared_by_user_id')
        ];
    
        if ($shareModel->insert($data)) {
            return redirect()->back()->with('success', 'Tugas berhasil dibagikan!');
        } else {
            return redirect()->back()->with('error', 'Gagal membagikan tugas.');
        }
    }
    


    // Tampilkan form edit
    public function edit($id)
    {
        $data['share'] = $this->shareModel->find($id);

        if (!$data['share']) {
            return redirect()->to('/share')->with('error', 'Data tidak ditemukan.');
        }

        return view('share/edit', $data);
    }

    // Simpan perubahan data
    public function update($id)
    {
        $validationRules = [
            'id_task'           => 'required|integer',
            'id_user'           => 'required|integer',
            'shared_by_user_id' => 'required|integer',
            'accepted'          => 'in_list[yes,no,pending]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->shareModel->update($id, [
            'id_task'           => $this->request->getPost('id_task'),
            'id_user'           => $this->request->getPost('id_user'),
            'shared_by_user_id' => $this->request->getPost('shared_by_user_id'),
            'accepted'          => $this->request->getPost('accepted'),
            'accept_date'       => $this->request->getPost('accepted') == 'yes' ? date('Y-m-d H:i:s') : null,
        ]);

        return redirect()->to('/share')->with('success', 'Data berhasil diperbarui.');
    }

    // Hapus data
    public function delete($id)
    {
        $this->shareModel->delete($id);
        return redirect()->to('/share')->with('success', 'Data berhasil dihapus.');
    }
}
