<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SharedModel;
use App\Models\MemberModel;
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

        // Cek apakah sudah pernah dibagikan
        $alreadyShared = $this->sharedModel
            ->where('id_tugas', $id_tugas)
            ->where('id_user', $id_user)
            ->first();

        if ($alreadyShared) {
            return redirect()->back()->with('error', 'Tugas sudah dibagikan sebelumnya.');
        }

        $this->sharedModel->save([
            'id_tugas'           => $id_tugas,
            'id_user'           => $id_user,
            'shared_by_user_id' => $shared_by_user_id,
            'accepted'          => 'pending',
            'share_date'        => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil dibagikan.');
    }

    // Share ke grup
    public function shareToGroup($id_tugas)
    {
        $groupId = $this->request->getPost('idgroups');
        $memberModel = new MemberModel();
        $members = $memberModel->where('idgroups', $groupId)->findAll();

        $currentUserId = session()->get('id');

        foreach ($members as $member) {
            $targetUserId = $member['iduser'];
            if ($targetUserId == $currentUserId) continue;

            $alreadyShared = $this->sharedModel
                ->where('id_tugas', $id_tugas)
                ->where('id_user', $targetUserId)
                ->first();

            if (!$alreadyShared) {
                $this->sharedModel->save([
                    'id_tugas'           => $id_tugas,
                    'id_user'           => $targetUserId,
                    'shared_by_user_id' => $currentUserId,
                    'accepted'          => 'pending',
                    'share_date'        => date('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->to('tugas/detail/' . $id_tugas)->with('success', 'Tugas berhasil dibagikan ke grup.');
    }

    // Hapus sharing
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

    // Update status accepted
    public function updateStatusNext($id)
    {
        $shared = $this->sharedModel->find($id);

        if (!$shared) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
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

        return redirect()->back()->with('success', 'Status updated menjadi: ' . ucfirst($nextStatus));
    }
}
