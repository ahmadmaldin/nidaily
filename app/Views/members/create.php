<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h2>Tambah Member</h2>

<form action="<?= site_url('members/store'); ?>" method="post">
    <?= csrf_field(); ?>

    <label>ID Grup:</label><br>
    <input type="number" name="id_groups" required><br><br>

    <label>User ID:</label><br>
    <input type="number" name="user_id" required><br><br>

    <label>Level:</label><br>
    <select name="member_level" required>
        <option value="admin">Admin</option>
        <option value="member">Member</option>
    </select><br><br>

    <button type="submit">Simpan</button>
</form>

<?= $this->endSection(); ?>
