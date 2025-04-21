<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Task</title>
    <!-- Jika ingin pakai file external, aktifkan baris ini -->
    <!-- <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>"> -->

    <!-- CSS Dasar langsung di dalam file -->
    
</head>
<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
        <h4 class="card-title">Tambah Task</h4>
        <p class="card-description">Form untuk menambahkan tugas baru</p>

        <form action="<?= site_url('tugas/store'); ?>" method="post" class="forms-sample">
          <div class="form-group">
            <label for="tugas">Task</label>
            <input type="text" class="form-control" name="tugas" id="tugas" required placeholder="Masukkan nama tugas">
          </div>

          <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
          </div>

          <div class="form-group">
            <label for="waktu">Waktu</label>
            <input type="time" class="form-control" name="waktu" id="waktu" required>
          </div>

          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status" required>
              <option value="To do">To do</option>
              <option value="Berjalan">Berjalan</option>
              <option value="Selesai">Selesai</option>
              <option value="Batal">Batal</option>
            </select>
          </div>

          <div class="form-group">
            <label for="alarm">Alarm</label>
            <select class="form-control" name="alarm" id="alarm" required>
              <option value="yes">Yes</option>
              <option value="no">No</option>
            </select>
          </div>

          <div class="form-group">
            <label for="date_due">Due Date</label>
            <input type="date" class="form-control" name="date_due" id="date_due" required>
          </div>

          <div class="form-group">
            <label for="time_due">Time Due</label>
            <input type="time" class="form-control" name="time_due" id="time_due">
          </div>

          <input type="hidden" name="creator_id" value="">

          <p>                <p>


          <button type="submit" class="btn btn-inverse-primary btn-fw">Simpan Task</button>
          <a href="<?= site_url('tugas'); ?>" class="btn btn-inverse-secondary btn-fw">Kembali</a>
        </form>
<?= $this->endSection(); ?>
</html>

<?= $this->endSection(); ?>
