<?php

namespace App\Models;

use CodeIgniter\Model;

class FriendshipModel extends Model
{
    protected $table = 'friendship';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_user', 'id_friend', 'status'];

    // Menambahkan permintaan pertemanan
    public function addFriendRequest($userId, $friendId)
    {
        $data = [
            'id_user' => $userId,
            'id_friend' => $friendId,
            'status' => 'pending',
        ];

        return $this->insert($data);
    }

    // Mendapatkan daftar teman (yang sudah accepted), dengan informasi username dari tabel user
    public function getFriends($userId)
    {
        return $this->select('user.username, user.photo, friendship.*')
            ->join('user', 'user.id_user = IF(friendship.id_user = ' . $userId . ', friendship.id_friend, friendship.id_user)')
            ->where('friendship.status', 'accepted')
            ->groupStart()
                ->where('friendship.id_user', $userId)
                ->orWhere('friendship.id_friend', $userId)
            ->groupEnd()
            ->findAll();
    }

    // Mendapatkan daftar permintaan masuk yang pending (dikirim ke user login)
    public function getFriendRequests($userId)
    {
        return $this->select('user.username, user.photo, friendship.*')
            ->join('user', 'user.id_user = friendship.id_user')
            ->where('friendship.id_friend', $userId)
            ->where('friendship.status', 'pending')
            ->findAll();
    }

    // Mendapatkan daftar permintaan pertemanan yang dikirim user login dan masih pending
    public function getSentRequests($userId)
    {
        return $this->select('user.username, user.photo, friendship.*')
            ->join('user', 'user.id_user = friendship.id_friend')
            ->where('friendship.id_user', $userId)
            ->where('friendship.status', 'pending')
            ->findAll();
    }

    // Menerima permintaan pertemanan
    public function acceptFriendRequest($requestId)
    {
        return $this->update($requestId, ['status' => 'accepted']);
    }

    // Menolak permintaan pertemanan
    public function declineFriendRequest($requestId)
    {
        return $this->delete($requestId);
    }

    // Menghapus pertemanan berdasarkan ID pertemanan
    public function removeFriendById($friendshipId)
    {
        return $this->delete($friendshipId);
    }
}
