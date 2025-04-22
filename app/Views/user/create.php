<body>
    <h2>Buat Akun</h2>
    <form action="<?= base_url('/user/store') ?>" method="post" enctype="multipart/form-data">
        <label>Nama:</label>
        <input type="text" name="username" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <label>Foto:</label>
        <input type="file" name="photo">
        <br>
        <button type="submit">Simpan</button>
    </form>
</body>