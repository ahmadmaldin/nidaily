<?php

namespace App\Models;

use CodeIgniter\Model;

class MembersModel extends Model
{
    
    protected $table            = 'members';
    protected $primaryKey       = 'id_members';
    protected $useAutoIncrement = true;
    protected $useTimestamps    = false;
    protected $allowedFields = [
        'id_groups',   
        'id_user',      
        'member_level', 
    ];

    // Validasi otomatis untuk input
    protected $validationRules = [
        'id_groups'    => 'required|integer',
        'id_user'      => 'required|integer',
        'member_level' => 'required|in_list[admin,member]',
    ];

    // Pesan validasi untuk setiap kolom
    protected $validationMessages = [
        'id_groups' => [
            'required' => 'ID grup wajib diisi.',
            'integer'  => 'ID grup harus berupa angka.',
        ],
        'id_user' => [
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
    public function getUser($id_user)
    {
        return $this->db->table('users')
                        ->where('id', $id_user)
                        ->get()
                        ->getRowArray();
    }

    // Mendapatkan semua member dalam grup tertentu
    public function getMembersByGroup($id_groups)
    {
        return $this->where('id_groups', $id_groups)->findAll();
    }
    
}
