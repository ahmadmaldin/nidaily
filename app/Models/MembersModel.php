<?php

namespace App\Models;

use CodeIgniter\Model;

class MembersModel extends Model
{
    
    // Nama tabel di database
    protected $table            = 'members';
    // Primary key dari tabel
    protected $primaryKey       = 'id_members';
    // Auto increment aktif
    protected $useAutoIncrement = true;
    // Tidak menggunakan timestamps (created_at, updated_at)
    protected $useTimestamps    = false;
    // Kolom yang diizinkan untuk diinsert atau update
    protected $allowedFields = [
        'id_groups',    // ID grup
        'user_id',      // ID pengguna
        'member_level', // Level member (admin/member)
    ];

    // Validasi otomatis untuk input
    protected $validationRules = [
        'id_groups'    => 'required|integer',
        'user_id'      => 'required|integer',
        'member_level' => 'required|in_list[admin,member]',
    ];

    // Pesan validasi untuk setiap kolom
    protected $validationMessages = [
        'id_groups' => [
            'required' => 'ID grup wajib diisi.',
            'integer'  => 'ID grup harus berupa angka.',
        ],
        'user_id' => [
            'required' => 'User ID wajib diisi.',
            'integer'  => 'User ID harus berupa angka.',
        ],
        'member_level' => [
            'required'  => 'Level member wajib diisi.',
            'in_list'   => 'Level member hanya boleh admin atau member.',
        ],
    ];

    // Relasi dengan tabel 'groups'
    public function getGroup($id_groups)
    {
        return $this->db->table('groups')
                        ->where('id_groups', $id_groups)
                        ->get()
                        ->getRowArray();
    }

    // Relasi dengan tabel 'users' untuk mendapatkan data user
    public function getUser($user_id)
    {
        return $this->db->table('users')
                        ->where('id', $user_id)
                        ->get()
                        ->getRowArray();
    }

    // Mendapatkan semua member dalam grup tertentu
    public function getMembersByGroup($id_groups)
    {
        return $this->where('id_groups', $id_groups)->findAll();
    }
    
}
