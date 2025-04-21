<?php

namespace App\Controllers;

use App\Models\AttachmentModel;
use CodeIgniter\Controller;

class Attachment extends Controller
{
    protected $AttachmentModel;

    public function __construct()
    {
        $this->AttachmentModel = new AttachmentModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $perPage = 10;

        if ($keyword) {
            $attachment = $this->AttachmentModel->like('description', $keyword)
                                                 ->orLike('type', $keyword)
                                                 ->paginate($perPage);
        } else {
            $attachment = $this->AttachmentModel->paginate($perPage);
        }

        $data = [
            'title'      => 'Data Attachment',
            'attachment' => $attachment,
            'pager'      => $this->AttachmentModel->pager,
            'keyword'    => $keyword
        ];
        return view('attachment/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Attachment',
        ];
        return view('attachment/create', $data);
    }

    public function store()
    {
        $data = [
            'id_tugas'    => $this->request->getPost('id_tugas'),
            'type'        => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'file'        => $this->uploadfile()
        ];

        $this->AttachmentModel->save($data);

        return redirect()->to('/attachment')->with('success', 'Attachment berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Attachment',
            'attachment' => $this->AttachmentModel->find($id)
        ];

        return view('attachment/edit', $data);
    }

    public function update($id_attachment)
    {
        $data = [
            'id_tugas'    => $this->request->getPost('id_tugas'),
            'type'        => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
        ];

        if ($file = $this->uploadfile()) {
            $data['file'] = $file;
        }

        $this->AttachmentModel->update($id_attachment, $data);

        return redirect()->to('/attachment')->with('success', 'Data attachment berhasil diperbarui.');
    }

    public function delete($id_attachment)
    {
        $this->AttachmentModel->delete($id_attachment);
        return redirect()->to('/attachment')->with('success', 'Data attachment berhasil dihapus.');
    }

    private function uploadfile()
    {
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/attachment/', $newName);
            return $newName;
        }
        return null;
    }
}
