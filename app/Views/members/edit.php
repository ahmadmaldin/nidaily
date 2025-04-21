<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h2>Edit Member</h2>

<!-- Form untuk edit member -->
<form action="<?= site_url('members/update/'.$member['id_members']) ?>" method="post">
    <?= csrf_field() ?>

    <label for="id_groups">ID Group:</label><br>
    <input type="number" name="id_groups" id="id_groups" value="<?= esc($member['id_groups']) ?>" required><br><br>

    <label for="user_id">User ID:</label><br>
    <input type="number" name="user_id" id="user_id" value="<?= esc($member['user_id']) ?>" required><br><br>

    <label for="member_level">Level:</label><br>
    <select name="member_level" id="member_level">
        <option value="admin" <?= $member['member_level'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="member" <?= $member['member_level'] == 'member' ? 'selected' : '' ?>>Member</option>
    </select><br><br>

    <button type="submit">Update</button>
</form>

<!-- Link untuk kembali ke daftar member -->
<a href="<?= site_url('members') ?>">← Kembali ke daftar member</a>

<?= $this->endSection(); ?>
