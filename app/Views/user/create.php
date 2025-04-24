<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buat Akun</title>
    <link rel="stylesheet" href="<?= base_url('assets/vendors/feather/feather.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/ti-icons/css/themify-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/vertical-layout-light/style.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>" />
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">

    <div class="card shadow-sm p-4" style="width: 400px;">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Buat Akun</h3>
            <form action="<?= base_url('/user/store') ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="username" class="form-label">Nama:</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto:</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan</button>
            </form>
        </div>
    </div>

</body>
</html>
