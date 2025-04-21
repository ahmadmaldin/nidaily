<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">My Task Board</h4>
  <a href="<?= site_url('tugas/create'); ?>" class="btn btn-primary">+ Tambah Tugas</a>
</div>

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
                  <a href="<?= site_url('tugas/detail/'.$task['id']); ?>" class="text-info">Detail</a> |
                  <a href="<?= site_url('tugas/edit/'.$task['id']); ?>" class="text-warning">Edit</a> |
                  <a href="<?= site_url('tugas/delete/'.$task['id']); ?>" class="text-danger" onclick="return confirm('Yakin ingin menghapus tugas ini?');">Hapus</a>
                  <a href="<?= site_url('tugas/share/'.$task['id']); ?>" class="text-warning">Share</a> |

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
                  <a href="<?= site_url('tugas/detail/'.$task['id']); ?>" class="text-info">Detail</a> |
                  <a href="<?= site_url('tugas/edit/'.$task['id']); ?>" class="text-warning">Edit</a> |
                  <a href="<?= site_url('tugas/delete/'.$task['id']); ?>" class="text-danger" onclick="return confirm('Yakin ingin menghapus tugas ini?');">Hapus</a>
                  <a href="<?= site_url('tugas/share/'.$task['id']); ?>" class="text-warning">Share</a> |

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

<?= $this->endSection(); ?>
