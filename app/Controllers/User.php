<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class User extends Controller
{
    protected $UserModel;

    public function __construct()
    {
        $this->UserModel = new UserModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $perPage = 10;

        if ($keyword) {
            $user = $this->UserModel->search($keyword, $perPage);
        } else {
            $user = $this->UserModel->paginate($perPage);
        }

        $data = [
            'title'   => 'Data User',
            'user'    => $user,
            'pager'   => $this->UserModel->pager,
            'keyword' => $keyword,
        ];

        return view('user/index', $data);
    }

    public function create()
    {
        return view('user/create', ['title' => 'Buat Akun']);
    }

    public function store()
    {
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'level'    => 'user', // default level kalau belum diset di form
            'photo'    => $this->uploadPhoto()
        ];

        $this->UserModel->insert($data);

        return redirect()->to('/login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit User',
            'user'  => $this->UserModel->find($id),
        ];

        return view('user/edit', $data);
    }

    public function update($id_user)
{
    $model = new UserModel();
    $user = $model->find($id_user);

    $password = $this->request->getPost('password') 
        ? password_hash($this->request->getPost('password'), PASSWORD_DEFAULT) 
        : $user['password'];

    $data = [
        'username' => $this->request->getPost('username'),
        'level' => $this->request->getPost('level'),
        'password' => $password
    ];

    if ($photo = $this->uploadphoto()) {
        $data['photo'] = $photo;
    }

    $model->update($id_user, $data);

    // Cek apakah user yang login adalah yang sedang diedit
    if (session()->get('id_user') == $id_user) {
        return redirect()->to('/profile')->with('success', 'Akun kamu berhasil diperbarui.');
    } else {
        return redirect()->to('/user')->with('success', 'Data user berhasil diperbarui.');
    }
}


    public function delete($id_user)
    {
        $this->UserModel->delete($id_user);
        return redirect()->to('/user')->with('success', 'Data user berhasil dihapus.');
    }

    private function uploadPhoto()
    {
        $file = $this->request->getFile('photo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('public/uploads/user/', $newName); // sesuaikan path jika berbeda
            return $newName;
        }
        return null;
    }
    public function profile()
{
    $userId = session()->get('id_user');
    $model = new UserModel();
    
    // Ambil data user berdasarkan id_user yang ada di session
    $data['user'] = $model->find($userId);
    $data['title'] = 'Profil Pengguna';

    return view('user/profile', $data);
}

}
