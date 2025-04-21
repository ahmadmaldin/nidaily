<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h2>Daftar Member di Grup: <?= esc($group['group_name']) ?></h2>

<table border="1">
    <thead>
        <tr>
            <th>Nama Member</th>
            <th>Level</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($members) : ?>
            <?php foreach ($members as $member) : ?>
                <tr>
                    <td><?= esc($member['username']) ?></td> <!-- Menampilkan username -->
                    <td><?= esc($member['member_level']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr><td colspan="2">Tidak ada member dalam grup ini.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<a href="<?= base_url('groups/' . $group['id_groups']) ?>">Kembali ke Grup</a>

<?= $this->endSection(); ?>
