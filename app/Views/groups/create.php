<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h1><?= esc($title) ?></h1>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('groups/store'); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <!-- Input untuk Nama Grup -->
    <label for="group_name">Nama Grup:</label>
    <input type="text" name="group_name" id="group_name" value="<?= old('group_name') ?>" required><br><br>

    <!-- Input untuk Password Grup -->
    <label for="password">Password Grup (Opsional):</label>
    <input type="password" name="password" id="password" value="<?= old('password') ?>"><br><br>

    <!-- Textarea untuk Deskripsi Grup -->
    <label for="description">Deskripsi:</label><br>
    <textarea name="description" id="description"><?= old('description') ?></textarea><br><br>

    <!-- Input untuk Foto Grup -->
    <label for="photo">Foto Grup:</label>
    <input type="file" name="photo" id="photo"><br><br>

    <button type="submit">Simpan</button>
</form>

<!-- Link untuk kembali ke daftar grup -->
<a href="/groups">← Kembali ke daftar grup</a>

<?= $this->endSection(); ?>
