<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1>Tambah Attachment</h1>

<!-- Menampilkan pesan error jika ada kesalahan dalam input -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form action="<?= site_url('attachment/store'); ?>" method="post">
    <?= csrf_field() ?>

    <!-- ID Tugas -->
    <label for="id_tugas">ID Tugas</label>
    <input type="text" name="id_tugas" id="id_tugas" value="<?= old('id_tugas') ?>" required><br><br>

    <!-- Type -->
    <label for="type">Type</label>
    <select name="type" id="type" required>
        <option value="file" <?= old('type') == 'file' ? 'selected' : '' ?>>File</option>
        <option value="photo" <?= old('type') == 'photo' ? 'selected' : '' ?>>Photo</option>
        <option value="link" <?= old('type') == 'link' ? 'selected' : '' ?>>Link</option>
        <option value="maps" <?= old('type') == 'maps' ? 'selected' : '' ?>>Maps</option>
    </select><br><br>

    <!-- Custom File Upload -->
    <label for="file">File</label><br>
    <input type="file" name="file" id="file" required style="display: none;">
    <button type="button" id="customBtn">Pilih File</button>
    <span id="fileName">Belum ada file yang dipilih</span><br><br>

    <!-- Description -->
    <label for="description">Description</label>
    <textarea name="description" id="description"><?= old('description') ?></textarea><br><br>

    <button type="submit">Simpan</button>
    
</form>
<a href="<?= site_url('attachment'); ?>">← Kembali ke Daftar Tugas</a>

<!-- Tambahkan JS dan CSS di bawah ini -->
<script>
    const realFileBtn = document.getElementById("file");
    const customBtn = document.getElementById("customBtn");
    const fileName = document.getElementById("fileName");

    customBtn.addEventListener("click", function () {
        realFileBtn.click(); // Menyimulasikan klik pada input file
    });

    realFileBtn.addEventListener("change", function () {
        if (realFileBtn.files.length > 0) {
            fileName.textContent = realFileBtn.files[0].name; // Menampilkan nama file yang dipilih
        } else {
            fileName.textContent = "Belum ada file yang dipilih"; // Jika tidak ada file yang dipilih
        }
    });
</script>

<style>
    #customBtn {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }

    #customBtn:hover {
        background-color: #0056b3;
    }

    #fileName {
        font-style: italic;
        color: #555;
    }
</style>

<?= $this->endSection(); ?>
