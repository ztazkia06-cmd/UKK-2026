
<?php
include 'includes/cek_session.php';
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kelola_wali_kelas.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$id_guru = filter_input(INPUT_POST, 'id_guru', FILTER_VALIDATE_INT);
$id_kelas = filter_input(INPUT_POST, 'id_kelas', FILTER_VALIDATE_INT);
$tahun_ajaran = trim($_POST['tahun_ajaran'] ?? '');

if (!$id || !$id_guru || !$id_kelas || $tahun_ajaran === '') {
    die("Data tidak lengkap atau tidak valid.");
}

$stmt = mysqli_prepare(
    $koneksi,
    "UPDATE t_wali_kelas
     SET id_guru = ?, id_kelas = ?, tahun_ajaran = ?
     WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt, "iisi",
    $id_guru, $id_kelas, $tahun_ajaran, $id
);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header('Location: kelola_wali_kelas.php');
    exit;
}

$pesan = mysqli_stmt_error($stmt);
mysqli_stmt_close($stmt);

die("Gagal mengubah data: " . htmlspecialchars($pesan));
?>