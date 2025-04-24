<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<!-- Page Title -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4"><?= esc($title) ?></h2>
        </div>
    </div>
</div>

<!-- Error Handling -->
<?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Form Input -->
<form action="<?= site_url('groups/store'); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    
        <div class="card-body">
            <!-- Input untuk Nama Grup -->
            <div class="form-group">
                <label for="group_name">Nama Grup</label>
                <input type="text" name="group_name" id="group_name" class="form-control" value="<?= old('group_name') ?>" required>
            </div>

            <!-- Textarea untuk Deskripsi Grup -->
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description" class="form-control"><?= old('description') ?></textarea>
            </div>

            <!-- Input untuk Foto Grup -->
            <div class="form-group">
                <label for="photo">Foto Grup</label>
                <input type="file" name="photo" id="photo" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="<?= site_url('groups'); ?>" class="btn btn-inverse-secondary btn-fw">Kembali</a>

        </div>
    
</form>
<!-- Link untuk kembali ke daftar grup -->

<?= $this->endSection(); ?>
