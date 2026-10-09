
<?php
include 'includes/cek_session.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Wali Kelas</title>
</head>
<body>

<h1>Tambah Wali Kelas</h1>

<form action="proses_tambah_wali_kelas.php" method="POST">
    <table cellpadding="6">
        <tr>
            <td>ID Guru</td>
            <td>:</td>
            <td>
                <input type="number" name="id_guru" min="1" required>
            </td>
        </tr>
        <tr>
            <td>ID Kelas</td>
            <td>:</td>
            <td>
                <input type="number" name="id_kelas" min="1" required>
            </td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td>:</td>
            <td>
                <input type="text" name="tahun_ajaran"
                       placeholder="Contoh: 2026/2027" required>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <button type="submit">Simpan</button>
            </td>
        </tr>
    </table>
</form>

<p><a href="kelola_wali_kelas.php">Kembali</a></p>

</body>
</html>