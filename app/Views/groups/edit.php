<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?= esc($title) ?></h4>
        <p class="card-description">Form untuk mengubah data grup</p>

        <?php if (session()->getFlashdata('errors')) : ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form action="<?= site_url('/groups/update/' . $group['id_groups']); ?>" method="post" enctype="multipart/form-data" class="forms-sample">
          <?= csrf_field() ?>

          <div class="form-group">
            <label for="group_name">Nama Grup</label>
            <input type="text" class="form-control" id="group_name" name="group_name" value="<?= esc($group['group_name']) ?>" required>
          </div>

          <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak diubah">
          </div>

          <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= esc($group['description']) ?></textarea>
          </div>

          <div class="form-group">
            <label for="photo">Ganti Foto Grup</label>
            <input type="file" class="form-control-file" id="photo" name="photo">
          </div>

          <button type="submit" class="btn btn-primary mr-2">Update</button>
          <a href="<?= site_url('groups'); ?>" class="btn btn-light">Kembali</a>
        </form>
      </div>
    </div>
  </div>

  <!-- Kolom Foto -->
  <form action="<?= base_url('/groups/store') ?>" method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center">
        <h5>Foto Grup</h5>
        <?php if (!empty($group['photo'])) : ?>
          <img src="<?= base_url('public/uploads/groups/' . $group['photo']); ?>" alt="Foto Grup" class="img-fluid rounded" style="max-width: 100%;">
        <?php else : ?>
          <p class="text-muted">Belum ada foto</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
  </form>
</div>

<?= $this->endSection(); ?>
