<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            color: #007BFF;
            text-align: center;
            margin-bottom: 40px;
        }

        .kanban-board {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding-bottom: 20px;
        }

        .kanban-column {
            flex: 0 0 300px;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .kanban-column:nth-child(1) {
            background-color: #ffe6e6;
            border: 2px solid red;
        }

        .kanban-column h2 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 15px;
        }

        .task {
            background-color: #f9f9f9;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 10px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            transition: background-color 0.3s;
        }

        .task:hover {
            background-color: #e6f0ff;
        }

        .task-title {
            font-weight: bold;
        }

        .task-meta {
            font-size: 0.9em;
            color: #555;
            margin-top: 5px;
        }

        .task-actions {
            margin-top: 10px;
            font-size: 0.9em;
        }

        .task-actions a {
            text-decoration: none;
            color: #007BFF;
            margin-right: 6px;
        }

        .task-actions a:hover {
            text-decoration: underline;
        }

        .task-alarm {
            border: 2px solid red;
            background-color: #ffe6e6;
        }

        .alarm-badge {
            background-color: red;
            color: white;
            padding: 2px 6px;
            font-size: 12px;
            margin-left: 8px;
            border-radius: 5px;
        }

        .add-task-button {
            display: block;
            margin: 0 auto 30px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            width: 200px;
        }

        .add-task-button:hover {
            background-color: #0056b3;
        }

        .no-task {
            text-align: center;
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>

<h1>Task Board</h1>

<a href="<?= site_url('tugas/create'); ?>" class="add-task-button">+ Tambah Tugas</a>

<div class="kanban-board">
    <?php
$statuses = ['To do', 'Berjalan', 'Selesai', 'Terlambat'];

    foreach ($statuses as $status):
        $hasTask = false;
    ?>
        <div class="kanban-column">
            <h2><?= $status; ?></h2>
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

                    if ($task['status'] === 'Selesai') {
                        $showAlarm = false;
                    }

                    if ($status === 'Terlambat' && $task['status'] !== 'Selesai' && $isOverdue):
                        $hasTask = true;
                ?>
                    <div class="task task-alarm">
                        <div class="task-title">
                            <?= esc($task['tugas']); ?>
                            <span class="alarm-badge">⚠️ Terlewat!</span>
                        </div>
                        <div class="task-meta"><?= esc($tanggal); ?> at <?= esc($waktu); ?></div>
                        <div class="task-actions">
                            <a href="<?= site_url('tugas/edit/'.$task['id']); ?>">Edit</a> |
                            <a href="<?= site_url('tugas/delete/'.$task['id']); ?>" onclick="return confirm('Yakin ingin menghapus tugas ini?');">Hapus</a> |
                            <a href="<?= site_url('tugas/detail/'.$task['id']); ?>">Detail</a>
                        </div>
                    </div>
                <?php elseif ($task['status'] === $status && !$isOverdue): ?>
                    <?php $hasTask = true; ?>
                    <div class="task <?= $showAlarm ? 'task-alarm' : ''; ?>">
                        <div class="task-title">
                            <?= esc($task['tugas']); ?>
                            <?php if ($showAlarm): ?>
                                <span class="alarm-badge">
                                    <?= $isOverdue ? '⚠️ Terlewat!' : '⏰ Segera Jatuh Tempo!'; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="task-meta"><?= esc($tanggal); ?> at <?= esc($waktu); ?></div>
                        <div class="task-actions">
                            <a href="<?= site_url('tugas/edit/'.$task['id']); ?>">Edit</a> |
                            <a href="<?= site_url('tugas/delete/'.$task['id']); ?>" onclick="return confirm('Yakin ingin menghapus tugas ini?');">Hapus</a> |
                            <a href="<?= site_url('tugas/detail/'.$task['id']); ?>">Detail</a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if (!$hasTask): ?>
                <p class="no-task">Tidak ada tugas <strong><?= esc($status); ?></strong></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>

<?= $this->endSection(); ?>
