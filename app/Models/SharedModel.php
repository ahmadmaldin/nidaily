<?php

namespace App\Models;

use CodeIgniter\Model;

class ShareModel extends Model
{
    protected $table = 'shared'; // Nama tabel yang benar
    protected $primaryKey = 'id_shared'; // Primary key yang benar

    protected $useAutoIncrement = true;
    protected $returnType = 'array'; // Bisa juga 'object' jika diinginkan
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_task',
        'id_user',
        'shared_by_user_id',
        'accepted',
        'share_date',
        'accept_date',
    ];

    protected $useTimestamps = false; // Tidak menggunakan timestamps otomatis, karena sudah pakai default current_timestamp

    // Validasi otomatis
    protected $validationRules = [
        'id_task'            => 'required|integer',
        'id_user'            => 'required|integer',
        'shared_by_user_id'  => 'required|integer',
        'accepted'           => 'in_list[yes,no,pending]',
    ];
}
