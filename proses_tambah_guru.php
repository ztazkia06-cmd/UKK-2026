
<?php
// proses_tambah_guru.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Mengambil data dari form
$nip = $_POST['nip'] ?? '';
$nama = $_POST['nama'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$konfirmasi_password = $_POST['konfirmasi_password'] ?? '';
$status_aktif = $_POST['status_aktif'] ?? '';

// Memeriksa data kosong
if (
    empty($nip) ||
    empty($nama) ||
    empty($email) ||
    empty($password) ||
    empty($konfirmasi_password)
) {
    die("Semua data wajib diisi!");
}

// Memeriksa konfirmasi password
if ($password !== $konfirmasi_password) {
    die("Konfirmasi password tidak sesuai!");
}

// Memeriksa email yang sudah digunakan
$cek_email = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_users WHERE email = ?"
);

mysqli_stmt_bind_param($cek_email, "s", $email);
mysqli_stmt_execute($cek_email);

$hasil_cek = mysqli_stmt_get_result($cek_email);

if (mysqli_num_rows($hasil_cek) > 0) {
    die("Email sudah digunakan!");
}

// Mengenkripsi password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Memulai transaksi
mysqli_begin_transaction($koneksi);

try {

    // Membuat akun pengguna di t_users
    $role = "guru";

    $sql_user = mysqli_prepare(
        $koneksi,
        "INSERT INTO t_users (name, email, password, role)
         VALUES (?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $sql_user,
        "ssss",
        $nama,
        $email,
        $password_hash,
        $role
    );

    mysqli_stmt_execute($sql_user);

    // Mengambil ID user yang baru dibuat
    $user_id = mysqli_insert_id($koneksi);

    // Menambahkan data guru ke t_guru
    $sql_guru = mysqli_prepare(
        $koneksi,
        "INSERT INTO t_guru
        (nip, nama, email, status_aktif, user_id)
        VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $sql_guru,
        "sssii",
        $nip,
        $nama,
        $email,
        $status_aktif,
        $user_id
    );

    mysqli_stmt_execute($sql_guru);

    // Menyimpan semua perubahan
    mysqli_commit($koneksi);

    header("Location: kelola_guru.php");
    exit;

} catch (Exception $e) {

    // Membatalkan jika terjadi error
    mysqli_rollback($koneksi);

    die("Gagal menambahkan guru: " . $e->getMessage());
}
?>
