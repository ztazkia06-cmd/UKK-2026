
<?php
include 'includes/cek_session.php';
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah_wali_kelas.php');
    exit;
}

$id_guru = filter_input(INPUT_POST, 'id_guru', FILTER_VALIDATE_INT);
$id_kelas = filter_input(INPUT_POST, 'id_kelas', FILTER_VALIDATE_INT);
$tahun_ajaran = trim($_POST['tahun_ajaran'] ?? '');

if (!$id_guru || !$id_kelas || $tahun_ajaran === '') {
    die("Semua data wajib diisi dengan benar.");
}

$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO t_wali_kelas (id_guru, id_kelas, tahun_ajaran)
     VALUES (?, ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt, "iis",
    $id_guru, $id_kelas, $tahun_ajaran
);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header('Location: kelola_wali_kelas.php');
    exit;
}

$pesan = mysqli_stmt_error($stmt);
mysqli_stmt_close($stmt);

die("Gagal menyimpan data: " . htmlspecialchars($pesan));
?>