<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <!-- Kolom Form Edit -->
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit User</h4>
                <form action="<?= base_url('/user/update/' . $user['id_user']) ?>" method="post" enctype="multipart/form-data" class="forms-sample">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="username">Nama:</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?= esc($user['username']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password (kosongkan jika tidak ingin mengubah):</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="photo">Ganti Foto:</label>
                        <input type="file" name="photo" id="photo" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                    <a href="<?= base_url('profile') ?>" class="btn btn-light">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Kolom Preview Foto -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Foto Saat Ini</h5>
                <?php if (!empty($user['photo'])): ?>
                    <img src="<?= base_url('public/uploads/user/' . $user['photo']) ?>" alt="Foto saat ini" class="rounded-circle img-fluid" style="max-width: 200px;">
                <?php else: ?>
                    <p class="text-muted">Belum ada foto</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
