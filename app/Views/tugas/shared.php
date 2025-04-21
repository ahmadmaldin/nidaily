<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h3>Bagikan Tugas: <?= esc($tugas['tugas']) ?></h3>

<form action="/tugas/share/<?= $tugas['id'] ?>" method="post">
    <label for="user_id">Pilih User:</label>
    <select name="user_id">
        <?php foreach ($users as $user): ?>
            <option value="<?= esc($user['id_user']) ?>"><?= esc($user['username']) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Bagikan Tugas</button>
</form>

<?= $this->endSection(); ?>
