<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SharedModel;
use App\Models\MemberModel;
use App\Models\TugasModel;
use App\Models\UserModel;
use App\Models\GroupsModel;

class Shared extends BaseController
{
    protected $sharedModel;

    public function __construct()
    {
        $this->sharedModel = new SharedModel();
    }

    // Menyimpan data sharing tugas ke user
    public function store()
    {
        $id_tugas = $this->request->getPost('id_tugas');
        $id_user = $this->request->getPost('id_user');
        $shared_by_user_id = session()->get('id');

        // Cek apakah sudah pernah dibagikan sebelumnya
        $alreadyShared = $this->sharedModel
            ->where('id_tugas', $id_tugas)
            ->where('id_user', $id_user)
            ->first();

        if ($alreadyShared) {
            return redirect()->back()->with('error', 'Tugas sudah pernah dibagikan ke user ini.');
        }

        $this->sharedModel->save([
            'id_tugas'           => $id_tugas,
            'id_user'           => $id_user,
            'shared_by_user_id' => $shared_by_user_id,
            'accepted'          => 'pending',
            'share_date'        => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil dibagikan ke user.');
    }

    // Menyimpan data sharing tugas ke semua anggota group
    public function shareToGroup($id_tugas)
    {
        $groupId = $this->request->getPost('id_group');
        $membersModel = new MembersModel();
        $members = $membersModel->where('id_groups', $groupId)->findAll();

        $currentUserId = session()->get('id');

        foreach ($members as $member) {
            $id_user = $member['iduser'];

            // Skip jika user adalah pengirimnya sendiri
            if ($id_user == $currentUserId) {
                continue;
            }

            // Cek apakah sudah dibagikan
            $alreadyShared = $this->sharedModel
                ->where('id_tugas', $id_tugas)
                ->where('id_user', $id_user)
                ->first();

            if (!$alreadyShared) {
                $this->sharedModel->save([
                    'id_tugas'           => $id_tugas,
                    'id_user'           => $id_user,
                    'shared_by_user_id' => $currentUserId,
                    'accepted'          => 'pending',
                    'share_date'        => date('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->to('tugas/detail/' . $id_tugas)->with('success', 'Tugas berhasil dibagikan ke grup.');
    }

    // Menghapus data sharing
    public function delete($id)
    {
        $shared = $this->sharedModel->find($id);

        if ($shared) {
            $id_tugas = $shared['id_tugas'];
            $this->sharedModel->delete($id);
            return redirect()->to('/tugas/detail/' . $id_tugas)->with('success', 'Sharing berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data sharing tidak ditemukan.');
    }

    // Update status accepted dari pending > yes > no > ulangi
    public function updateStatusNext($id)
    {
        $shared = $this->sharedModel->find($id);

        if (!$shared) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $statusList = ['pending', 'yes', 'no'];
        $currentStatus = $shared['accepted'] ?? 'pending';
        $currentIndex = array_search($currentStatus, $statusList);
        $nextIndex = ($currentIndex + 1) % count($statusList);
        $nextStatus = $statusList[$nextIndex];

        $this->sharedModel->update($id, [
            'accepted'    => $nextStatus,
            'accept_date' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Status diperbarui menjadi: ' . ucfirst($nextStatus));
    }
}
