<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <div class="col-md-12">
    <h4 class="mb-3"><?= esc($title) ?></h4>

    <!-- Menampilkan Error jika ada -->
    <?php if (isset($errors)) : ?>
      <div class="alert alert-danger">
        <ul>
          <?php foreach ($errors as $error) : ?>
            <li><?= esc($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('groups/store') ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="form-group">
        <label for="group_name">Nama Grup</label>
        <input type="text" name="group_name" id="group_name" class="form-control" value="<?= old('group_name') ?>" required>
      </div>

      <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea name="description" id="description" class="form-control"><?= old('description') ?></textarea>
      </div>

      <div class="form-group">
        <label for="password">Password (Opsional)</label>
        <input type="password" name="password" id="password" class="form-control">
      </div>

      <div class="form-group">
        <label for="photo">Foto Grup (Opsional)</label>
        <input type="file" name="photo" id="photo" class="form-control">
      </div>

      <button type="submit" class="btn btn-success">Tambah Grup</button>
    </form>
  </div>
</div>

<?= $this->endSection(); ?>
