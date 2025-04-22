<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Task</h4>
        <form action="<?= site_url('tugas/update/'.$tugas['id']); ?>" method="post">
            <div class="form-group">
                <label for="tugas">Task:</label>
                <input type="text" class="form-control" name="tugas" value="<?= $tugas['tugas']; ?>" required>
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" class="form-control" name="tanggal" value="<?= $tugas['tanggal']; ?>" required>
            </div>

            <div class="form-group">
                <label for="waktu">Waktu:</label>
                <input type="time" class="form-control" name="waktu" value="<?= $tugas['waktu']; ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" class="form-control" required>
                    <option value="To do" <?= ($tugas['status'] == 'To do') ? 'selected' : ''; ?>>To do</option>
                    <option value="Berjalan" <?= ($tugas['status'] == 'Berjalan') ? 'selected' : ''; ?>>Berjalan</option>
                    <option value="Selesai" <?= ($tugas['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                    <option value="Batal" <?= ($tugas['status'] == 'Batal') ? 'selected' : ''; ?>>Batal</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alarm">Alarm:</label>
                <select name="alarm" class="form-control" required>
                    <option value="yes" <?= ($tugas['alarm'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
                    <option value="no" <?= ($tugas['alarm'] == 'no') ? 'selected' : ''; ?>>No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date_due">Due Date:</label>
                <input type="date" class="form-control" name="date_due" value="<?= $tugas['date_due']; ?>" required>
            </div>

            <div class="form-group">
                <label for="time_due">Time Due:</label>
                <input type="time" class="form-control" name="time_due" value="<?= $tugas['time_due']; ?>">
            </div>

            <input type="hidden" name="creator_id" value="<?= $tugas['creator_id']; ?>">

            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
            <a href="<?= site_url('tugas'); ?>" class="btn btn-link mt-3">← Kembali ke Daftar Task</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>
