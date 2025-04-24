<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h2><?= esc($title) ?></h2>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Kolom Foto -->
            <div class="col-md-4 text-center">
                <p><strong>Foto Profil</strong></p>
                <?php if ($user['photo']): ?>
                    <img src="<?= base_url('public/uploads/user/' . $user['photo']) ?>" class="rounded-circle" width="200">
                <?php else: ?>
                    <span>Belum ada foto</span>
                <?php endif; ?>
            </div>

            <!-- Kolom Data User -->
            <div class="col-md-8">
                <p><strong>Nama:</strong> <?= esc($user['username']) ?></p>
                <p><strong>Password:</strong> 
                    <?php if (!empty($user['password'])): ?>
                        <span>Sudah diatur</span>
                    <?php else: ?>
                        <span>Belum diatur</span>
                    <?php endif; ?>
                </p>
                <a href="<?= base_url('/user/edit/' . $user['id_user']) ?>" class="btn btn-warning">Edit Profil</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
