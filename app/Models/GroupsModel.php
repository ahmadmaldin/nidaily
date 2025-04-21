<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupsModel extends Model
{
    protected $table            = 'groups';              // Nama tabel
    protected $primaryKey       = 'id_groups';           // Primary key
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'group_name',
        'created_by',
        'created_date',
        'photo',
        'password',
        'description',
    ];

    // Optional: Validasi otomatis
    protected $validationRules = [
        'group_name'   => 'required|max_length[100]',
        'created_by'   => 'permit_empty|integer',
        'created_date' => 'permit_empty|valid_date',
        'photo'        => 'permit_empty|string',
        'password'     => 'permit_empty|min_length[6]',
        'description'  => 'permit_empty|string',
    ];

    protected $validationMessages = [
        'group_name' => [
            'required'    => 'Nama grup wajib diisi.',
            'max_length'  => 'Nama grup maksimal 100 karakter.',
        ],
        'password' => [
            'min_length' => 'Password minimal 6 karakter.',
        ],
    ];

    // Menambahkan method untuk mengambil data grup beserta nama creator
    public function getGroupsWithCreatorName()
    {
        return $this->select('groups.*, user.username AS creator_name')
                    ->join('user', 'user.id_user = groups.created_by')  // Pastikan nama tabel 'user' sesuai dengan tabel di database
                    ->findAll();
    }
}
