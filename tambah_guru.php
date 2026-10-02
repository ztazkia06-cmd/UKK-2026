<?php
// tambah_guru.php
include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Guru</title>
</head>

<body>

    <h1>Tambah Guru</h1>

    <form action="proses_tambah_guru.php" method="POST">

        <table>

            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>
                    <input type="text" name="nip" required>
                </td>
            </tr>

            <tr>
                <td>Nama Guru</td>
                <td>:</td>
                <td>
                    <input type="text" name="nama" required>
                </td>
            </tr>

            <tr>
                <td>Email</td>
                <td>:</td>
                <td>
                    <input type="email" name="email" required>
                </td>
            </tr>

            <tr>
                <td>Status Aktif</td>
                <td>:</td>
                <td>
                    <select name="status_aktif" required>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </td>
            </tr>

            <tr>
    <td>User</td>
    <td>:</td>
    <td>
        <select name="user_id" required>
            <option value="">-- Pilih User --</option>

            <?php
            include 'config/koneksi.php';

            $query_user = mysqli_query($koneksi, "SELECT id FROM t_users ORDER BY id ASC");

            while ($user = mysqli_fetch_assoc($query_user)) {
            ?>
                <option value="<?php echo $user['id']; ?>">
                    User ID: <?php echo $user['id']; ?>
                </option>
            <?php
            }
            ?>

        </select>
    </td>
</tr>
         <tr>
                <td colspan="3">
                    <input type="submit" value="Simpan">
                </td>
            </tr>

        </table>

    </form>

    <p>
        <a href="kelola_guru.php">Kembali</a>
    </p>

</body>

</html>