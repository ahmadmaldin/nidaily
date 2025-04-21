<?php

namespace App\Models;

use CodeIgniter\Model;

class AttachmentModel extends Model
{
    protected $table = 'attachment';
    protected $primaryKey = 'id_attachment';
    protected $allowedFields = ['id_tugas', 'type', 'file', 'description'];

    // Opsi tambahan jika perlu
    protected $useTimestamps = false;  // Jika kamu tidak ingin menggunakan created_at, updated_at
    protected $returnType = 'array';
}
