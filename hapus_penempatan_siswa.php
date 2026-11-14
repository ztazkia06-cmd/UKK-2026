
<?php
// hapus_penempatan_siswa.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = "ID penempatan tidak valid.";
    header("Location: penempatan_siswa.php");
    exit;
}

// Cek data penempatan
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_kelas_siswa WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$data) {
    $_SESSION['pesan_error'] = "Data penempatan tidak ditemukan.";
    header("Location: penempatan_siswa.php");
    exit;
}

// Hapus data
$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM t_kelas_siswa WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['pesan_sukses'] = "Data penempatan berhasil dihapus.";
} else {
    $_SESSION['pesan_error'] = "Data penempatan gagal dihapus: " . mysqli_error($koneksi);
}

mysqli_stmt_close($stmt);

header("Location: penempatan_siswa.php");
exit;
?>
