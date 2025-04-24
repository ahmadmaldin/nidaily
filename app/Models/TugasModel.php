<?php
namespace App\Models;

use CodeIgniter\Model;

class TugasModel extends Model
{
    protected $table = 'tugas'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key
    protected $useTimestamps = false; // Tidak menggunakan field timestamps
    protected $allowedFields = [
        'tugas', 'tanggal', 'waktu', 'status', 'alarm', 'created', 'date_due', 'time_due', 
        'date_finished', 'time_finished', 'creator_id'
    ]; // Fields yang bisa di-insert atau di-update

    // Method untuk mengambil tugas beserta nama creator
    public function getTaskWithCreator($taskId)
    {
        return $this->select('tugas.*, users.name as creator_name')
                    ->join('users', 'users.id = tugas.creator_id')
                    ->where('tugas.id', $taskId)
                    ->first(); // Ambil data tugas beserta nama creator
    }

    // Method untuk mengambil tugas yang diberikan kepada user atau tugas milik user
    public function getTugasForUser($userId)
    {
        return $this->select('tugas.*')
                    ->join('shared', 'tugas.id = shared.id_tugas', 'left') // Ganti 'share' dengan 'shared'
                    ->where('tugas.creator_id', $userId)
                    ->orWhere('shared.id_user', $userId) // Pastikan nama kolomnya benar, seperti 'id_user'
                    ->groupBy('tugas.id')
                    ->findAll(); // Menggunakan query builder CodeIgniter untuk hasil yang lebih rapi
    }
}
