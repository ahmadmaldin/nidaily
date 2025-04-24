<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<a href="<?= previous_url() ?>" class="btn btn-inverse-secondary btn-fw">
    Kembali
</a>
<p>
  
</p>
<h3>Detail Task</h3>
<?php if (!empty($tugas)): ?>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="border p-3 rounded">
                <strong>Id:</strong><br>
                <?= esc($tugas['id']); ?>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="border p-3 rounded">
                <strong>Task:</strong><br>
                <?= esc($tugas['tugas']); ?>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="border p-3 rounded">
                <strong>Tanggal:</strong><br>
                <?= esc($tugas['tanggal']); ?>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="border p-3 rounded">
                <strong>Waktu:</strong><br>
                <?= esc($tugas['waktu']); ?>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="border p-3 rounded">
                <strong>Status:</strong><br>
                <?= esc($tugas['status']); ?>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="border p-3 rounded">
                <strong>Alarm:</strong><br>
                <?= esc($tugas['alarm']); ?>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="border p-3 rounded">
                <strong>Due Date:</strong><br>
                <?= esc($tugas['date_due']); ?>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="border p-3 rounded">
                <strong>Time Due:</strong><br>
                <?= esc($tugas['time_due']); ?>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="border p-3 rounded">
                <strong>Creator ID:</strong><br>
                <?= esc($tugas['creator_id']); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">Data tugas tidak ditemukan.</div>
<?php endif; ?>
<hr></hr>


<h3 class="mb-4">Tambah Attachment</h3>

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

  <!-- Select Type -->
  <div class="form-group">
    <label for="type">Type</label>
    <div class="input-group">
      <select name="type" id="type" class="form-control" onchange="showInputField()" required>
        <option value="file" <?= old('type') == 'file' ? 'selected' : '' ?>>File</option>
        <option value="photo" <?= old('type') == 'photo' ? 'selected' : '' ?>>Photo</option>
        <option value="link" <?= old('type') == 'link' ? 'selected' : '' ?>>Link</option>
        <option value="maps" <?= old('type') == 'maps' ? 'selected' : '' ?>>Maps</option>
        <option value="text" <?= old('type') == 'text' ? 'selected' : '' ?>>Text</option>
      </select>
    </div>
  </div>

  <!-- Input Fields per Type -->
  <div class="form-group" id="file-input" style="display: none;">
    <label for="file">File</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text">📁</span>
      </div>
      <input type="file" name="file" id="file" class="form-control">
    </div>
  </div>

  <div class="form-group" id="photo-input" style="display: none;">
    <label for="photo">Photo</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text">🖼️</span>
      </div>
      <input type="file" name="photo" id="photo" accept="image/*" class="form-control">
    </div>
  </div>

  <div class="form-group" id="link-input" style="display: none;">
    <label for="link">Link</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text">🔗</span>
      </div>
      <input type="url" name="link" id="link" class="form-control" placeholder="Masukkan URL">
    </div>
  </div>

  <div id="maps-input" style="display: none;">
    <div class="form-group">
      <label for="maps-url">Google Maps URL</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">🗺️</span>
        </div>
        <input type="text" name="maps-url" id="maps-url" class="form-control"
               placeholder="Masukkan URL lokasi di Google Maps"
               pattern="https://www\.google\.com/maps/.*"
               title="Masukkan URL yang valid dari Google Maps"
               oninput="updateMapPreview()">
      </div>
    </div>

    <div id="map-preview" style="display: none;" class="mt-3">
      <label>Preview Peta Google Maps:</label>
      <iframe id="google-map" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
  </div>

  <div class="form-group" id="text-input" style="display: none;">
    <label for="text">Text</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text">📝</span>
      </div>
      <textarea name="text" id="text" class="form-control" placeholder="Masukkan teks di sini"><?= old('text') ?></textarea>
    </div>
  </div>

  <!-- Description -->
  <div class="form-group">
    <label for="description">Description</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text">🗒️</span>
      </div>
      <textarea name="description" id="description" class="form-control"><?= old('description') ?></textarea>
    </div>
  </div>

  <button type="submit" id="submit-btn" class="btn btn-inverse-info btn-fw">Simpan</button>
</form>

<script>
  function showInputField() {
    var type = document.getElementById("type").value;

    document.getElementById("file-input").style.display = 'none';
    document.getElementById("photo-input").style.display = 'none';
    document.getElementById("link-input").style.display = 'none';
    document.getElementById("maps-input").style.display = 'none';
    document.getElementById("text-input").style.display = 'none';

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
      iframe.src = mapsUrl;
    } else {
      mapPreview.style.display = "none";
    }
  }

  window.onload = showInputField;
</script>


<hr></hr>
<h3>Daftar Attachment</h3>

<?php if (!empty($attachments)): ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
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
                                <a href="<?= esc($attach['file']); ?>" target="_blank"><i class="fa fa-external-link"></i> Buka</a>
                            <?php else: ?>
                                <a href="<?= base_url('uploads/attachment/' . $attach['file']); ?>" target="_blank"><i class="fa fa-download"></i> Download</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="<?= site_url('attachment/delete/' . $attach['id_attachment']); ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus attachment ini?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-inverse-danger btn-fw"><i class="fa fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>Belum ada attachment untuk tugas ini.</p>
<?php endif; ?>
<hr></hr>

<h3>Daftar Penerima Tugas</h3>
<?php if (!empty($sharedUsers)) : ?>
    <div class="table-responsive">
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Nama User</th>
                    <th>Tanggal Dibagikan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sharedUsers as $user) : ?>
                    <tr>
                        <td><?= esc($user['id_user']) ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($user['share_date'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <p>Tugas ini belum dibagikan ke siapa pun.</p>
<?php endif; ?>


<?= $this->endSection(); ?>
