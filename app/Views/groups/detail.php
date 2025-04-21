<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h1><?= esc($title) ?></h1>

<!-- Menampilkan pesan sukses jika ada -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Tombol kembali ke daftar grup -->
<a href="<?= base_url('groups') ?>" class="btn btn-secondary mb-3">← Kembali ke Daftar Grup</a>

<!-- Informasi Grup -->
<h3>Nama Grup: <?= esc($group['group_name']) ?></h3>
<p><strong>Dibuat oleh:</strong> <?= esc($group['creator_name'] ?? 'Tidak diketahui') ?></p>
<p><strong>Tanggal Buat:</strong> <?= date('d-m-Y H:i', strtotime($group['created_date'])) ?></p>
<p><strong>Deskripsi:</strong> <?= esc($group['description']) ?></p>

<!-- Menampilkan foto grup -->
<?php if (!empty($group['photo'])) : ?>
    <img src="<?= base_url('uploads/groups/' . $group['photo']) ?>" alt="Foto Grup" style="max-width: 200px;">
<?php else : ?>
    <p>Tidak ada foto grup</p>
<?php endif; ?>

<hr>

<!-- Tombol Tambah Member jika user adalah pembuat grup -->
<?php if ($sessionUserId == $group['created_by']) : ?>
    <a href="<?= base_url('groups/addMember/' . $group['id_groups']) ?>" class="btn btn-success mb-3">Tambah Member</a>
<?php endif; ?>

<!-- Tabel Daftar Member -->
<h3>Daftar Member</h3>
<?php if (!empty($members)) : ?>
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th>ID User</th>
                <th>Nama User</th>
                <th>Level Member</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $member) : ?>
                <tr>
                    <td><?= esc($member['user_id']) ?></td>
                    <td><?= esc($member['username']) ?></td>
                    <td><?= esc($member['member_level']) ?></td>
                    <td>
                        <a href="<?= site_url('groups/removeMember/' . $group['id_groups'] . '/' . $member['user_id']); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus member ini dari grup?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Tidak ada member di grup ini.</p>
<?php endif; ?>

<!-- Tombol kembali ke daftar grup di bawah juga (opsional) -->
<a href="<?= base_url('groups') ?>" class="btn btn-secondary mt-3">← Kembali ke Daftar Grup</a>

<?= $this->endSection(); ?>
