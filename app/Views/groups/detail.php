<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div class="col-md-12">
       

        <!-- Foto grup -->
        <?php if (!empty($group['photo'])) : ?>
            <div class="text-center mb-4">
                <img src="<?= base_url('public/uploads/groups/' . $group['photo']) ?>" alt="Foto Grup" class="img-fluid rounded" style="max-height: 300px;">
            </div>
        <?php else : ?>
            <div class="text-center mb-4">
                <p class="text-muted">Tidak ada foto grup</p>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Informasi Grup</h5>
                <p><strong>Nama Grup:</strong> <?= esc($group['group_name']) ?></p>
                <p><strong>Dibuat oleh:</strong> <?= esc($group['creator_name'] ?? 'Tidak diketahui') ?></p>
                <p><strong>Tanggal Buat:</strong> <?= date('d-m-Y H:i', strtotime($group['created_date'])) ?></p>
                <p><strong>Deskripsi:</strong><br><?= esc($group['description']) ?></p>
            </div>
        </div>

        <!-- Form Tambah Member -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Tambah Member</h5>
                <?php if ($sessionUserId == $group['created_by']) : ?>
                    <form action="<?= base_url('groups/storeMember/' . $group['id_groups']) ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="id_user">Pilih User</label>
                            <select name="id_user" id="id_user" class="form-control" required>
                                <option value="">-- Pilih User --</option>
                                <?php foreach ($users as $user) : ?>
                                    <option value="<?= esc($user['id_user']) ?>"><?= esc($user['username']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="member_level">Pilih Level Member</label>
                            <select name="member_level" id="member_level" class="form-control" required>
                                <option value="member">Member</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Member</button>
                    </form>
                <?php else : ?>
                    <p class="text-muted">Anda bukan pembuat grup dan tidak dapat menambah member.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Daftar Member -->
        <div class="card">
            <div class="card-body">
                 <!-- Notifikasi sukses -->
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
                <h5 class="card-title">Daftar Member</h5>

                <?php if (!empty($members)) : ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID User</th>
                                    <th>Nama User</th>
                                    <th>Level Member</th>
                                    <?php if ($sessionUserId == $group['created_by']) : ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($members as $member) : ?>
    <tr>
        <td><?= esc($member['id_user']) ?></td>
        <td><?= esc($member['username']) ?></td> <!-- Menampilkan username -->
        <td><?= esc($member['member_level']) ?></td>
        <?php if ($sessionUserId == $group['created_by']) : ?>
            <td>
                <a href="<?= site_url('groups/removeMember/' . $group['id_groups'] . '/' . $member['id_user']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus member ini?');">Hapus</a>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="text-muted">Belum ada member dalam grup ini.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <a href="<?= base_url('groups') ?>" class="btn btn-secondary mt-4">Kembali</a>
    </div>
</div>

<?= $this->endSection(); ?>
