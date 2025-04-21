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
    <select name="type" id="type" required onchange="showInputField()">
        <option value="file" <?= old('type') == 'file' ? 'selected' : '' ?>>File</option>
        <option value="photo" <?= old('type') == 'photo' ? 'selected' : '' ?>>Photo</option>
        <option value="link" <?= old('type') == 'link' ? 'selected' : '' ?>>Link</option>
        <option value="maps" <?= old('type') == 'maps' ? 'selected' : '' ?>>Maps</option>
        <option value="text" <?= old('type') == 'text' ? 'selected' : '' ?>>Text</option>
    </select><br><br>

    <!-- Input untuk file -->
    <div id="file-input" style="display: none;">
        <label for="file">File</label><br>
        <input type="file" name="file" id="file"><br><br>
    </div>

    <!-- Input untuk photo -->
    <div id="photo-input" style="display: none;">
        <label for="photo">Photo</label><br>
        <input type="file" name="photo" id="photo" accept="image/*"><br><br>
    </div>

    <!-- Input untuk link -->
    <div id="link-input" style="display: none;">
        <label for="link">Link</label><br>
        <input type="url" name="link" id="link" placeholder="Masukkan URL"><br><br>
    </div>

    <!-- Input untuk maps -->
    <div id="maps-input" style="display: none;">
        <label for="maps-url">Google Maps URL</label><br>
        <input type="text" name="maps-url" id="maps-url" placeholder="Masukkan URL lokasi di Google Maps" pattern="https://www\.google\.com/maps/.*" title="Masukkan URL yang valid dari Google Maps" oninput="updateMapPreview()"><br><br>
        
        <!-- Embeddable Google Maps Preview -->
        <div id="map-preview" style="display: none;">
            <label>Preview Peta Google Maps:</label><br>
            <iframe id="google-map" width="600" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </div>

    <!-- Input untuk text -->
    <div id="text-input" style="display: none;">
        <label for="text">Text</label><br>
        <textarea name="text" id="text" placeholder="Masukkan teks di sini"><?= old('text') ?></textarea><br><br>
    </div>

    <label for="description">Description</label>
    <textarea name="description" id="description"><?= old('description') ?></textarea><br><br>

    <!-- Tombol Submit yang diubah -->
    <button type="submit" id="submit-btn">Simpan</button>
</form>

<script>
    function showInputField() {
        var type = document.getElementById("type").value;

        // Sembunyikan semua input
        document.getElementById("file-input").style.display = 'none';
        document.getElementById("photo-input").style.display = 'none';
        document.getElementById("link-input").style.display = 'none';
        document.getElementById("maps-input").style.display = 'none';
        document.getElementById("text-input").style.display = 'none';

        // Tampilkan input sesuai dengan tipe yang dipilih
        if (type === 'file') {
            document.getElementById("file-input").style.display = 'block';
            document.getElementById("submit-btn").innerText = "Unggah File";
        } else if (type === 'photo') {
            document.getElementById("photo-input").style.display = 'block';
            document.getElementById("submit-btn").innerText = "Unggah Foto";
        } else if (type === 'link') {
            document.getElementById("link-input").style.display = 'block';
            document.getElementById("submit-btn").innerText = "Masukkan Link";
        } else if (type === 'maps') {
            document.getElementById("maps-input").style.display = 'block';
            document.getElementById("submit-btn").innerText = "Masukkan URL Peta";
        } else if (type === 'text') {
            document.getElementById("text-input").style.display = 'block';
            document.getElementById("submit-btn").innerText = "Simpan Teks";
        }
    }

    function updateMapPreview() {
        var mapsUrl = document.getElementById("maps-url").value;
        var mapPreview = document.getElementById("map-preview");
        var iframe = document.getElementById("google-map");

        if (mapsUrl && mapsUrl.startsWith("https://www.google.com/maps/")) {
            mapPreview.style.display = "block";
            iframe.src = mapsUrl; // Update iframe with the provided URL
        } else {
            mapPreview.style.display = "none";
        }
    }

    // Panggil fungsi ini saat halaman dimuat untuk menampilkan input yang sesuai
    window.onload = showInputField;
</script>


<script>
    function showInputField() {
        var type = document.getElementById("type").value;

        // Sembunyikan semua input
        document.getElementById("file-input").style.display = 'none';
        document.getElementById("photo-input").style.display = 'none';
        document.getElementById("link-input").style.display = 'none';
        document.getElementById("maps-input").style.display = 'none';
        document.getElementById("text-input").style.display = 'none';

        // Tampilkan input sesuai dengan tipe yang dipilih
        if (type === 'file') {
            document.getElementById("file-input").style.display = 'block';
        } else if (type === 'photo') {
            document.getElementById("photo-input").style.display = 'block';
        } else if (type === 'link') {
            document.getElementById("link-input").style.display = 'block';
        } else if (type === 'maps') {
            document.getElementById("maps-input").style.display = 'block';
        } else if (type === 'text') {
            document.getElementById("text-input").style.display = 'block';
        }
    }

    function updateMapPreview() {
        var mapsUrl = document.getElementById("maps-url").value;
        var mapPreview = document.getElementById("map-preview");
        var iframe = document.getElementById("google-map");

        if (mapsUrl && mapsUrl.startsWith("https://www.google.com/maps/")) {
            mapPreview.style.display = "block";
            iframe.src = mapsUrl; // Update iframe with the provided URL
        } else {
            mapPreview.style.display = "none";
        }
    }

    // Panggil fungsi ini saat halaman dimuat untuk menampilkan input yang sesuai
    window.onload = showInputField;
</script>




<script>
    function showInputField() {
        var type = document.getElementById("type").value;

        // Sembunyikan semua input
        document.getElementById("file-input").style.display = 'none';
        document.getElementById("photo-input").style.display = 'none';
        document.getElementById("link-input").style.display = 'none';
        document.getElementById("maps-input").style.display = 'none';
        document.getElementById("text-input").style.display = 'none';

        // Tampilkan input sesuai dengan tipe yang dipilih
        if (type === 'file') {
            document.getElementById("file-input").style.display = 'block';
        } else if (type === 'photo') {
            document.getElementById("photo-input").style.display = 'block';
        } else if (type === 'link') {
            document.getElementById("link-input").style.display = 'block';
        } else if (type === 'maps') {
            document.getElementById("maps-input").style.display = 'block';
        } else if (type === 'text') {
            document.getElementById("text-input").style.display = 'block';
        }
    }

    // Panggil fungsi ini saat halaman dimuat untuk menampilkan input yang sesuai
    window.onload = showInputField;
</script>


<h3>Daftar Attachment</h3>

<?php if (!empty($attachments)): ?>
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>Tipe</th>
                <th>Deskripsi</th>
                <th>File/Link</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($attachments as $attach): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= esc(ucfirst($attach['type'])); ?></td>
                    <td><?= esc($attach['description']); ?></td>
                    <td>
                        <?php if ($attach['type'] === 'link' || $attach['type'] === 'maps'): ?>
                            <a href="<?= esc($attach['file']); ?>" target="_blank">Buka</a>
                        <?php else: ?>
                            <a href="<?= base_url('uploads/attachment/' . $attach['file']); ?>" target="_blank">Download</a>
                        <?php endif; ?>
                    </td>
                    <td>
                    <form action="<?= site_url('attachment/delete/' . $attach['id_attachment']); ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this attachment?');">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit" class="btn btn-danger">Hapus</button>
</form>

                        
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
