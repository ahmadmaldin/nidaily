<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h2>Detail Grup: <?= esc($group['group_name']) ?></h2>

<h3>Daftar Member:</h3>

<?php if (!empty($members)) : ?>
    <table border="1">
        <thead>
            <tr>
                <th>Nama Member</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $member) : ?>
                <tr>
                    <td><?= esc($member['username']) ?></td>
                    <td><?= esc($member['member_level']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Belum ada member dalam grup ini.</p>
<?php endif; ?>

<a href="<?= base_url('groups/addMember/' . $group['id_groups']) ?>">Tambah Member</a>

<a href="<?= base_url('groups') ?>">Kembali ke Daftar Grup</a>

<?= $this->endSection(); ?>
