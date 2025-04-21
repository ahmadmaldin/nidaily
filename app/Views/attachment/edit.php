<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h1>Edit Attachment</h1>

<!-- Menampilkan pesan error jika ada -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('attachment/update/' . $attachment['id_attachment']); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- ID Tugas -->
    <label for="id_tugas">ID Tugas</label>
    <input type="text" name="id_tugas" id="id_tugas" value="<?= esc($attachment['id_tugas']) ?>" required><br><br>

    <!-- Type -->
    <label for="type">Type</label>
    <select name="type" id="type" required>
        <option value="file" <?= $attachment['type'] == 'file' ? 'selected' : '' ?>>File</option>
        <option value="photo" <?= $attachment['type'] == 'photo' ? 'selected' : '' ?>>Photo</option>
        <option value="link" <?= $attachment['type'] == 'link' ? 'selected' : '' ?>>Link</option>
        <option value="maps" <?= $attachment['type'] == 'maps' ? 'selected' : '' ?>>Maps</option>
    </select><br><br>

    <!-- File Upload (Custom Button) -->
    <label for="file">File</label><br>
    <input type="file" name="file" id="file" style="display: none;">
    <button type="button" id="customBtn">Pilih File</button>
    <span id="fileName"><?= $attachment['file'] ? $attachment['file'] : 'Belum ada file yang dipilih' ?></span><br><br>

    <!-- Description -->
    <label for="description">Description</label>
    <textarea name="description" id="description"><?= esc($attachment['description']) ?></textarea><br><br>

    <button type="submit">Update</button>
</form>

<a href="<?= site_url('attachment'); ?>">← Kembali ke Daftar Attachment</a>

<!-- Script dan Style -->
<script>
    const realFileBtn = document.getElementById("file");
    const customBtn = document.getElementById("customBtn");
    const fileName = document.getElementById("fileName");

    customBtn.addEventListener("click", function () {
        realFileBtn.click();
    });

    realFileBtn.addEventListener("change", function () {
        if (realFileBtn.files.length > 0) {
            fileName.textContent = realFileBtn.files[0].name;
        } else {
            fileName.textContent = "Belum ada file yang dipilih";
        }
    });
</script>

<style>
    #customBtn {
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }

    #customBtn:hover {
        background-color: #218838;
    }

    #fileName {
        font-style: italic;
        color: #555;
    }
</style>

<?= $this->endSection(); ?>
