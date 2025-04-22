<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h1><?= esc($title) ?></h1>

<!-- Menampilkan pesan sukses jika ada -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Link untuk tambah grup -->
<a href="<?= base_url('groups/create') ?>" class="btn btn-primary">Tambah Grup</a><br><br>

<!-- Tabel Daftar Grup -->
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Grup</th>
            <th>Dibuat Oleh</th>
            <th>Tanggal Buat</th>
            <th>Deskripsi</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($groups) : ?>
            <?php foreach ($groups as $group) : ?>
                <tr>
                    <td><?= esc($group['id_groups']) ?></td>
                    <td><?= esc($group['group_name']) ?></td>
                    <td><?= esc($group['creator_name']) ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($group['created_date'])) ?></td>
                    <td><?= esc($group['description']) ?></td>
                    <td>
                        <?php if (!empty($group['photo'])) : ?>
                            <img src="<?= base_url('uploads/groups/' . $group['photo']) ?>" alt="Foto Grup" style="max-width: 100px;" class="img-fluid rounded">
                        <?php else : ?>
                            <p>Tidak ada foto</p>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= site_url('groups/edit/' . $group['id_groups']); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= site_url('groups/' . $group['id_groups'] . '/detail'); ?>" class="btn btn-sm btn-info">Detail</a>
                        <a href="<?= site_url('groups/delete/' . $group['id_groups']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus grup ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else : ?>
            <tr><td colspan="7">Tidak ada grup ditemukan.</td></tr>
        <?php endif ?>
    </tbody>
</table>

<?= $this->endSection(); ?>
