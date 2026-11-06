
<?php
// logout.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config/koneksi.php';

// Catat aktivitas logout sebelum session dihapus
if (isset($_SESSION['id_user'])) {

    $id_user = (int) $_SESSION['id_user'];
    $waktu = date('Y-m-d H:i:s');
    $aktivitas = 'logout';

    // Cek apakah tabel tbl_log tersedia
    $cek_tabel = mysqli_query($koneksi, "SHOW TABLES LIKE 'tbl_log'");

    if ($cek_tabel && mysqli_num_rows($cek_tabel) > 0) {

        $sql = "INSERT INTO tbl_log (id_user, aktivitas, waktu)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($koneksi, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "iss",
                $id_user,
                $aktivitas,
                $waktu
            );

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}

// Hapus session
session_unset();
session_destroy();

// Kembali ke halaman login
header('Location: login.php');
exit;
?>