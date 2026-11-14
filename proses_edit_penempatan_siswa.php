
<?php
// proses_edit_penempatan_siswa.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Pastikan menggunakan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: penempatan_siswa.php");
    exit;
}

// Fungsi untuk menampilkan pesan error
function kembaliDenganError($pesan)
{
    $_SESSION['pesan_error'] = $pesan;
    header("Location: penempatan_siswa.php");
    exit;
}

// Ambil data dari form
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$siswa_id = filter_input(
    INPUT_POST,
    'siswa_id',
    FILTER_VALIDATE_INT
);

$tahun_ajaran_id = filter_input(
    INPUT_POST,
    'tahun_ajaran_id',
    FILTER_VALIDATE_INT
);

$tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
$tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
$status_aktif = $_POST['status_aktif'] ?? '';

// Validasi data wajib
if (
    !$id ||
    !$siswa_id ||
    !$tahun_ajaran_id ||
    empty($tanggal_mulai) ||
    empty($tanggal_selesai) ||
    !in_array((string) $status_aktif, ['0', '1'], true)
) {
    kembaliDenganError("Semua data penempatan wajib diisi.");
}

// Ambil data lama, termasuk kelas asli
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT kelas_id
     FROM t_kelas_siswa
     WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data_lama = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$data_lama) {
    kembaliDenganError("Data penempatan tidak ditemukan.");
}

// Gunakan kelas lama dari database
// Kelas tidak bisa diganti melalui proses edit
$kelas_id = (int) $data_lama['kelas_id'];

// Validasi format tanggal
$mulai = DateTime::createFromFormat('!Y-m-d', $tanggal_mulai);
$selesai = DateTime::createFromFormat('!Y-m-d', $tanggal_selesai);

if (
    !$mulai ||
    !$selesai ||
    $mulai->format('Y-m-d') !== $tanggal_mulai ||
    $selesai->format('Y-m-d') !== $tanggal_selesai
) {
    kembaliDenganError("Format tanggal tidak valid.");
}

// Validasi urutan tanggal
if ($tanggal_selesai < $tanggal_mulai) {
    kembaliDenganError(
        "Tanggal selesai tidak boleh sebelum tanggal mulai."
    );
}

// Pastikan siswa tersedia dan aktif
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id
     FROM t_siswa
     WHERE id = ? AND status_aktif = 1"
);

mysqli_stmt_bind_param($stmt, "i", $siswa_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

$siswa_valid = mysqli_stmt_num_rows($stmt) > 0;

mysqli_stmt_close($stmt);

if (!$siswa_valid) {
    kembaliDenganError("Siswa tidak ditemukan atau tidak aktif.");
}

// Pastikan tahun ajaran tersedia dan aktif
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id
     FROM t_tahun_ajaran
     WHERE id = ? AND status_aktif = 1"
);

mysqli_stmt_bind_param($stmt, "i", $tahun_ajaran_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

$tahun_valid = mysqli_stmt_num_rows($stmt) > 0;

mysqli_stmt_close($stmt);

if (!$tahun_valid) {
    kembaliDenganError(
        "Tahun ajaran tidak ditemukan atau tidak aktif."
    );
}

// Cek penempatan ganda
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id
     FROM t_kelas_siswa
     WHERE siswa_id = ?
     AND tahun_ajaran_id = ?
     AND id <> ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "iii",
    $siswa_id,
    $tahun_ajaran_id,
    $id
);

mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

$duplikat = mysqli_stmt_num_rows($stmt) > 0;

mysqli_stmt_close($stmt);

if ($duplikat) {
    kembaliDenganError(
        "Siswa sudah memiliki penempatan pada tahun ajaran tersebut."
    );
}

// Update data tanpa mengubah kelas
$sql = "UPDATE t_kelas_siswa
        SET
            siswa_id = ?,
            tahun_ajaran_id = ?,
            tanggal_mulai = ?,
            tanggal_selesai = ?,
            status_aktif = ?
        WHERE id = ?";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    kembaliDenganError("Gagal menyiapkan query perubahan data.");
}

mysqli_stmt_bind_param(
    $stmt,
    "iissii",
    $siswa_id,
    $tahun_ajaran_id,
    $tanggal_mulai,
    $tanggal_selesai,
    $status_aktif,
    $id
);

// Jalankan update
if (mysqli_stmt_execute($stmt)) {
    $_SESSION['pesan_sukses'] =
        "Data penempatan siswa berhasil diperbarui.";
} else {
    $_SESSION['pesan_error'] =
        "Gagal memperbarui data: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);

// Kembali ke halaman penempatan
header("Location: penempatan_siswa.php");
exit;
?>
