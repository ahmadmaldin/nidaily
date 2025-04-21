<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h2>Daftar Member</h2>
<a href="<?= site_url('members/create'); ?>">Tambah Member</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Grup</th>
            <th>User ID</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($members as $member): ?>
        <tr>
            <td><?= esc($member['id_members']) ?></td>
            <td><?= esc($member['id_groups']) ?></td>
            <td><?= esc($member['user_id']) ?></td>
            <td><?= esc($member['member_level']) ?></td>
            <td>
                <a href="<?= site_url('members/edit/'.$member['id_members']); ?>">Edit</a> |
                <a href="<?= site_url('members/delete/'.$member['id_members']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus member ini?');">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>
