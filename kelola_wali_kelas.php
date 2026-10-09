
<?php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql = "SELECT * FROM t_wali_kelas ORDER BY id DESC";
$hasil = mysqli_query($koneksi, $sql);

if (!$hasil) {
    die("Query gagal: " . mysqli_error($koneksi));
}

$kolom = mysqli_fetch_fields($hasil);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Wali Kelas</title>
</head>
<body>

<h1>Kelola Wali Kelas</h1>

<p>
    <a href="dashboard.php">Kembali ke Dashboard</a> |
    <a href="tambah_wali_kelas.php">Tambah Wali Kelas</a>
</p>

<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <?php foreach ($kolom as $field) { ?>
            <th><?= htmlspecialchars($field->name) ?></th>
        <?php } ?>
        <th>Aksi</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>
        <tr>
            <?php foreach ($kolom as $field) { ?>
                <td>
                    <?= htmlspecialchars(
                        (string)($row[$field->name] ?? '')
                    ) ?>
                </td>
            <?php } ?>
            <td>
                <a href="edit_wali_kelas.php?id=<?= (int)$row['id'] ?>">
                    Edit
                </a>
                |
                <a href="hapus_wali_kelas.php?id=<?= (int)$row['id'] ?>"
                   onclick="return confirm('Yakin ingin menghapus data ini?')">
                    Hapus
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>