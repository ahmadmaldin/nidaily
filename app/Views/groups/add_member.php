<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h2>Tambah Member ke Grup: <?= esc($group['group_name']) ?></h2>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('errors') ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('groups/storeMember/' . $group['id_groups']) ?>" method="post">
    <?= csrf_field() ?>
    <div>
        <label for="user_id">Pilih Member:</label>
        <select name="user_id" id="user_id" required>
            <option value="">-- Pilih User --</option>
            <?php foreach ($users as $user) : ?>
                <option value="<?= esc($user['id_user']) ?>"><?= esc($user['username']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="member_level">Level Member:</label>
        <select name="member_level" id="member_level" required>
            <option value="">-- Pilih Level --</option>
            <option value="admin">Admin</option>
            <option value="anggota">Anggota</option>
        </select>
    </div>

    <button type="submit">Tambah Member</button>
</form>


<?= $this->endSection(); ?>
