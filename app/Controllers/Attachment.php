<?php

namespace App\Controllers;

use App\Models\AttachmentModel;
use CodeIgniter\Controller;

class Attachment extends Controller
{
    protected $attachmentModel;

    public function __construct()
    {
        $this->attachmentModel = new AttachmentModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $perPage = 10;

        if ($keyword) {
            $attachment = $this->attachmentModel->like('description', $keyword)
                                                ->orLike('type', $keyword)
                                                ->paginate($perPage);
        } else {
            $attachment = $this->attachmentModel->paginate($perPage);
        }

        $data = [
            'title'      => 'Data Attachment',
            'attachment' => $attachment,
            'pager'      => $this->attachmentModel->pager,
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
        $file = $this->request->getFile('file');
        $id_tugas = $this->request->getPost('id_tugas');
    
        $fileName = null;
    
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('public/uploads/attachment/', $fileName); // Pastikan ini ke public/
        }
    
        $this->attachmentModel->save([
            'id_tugas'    => $id_tugas,
            'type'        => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'file'        => $fileName, // bisa null jika tidak upload file
        ]);
    
        return redirect()->to('/tugas/detail/' . $id_tugas)->with('success', 'Attachment berhasil ditambahkan.');
    }
    


    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Attachment',
            'attachment' => $this->attachmentModel->find($id)
        ];

        return view('attachment/edit', $data);
    }

    public function update($id)
    {
        $attachment = $this->attachmentModel->find($id);
        $file = $this->request->getFile('file');
        $id_tugas = $this->request->getPost('id_tugas');

        $data = [
            'id_tugas'    => $id_tugas,
            'type'        => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus file lama jika ada
            if (!empty($attachment['file']) && file_exists('uploads/attachment/' . $attachment['file'])) {
                unlink('uploads/attachment/' . $attachment['file']);
            }

            // Upload file baru
            $fileName = $file->getRandomName();
            $file->move('uploads/attachment/', $fileName);
            $data['file'] = $fileName;
        }

        // Update data attachment
        $this->attachmentModel->update($id, $data);

        return redirect()->to('/tugas/detail/' . $id_tugas)->with('success', 'Attachment berhasil diperbarui.');
    }

    public function delete($id)
    {
        $attachment = $this->attachmentModel->find($id);
        $id_tugas = $attachment['id_tugas'] ?? null;

        if ($attachment) {
            // Hapus file fisik jika ada
            if (!empty($attachment['file'])) {
                $filePath = 'uploads/attachment/' . $attachment['file'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus data attachment dari database
            $this->attachmentModel->delete($id);
        }

        return redirect()->to('/tugas/detail/' . $id_tugas)->with('success', 'Attachment berhasil dihapus.');
    }
}
