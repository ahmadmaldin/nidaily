<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
  .aksi-icon {
    font-size: 1.2rem;
    margin: 0 6px;
  }
</style>

<!-- Bagian Tugas Berdasarkan Status (To do, Berjalan, Selesai, Terlambat) -->
<div class="row flex-nowrap overflow-auto pb-3" style="gap: 16px;">
  <?php
  $statuses = ['To do', 'Berjalan', 'Selesai', 'Terlambat'];
  foreach ($statuses as $status):
      $hasTask = false;
  ?>
    <div class="col-auto" style="min-width: 280px;">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center"><?= esc($status); ?></h5>
          <hr>
          <?php foreach ($tugas as $task): ?>
            <?php
              $tanggal = $task['tanggal'] ?? $task['date_due'] ?? '';
              $waktu = $task['waktu'] ?? $task['time_due'] ?? '';
              if (!$tanggal || !$waktu) continue;

              $dueDatetime = strtotime($tanggal . ' ' . $waktu);
              $now = time();
              $isOverdue = $dueDatetime < $now;
              $isAlmostDue = $dueDatetime > $now && $dueDatetime <= ($now + 86400);
              $showAlarm = ($task['alarm'] ?? 'no') === 'yes' && ($isAlmostDue || $isOverdue);
              if ($task['status'] === 'Selesai') $showAlarm = false;

              if ($status === 'Terlambat' && $task['status'] !== 'Selesai' && $isOverdue):
                $hasTask = true;
            ?>
              <div class="mb-3 p-2 border border-danger bg-light rounded">
                <strong><?= esc($task['tugas']); ?></strong>
                <div class="text-danger small">⚠️ Terlewat! - <?= esc($tanggal); ?> <?= esc($waktu); ?></div>
                <div class="mt-2">
                  <a href="<?= site_url('tugas/detail/'.$task['id']); ?>" class="text-info" title="Detail">
                    <i class="fa-solid fa-eye aksi-icon"></i>
                  </a>
                  <a href="<?= site_url('tugas/edit/'.$task['id']); ?>" class="text-warning" title="Edit">
                    <i class="fa-solid fa-pen-to-square aksi-icon"></i>
                  </a>
                  <a href="<?= site_url('tugas/delete/'.$task['id']); ?>" class="text-danger" onclick="return confirm('Yakin ingin menghapus tugas ini?');" title="Hapus">
                    <i class="fa-solid fa-trash aksi-icon"></i>
                  </a>
                  <!-- Tombol Bagikan -->
                  <a href="<?= site_url('tugas/share/'.$task['id']); ?>" class="text-success" title="Bagikan">
                    <i class="fa-solid fa-share aksi-icon"></i>
                  </a>
                </div>
              </div>
            <?php elseif ($task['status'] === $status && !$isOverdue): ?>
              <?php $hasTask = true; ?>
              <div class="mb-3 p-2 bg-light rounded">
                <strong><?= esc($task['tugas']); ?></strong>
                <div class="small text-muted"><?= esc($tanggal); ?> <?= esc($waktu); ?></div>
                <?php if ($showAlarm): ?>
                  <div class="text-danger small"><?= $isOverdue ? '⚠️ Terlewat!' : '⏰ Segera Jatuh Tempo!' ?></div>
                <?php endif; ?>
                <div class="mt-2">
                  <a href="<?= site_url('tugas/detail/'.$task['id']); ?>" class="text-info" title="Detail">
                    <i class="fa-solid fa-eye aksi-icon"></i>
                  </a>
                  <a href="<?= site_url('tugas/edit/'.$task['id']); ?>" class="text-warning" title="Edit">
                    <i class="fa-solid fa-pen-to-square aksi-icon"></i>
                  </a>
                  <a href="<?= site_url('tugas/delete/'.$task['id']); ?>" class="text-danger" onclick="return confirm('Yakin ingin menghapus tugas ini?');" title="Hapus">
                    <i class="fa-solid fa-trash aksi-icon"></i>
                  </a>
                  <!-- Tombol Bagikan -->
                  <a href="<?= site_url('tugas/share/'.$task['id']); ?>" class="text-success" title="Bagikan">
                    <i class="fa-solid fa-share aksi-icon"></i>
                  </a>
                </div>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>

          <?php if (!$hasTask): ?>
            <p class="text-muted text-center fst-italic">Tidak ada tugas <strong><?= esc($status); ?></strong></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- Bagian Riwayat Semua Tugas -->
<div class="mt-5">
  <h4>Riwayat Semua Tugas</h4>
  <hr>
  <?php if (!empty($tugas)): ?>
    <?php 
      // Urutkan tugas berdasarkan tanggal dan waktu terbaru (misal berdasarkan tanggal dan waktu)
      usort($tugas, function($a, $b) {
        $datetimeA = strtotime(($a['tanggal'] ?? $a['date_due']) . ' ' . ($a['waktu'] ?? $a['time_due']));
        $datetimeB = strtotime(($b['tanggal'] ?? $b['date_due']) . ' ' . ($b['waktu'] ?? $b['time_due']));
        return $datetimeB <=> $datetimeA; // urut descending (terbaru di atas)
      });
    ?>
    <div class="list-group">
      <?php foreach ($tugas as $task): ?>
        <div class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><?= esc($task['tugas']); ?></h5>
            <small><?= esc($task['status']); ?></small>
          </div>
          <p class="mb-1">Tanggal: <?= esc($task['tanggal'] ?? $task['date_due']); ?> <?= esc($task['waktu'] ?? $task['time_due']); ?></p>
          <div class="mt-2">
            <a href="<?= site_url('tugas/detail/'.$task['id']); ?>" class="text-info" title="Detail">
              <i class="fa-solid fa-eye aksi-icon"></i>
            </a>
            <a href="<?= site_url('tugas/edit/'.$task['id']); ?>" class="text-warning" title="Edit">
              <i class="fa-solid fa-pen-to-square aksi-icon"></i>
            </a>
            <a href="<?= site_url('tugas/delete/'.$task['id']); ?>" class="text-danger" onclick="return confirm('Yakin ingin menghapus tugas ini?');" title="Hapus">
              <i class="fa-solid fa-trash aksi-icon"></i>
            </a>
            <!-- Tombol Bagikan -->
            <a href="<?= site_url('tugas/share/'.$task['id']); ?>" class="text-success" title="Bagikan">
              <i class="fa-solid fa-share aksi-icon"></i>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="text-muted fst-italic">Belum ada tugas yang dibuat.</p>
  <?php endif; ?>
</div>

<?= $this->endSection(); ?>
