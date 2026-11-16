
<?php
// proses_tambah_siswa.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$nis = $_POST['nis'] ?? '';
$nisn = $_POST['nisn'] ?? '';
$nama = $_POST['nama'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$status_aktif = $_POST['status_aktif'] ?? '';

// Validasi NIS harus berupa 10 digit angka
if (!preg_match('/^[0-9]{10}$/', $nis)) {
    die("NIS harus berupa tepat 10 digit angka!");
}

// Validasi NISN harus berupa 10 digit angka
if (!preg_match('/^[0-9]{10}$/', $nisn)) {
    die("NISN harus berupa tepat 10 digit angka!");
}

$sql = "INSERT INTO t_siswa
        (nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif)
        VALUES
        (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);

if ($stmt) {

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssi",
        $nis,
        $nisn,
        $nama,
        $jenis_kelamin,
        $tanggal_lahir,
        $alamat,
        $status_aktif
    );

    if (mysqli_stmt_execute($stmt)) {

        header("Location: kelola_siswa.php");
        exit;

    } else {

        echo "Gagal menambahkan data siswa: " . mysqli_stmt_error($stmt);

    }

    mysqli_stmt_close($stmt);

} else {

    echo "Gagal menyiapkan query: " . mysqli_error($koneksi);

}
?>
