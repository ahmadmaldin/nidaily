<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<body>
    <h2>Edit User</h2>
    <form action="<?= base_url('/user/update/' . $user['id_user']) ?>" method="post" enctype="multipart/form-data">
        <label>Nama:</label>
        <input type="text" name="username" value="<?= $user['username'] ?>" required>
        <label>Password (kosongkan jika tidak ingin mengubah):</label>
        <input type="password" name="password">
        <br>
        <label>Foto:</label>
        <input type="file" name="photo">
        <br>
        <button type="submit">Update</button>
    </form>
</body>
<?= $this->endSection(); ?>