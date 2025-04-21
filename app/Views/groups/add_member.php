<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h1><?= esc($title) ?></h1>

<!-- Menampilkan pesan sukses jika ada -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('groups/storeMember/' . $group['id_groups']); ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="user_id">Pilih User:</label>
        <select name="user_id" id="user_id" class="form-control">
            <?php foreach ($users as $user) : ?>
                <option value="<?= esc($user['id_user']) ?>"><?= esc($user['username']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="member_level">Level Member:</label>
        <select name="member_level" id="member_level" class="form-control">
            <option value="member">Member</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Tambah Member</button>
</form>

<?= $this->endSection(); ?>
