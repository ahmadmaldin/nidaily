<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h1><?= esc($title) ?></h1>

<!-- Menampilkan error jika ada -->
<?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('/groups/update/' . $group['id_groups']); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- Input untuk Nama Grup -->
    <label for="group_name">Nama Grup:</label>
    <input type="text" name="group_name" id="group_name" value="<?= esc($group['group_name']) ?>" required><br><br>

    <!-- Input untuk Password Grup -->
    <label for="password">Password Baru (kosongkan jika tidak diubah):</label>
    <input type="password" name="password" id="password"><br><br>

    <!-- Textarea untuk Deskripsi Grup -->
    <label for="description">Deskripsi:</label><br>
    <textarea name="description" id="description"><?= esc($group['description']) ?></textarea><br><br>

    <!-- Input untuk Ganti Foto Grup -->
    <label for="photo">Ganti Foto Grup:</label>
    <input type="file" name="photo" id="photo"><br><br>

    <!-- Menampilkan foto grup lama jika ada -->
    <?php if (!empty($group['photo'])) : ?>
        <p>Foto Grup Sekarang:</p>
        <img src="<?= base_url('uploads/' . $group['photo']); ?>" alt="Foto Grup" style="max-width: 200px;">
        <br><br>
    <?php endif; ?>

    <button type="submit">Update</button>
</form>

<a href="<?= site_url('groups'); ?>">← Kembali ke daftar grup</a>

<?= $this->endSection(); ?>
