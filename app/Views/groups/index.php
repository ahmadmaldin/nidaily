<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h4 class="mb-3"><?= esc($title) ?></h4>

<!-- Pesan sukses -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Tombol tambah grup -->
<a href="<?= base_url('groups/create') ?>" class="btn btn-inverse-primary btn-fw mb-3">Tambah Group</a>

<!-- Tabel grup -->
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nama Group</th>
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
                                <img src="<?= base_url('public/uploads/groups/' . $group['photo']) ?>" alt="Foto Grup" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                            <?php else : ?>
                                <span class="text-muted">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td>
    <a href="<?= site_url('groups/edit/' . $group['id_groups']); ?>" class="btn btn-sm btn-warning" title="Edit">
        <i class="fa-solid fa-pen-to-square"></i> Edit
    </a>
    <a href="<?= site_url('groups/' . $group['id_groups'] . '/detail'); ?>" class="btn btn-sm btn-info" title="Detail">
        <i class="fa-solid fa-info-circle"></i> Detail
    </a>
    <a href="<?= site_url('groups/delete/' . $group['id_groups']); ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus grup ini?');">
        <i class="fa-solid fa-trash"></i> Hapus
    </a>
</td>

                    </tr>
                <?php endforeach ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada grup ditemukan.</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
