<?php

namespace App\Models;

use CodeIgniter\Model;

class MembersModel extends Model
{
    protected $table            = 'members';           // Nama tabel
    protected $primaryKey       = 'id_members';       // Primary key
    protected $useAutoIncrement = true;               // Menggunakan auto increment
    protected $useTimestamps    = false;              // Tidak menggunakan timestamp otomatis
    protected $allowedFields    = [
        'id_groups',   
        'id_user',      
        'member_level', 
    ];

    // Mengatur tipe pengembalian data
    protected $returnType = 'array'; // Mengembalikan hasil query dalam bentuk array

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

    /**
     * Mendapatkan data grup berdasarkan ID grup
     *
     * @param int $id_groups
     * @return array
     */
    public function getGroup($id_groups)
    {
        return $this->db->table('groups')
                        ->where('id_groups', $id_groups)
                        ->get()
                        ->getRowArray();
    }

    /**
     * Mendapatkan data user berdasarkan ID user
     *
     * @param int $id_user
     * @return array
     */
    public function getUser($id_user)
    {
        return $this->db->table('users')
                        ->where('id_user', $id_user)
                        ->get()
                        ->getRowArray();
    }

    /**
     * Mendapatkan semua anggota dalam grup tertentu
     *
     * @param int $id_groups
     * @return array
     */
    public function getMembersByGroup($id_groups)
    {
        // Menggunakan query builder untuk mengambil data anggota dan username dari tabel users
        return $this->select('members.*, users.username') // Mengambil data anggota dan username
                    ->join('users', 'users.id_user = members.id_user') // Melakukan join dengan tabel users
                    ->where('members.id_groups', $id_groups) // Filter berdasarkan ID grup
                    ->findAll(); // Mengembalikan semua anggota grup
    }
}
