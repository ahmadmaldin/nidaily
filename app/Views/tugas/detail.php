<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h1>Detail Task</h1>

<div class="tugas-detail">
    <p><strong>Id:</strong> <?= esc($tugas['id']); ?></p>
    <p><strong>Task:</strong> <?= esc($tugas['tugas']); ?></p>
    <p><strong>Tanggal:</strong> <?= esc($tugas['tanggal']); ?></p>
    <p><strong>Waktu:</strong> <?= esc($tugas['waktu']); ?></p>
    <p><strong>Status:</strong> <?= esc($tugas['status']); ?></p>
    <p><strong>Alarm:</strong> <?= esc($tugas['alarm']); ?></p>
    <p><strong>Due Date:</strong> <?= esc($tugas['date_due']); ?></p>
    <p><strong>Time Due:</strong> <?= esc($tugas['time_due']); ?></p>
    <p><strong>Creator ID:</strong> <?= esc($tugas['creator_id']); ?></p>
</div>

<h2>Tambah Attachment</h2>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('attachment/store'); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id_tugas" value="<?= esc($tugas['id']); ?>">

    <label for="type">Type</label>
    <select name="type" id="type" required>
        <option value="file" <?= old('type') == 'file' ? 'selected' : '' ?>>File</option>
        <option value="photo" <?= old('type') == 'photo' ? 'selected' : '' ?>>Photo</option>
        <option value="link" <?= old('type') == 'link' ? 'selected' : '' ?>>Link</option>
        <option value="maps" <?= old('type') == 'maps' ? 'selected' : '' ?>>Maps</option>
    </select><br><br>

    <label for="file">File</label><br>
    <input type="file" name="file" id="file" required style="display: none;">
    <button type="button" id="customBtn">Pilih File</button>
    <span id="fileName">Belum ada file yang dipilih</span><br><br>

    <label for="description">Description</label>
    <textarea name="description" id="description"><?= old('description') ?></textarea><br><br>

    <button type="submit">Simpan</button>
</form>

<!-- DAFTAR ATTACHMENTS -->
<h3>Daftar Attachment</h3>
<?php if (!empty($attachments)): ?>
    <ul>
        <?php foreach ($attachments as $attach): ?>
            <li>
                <strong><?= esc(ucfirst($attach['type'])); ?>:</strong>
                <?= esc($attach['description']); ?>
                <?php if ($attach['type'] === 'link' || $attach['type'] === 'maps'): ?>
                    - <a href="<?= esc($attach['file']); ?>" target="_blank">Buka</a>
                <?php else: ?>
                    - <a href="<?= base_url('uploads/' . $attach['file']); ?>" target="_blank">Download</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Belum ada attachment untuk tugas ini.</p>
<?php endif; ?>

<hr>
<h2>Bagikan Task ke Pengguna Lain</h2>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form action="<?= site_url('tugas/share'); ?>" method="post">
    <?= csrf_field(); ?>
    <input type="hidden" name="id_task" value="<?= esc($tugas['id']); ?>">
    <input type="hidden" name="shared_by_user_id" value="<?= session()->get('id_user'); ?>">

    <label for="id_user"><strong>Pilih Pengguna:</strong></label>
    <select name="id_user" id="id_user" required>
        <option value="">-- Pilih Pengguna --</option>
        <?php foreach ($users as $user): ?>
            <?php if ($user['id_user'] != session()->get('id_user')): ?>
                <option value="<?= $user['id_user']; ?>"><?= esc($user['username']); ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    <br><br>
    <button type="submit" class="btn btn-primary">Bagikan</button>
</form>

<a href="<?= site_url('tugas'); ?>">← Kembali ke Daftar Task</a>

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

    .tugas-detail {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        max-width: 800px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .tugas-detail p {
        margin: 10px 0;
        font-size: 16px;
    }

    .tugas-detail p strong {
        color: #007BFF;
    }
</style>

<?= $this->endSection(); ?>
