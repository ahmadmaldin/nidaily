<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="row">
  <!-- Menambahkan Section Greeting di Dashboard -->
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Selamat Datang di Aplikasi Tugas</h4>
        <p class="card-description">
          Ini adalah contoh level terendah aplikasi catatan tugas.
        </p>
        <p class="text-muted">
          <strong>Uji Kompetensi Keahlian SMKS Al Mamun tahun 2025.</strong><br>
          Manajemen tugas yang lebih mudah dan efisien.
        </p>
      </div>
    </div>
  </div>

  <!-- Menambahkan Tombol "Tambah Task" Sejajar dengan Greeting di Bawahnya -->
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <a href="<?= base_url('tugas/create'); ?>" class="btn btn-inverse-primary btn-fw">
           + Tambah Task
        </a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>
