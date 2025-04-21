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
<body>
    <h1>Tambah Task</h1>
    <form action="<?= site_url('tugas/store'); ?>" method="post">

    
        <label for="tugas">Task:</label>
        <input type="text" name="tugas" required>

        <label for="tanggal">Tanggal:</label>
        <input type="date" name="tanggal" required>

        <label for="waktu">Waktu:</label>
        <input type="time" name="waktu" required>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="To do">To do</option>
            <option value="Berjalan">Berjalan</option>
            <option value="Selesai">Selesai</option>
            <option value="Batal">Batal</option>
        </select>

        <label for="alarm">Alarm:</label>
        <select name="alarm" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

        <label for="date_due">Due Date:</label>
        <input type="date" name="date_due" required>

        <label for="time_due">Time Due:</label>
        <input type="time" name="time_due">

        <input type="hidden" name="creator_id">

        <button type="submit">Simpan Task</button>
    </form>

    <a href="<?= site_url('tugas'); ?>">← Kembali ke Daftar Task</a>
</body>
</html>

<?= $this->endSection(); ?>
