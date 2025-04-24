<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <!-- Welcome Message -->
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card cowboy-theme">
            <div class="card-body">
                <h4 class="card-title">Howdy, <?= session()->get('username') ?>! 🤠</h4>
                <p class="card-description">Welcome back to Nidaily! Here's your activity summary:</p>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-statistics cowboy-theme">
            <div class="card-body">
                <p class="stat-title">Your Tasks</p>
                <h3 class="rate-percentage"><?= $total_tasks ?></h3>
                <div class="icon">
                    <i class="mdi mdi-format-list-bulleted text-info"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-statistics cowboy-theme">
            <div class="card-body">
                <p class="stat-title">Shared to You</p>
                <h3 class="rate-percentage"><?= $shared_to_me ?></h3>
                <div class="icon">
                    <i class="mdi mdi-share-variant text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin stretch-card">
        <div class="card card-statistics cowboy-theme">
            <div class="card-body">
                <p class="stat-title">Groups Joined</p>
                <h3 class="rate-percentage"><?= $group_count ?></h3>
                <div class="icon">
                    <i class="mdi mdi-account-group text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Shared Task Notifications -->
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card cowboy-theme">
            <div class="card-body">
                <h4 class="card-title">📬 Shared Tasks</h4>
                <ul class="list-group">
                    <?php if (!empty($shared_tasks)): ?>
                        <?php foreach ($shared_tasks as $task): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $task['judul'] ?>
                                <a href="<?= base_url('tugas/detail/' . $task['id_tugas']) ?>" class="btn btn-sm btn-outline-primary">View</a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item">No shared tasks yet.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
