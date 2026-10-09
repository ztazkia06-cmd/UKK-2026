
<?php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: kelola_wali_kelas.php');
    exit;
}

$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM t_wali_kelas WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    $terhapus = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($terhapus > 0) {
        echo "<script>
            alert('Data wali kelas berhasil dihapus!');
            window.location.href='kelola_wali_kelas.php';
        </script>";
    } else {
        echo "<script>
            alert('Data wali kelas tidak ditemukan!');
            window.location.href='kelola_wali_kelas.php';
        </script>";
    }
    exit;
}

$pesan = mysqli_stmt_error($stmt);
mysqli_stmt_close($stmt);

die("Gagal menghapus data: " . htmlspecialchars($pesan));
?>