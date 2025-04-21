<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>

    <!-- <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>"> -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            color: #007BFF;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            margin-top: 15px;
            padding: 10px 16px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Edit Task</h1>
    <form action="<?= site_url('tugas/update/'.$tugas['id']); ?>" method="post">
        <label for="tugas">Task:</label>
        <input type="text" name="tugas" value="<?= $tugas['tugas']; ?>" required>

        <label for="tanggal">Tanggal:</label>
        <input type="date" name="tanggal" value="<?= $tugas['tanggal']; ?>" required>

        <label for="waktu">Waktu:</label>
        <input type="time" name="waktu" value="<?= $tugas['waktu']; ?>" required>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="To do" <?= ($tugas['status'] == 'To do') ? 'selected' : ''; ?>>To do</option>
            <option value="Berjalan" <?= ($tugas['status'] == 'Berjalan') ? 'selected' : ''; ?>>Berjalan</option>
            <option value="Selesai" <?= ($tugas['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
            <option value="Batal" <?= ($tugas['status'] == 'Batal') ? 'selected' : ''; ?>>Batal</option>
        </select>

        <label for="alarm">Alarm:</label>
        <select name="alarm" required>
            <option value="yes" <?= ($tugas['alarm'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
            <option value="no" <?= ($tugas['alarm'] == 'no') ? 'selected' : ''; ?>>No</option>
        </select>

        <label for="date_due">Due Date:</label>
        <input type="date" name="date_due" value="<?= $tugas['date_due']; ?>" required>

        <label for="time_due">Time Due:</label>
        <input type="time" name="time_due" value="<?= $tugas['time_due']; ?>">

        <input type="hidden" name="creator_id" value="<?= $tugas['creator_id']; ?>">

        <button type="submit">Simpan Perubahan</button>
    </form>

    <a href="<?= site_url('tugas'); ?>">← Kembali ke Daftar Task</a>
</body>
</html>
