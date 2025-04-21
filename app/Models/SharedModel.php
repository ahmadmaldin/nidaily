<?php

namespace App\Models;

use CodeIgniter\Model;

class SharedModel extends Model
{
    protected $table = 'shared';
    protected $primaryKey = 'id_shared';

    protected $allowedFields = [
        'id_task',
        'id_user',
        'shared_by_user_id',
        'accepted',
        'share_date',
        'accept_date',
    ];

    public $useTimestamps = false;
}
