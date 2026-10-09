
<?php
session_start();

include 'config/koneksi.php';

if (!isset($koneksi) || !$koneksi) {
    die("Koneksi database gagal.");
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("ID wali kelas tidak valid.");
}

$pesan = "";

/* Ambil data wali kelas */
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_wali_kelas WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data wali kelas tidak ditemukan.");
}

/* Proses update */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tahun_ajaran_id = (int) ($_POST['tahun_ajaran_id'] ?? 0);
    $kelas_id = (int) ($_POST['kelas_id'] ?? 0);
    $guru_id = (int) ($_POST['guru_id'] ?? 0);
    $tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
    $tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
    $status_aktif = (int) ($_POST['status_aktif'] ?? 0);

    if (
        $tahun_ajaran_id <= 0 ||
        $kelas_id <= 0 ||
        $guru_id <= 0 ||
        $tanggal_mulai === '' ||
        $tanggal_selesai === '' ||
        !in_array($status_aktif, [0, 1], true)
    ) {
        $pesan = "Semua data wajib diisi dengan benar.";
    } elseif ($tanggal_selesai < $tanggal_mulai) {
        $pesan = "Tanggal selesai tidak boleh sebelum tanggal mulai.";
    } else {
        $update = mysqli_prepare(
            $koneksi,
            "UPDATE t_wali_kelas
             SET tahun_ajaran_id = ?,
                 kelas_id = ?,
                 guru_id = ?,
                 tanggal_mulai = ?,
                 tanggal_selesai = ?,
                 status_aktif = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $update,
            "iiissii",
            $tahun_ajaran_id,
            $kelas_id,
            $guru_id,
            $tanggal_mulai,
            $tanggal_selesai,
            $status_aktif,
            $id
        );

        if (mysqli_stmt_execute($update)) {
            header("Location: kelola_wali_kelas.php");
            exit;
        } else {
            $pesan = "Gagal memperbarui data: " .
                mysqli_stmt_error($update);
        }
    }
}

/* Tampilkan kembali data yang dimasukkan */
$tahun_ajaran_id = $_POST['tahun_ajaran_id']
    ?? $data['tahun_ajaran_id'];

$kelas_id = $_POST['kelas_id']
    ?? $data['kelas_id'];

$guru_id = $_POST['guru_id']
    ?? $data['guru_id'];

$tanggal_mulai = $_POST['tanggal_mulai']
    ?? $data['tanggal_mulai'];

$tanggal_selesai = $_POST['tanggal_selesai']
    ?? $data['tanggal_selesai'];

$status_aktif = $_POST['status_aktif']
    ?? $data['status_aktif'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Wali Kelas</title>
</head>
<body>

<h2>Edit Wali Kelas</h2>

<?php if ($pesan !== ''): ?>
    <p><?php echo htmlspecialchars($pesan); ?></p>
<?php endif; ?>

<form method="POST">
    <label>ID Tahun Ajaran:</label><br>
    <input type="number" name="tahun_ajaran_id"
        value="<?php echo htmlspecialchars((string)$tahun_ajaran_id); ?>"
        required><br><br>

    <label>ID Kelas:</label><br>
    <input type="number" name="kelas_id"
        value="<?php echo htmlspecialchars((string)$kelas_id); ?>"
        required><br><br>

    <label>ID Guru:</label><br>
    <input type="number" name="guru_id"
        value="<?php echo htmlspecialchars((string)$guru_id); ?>"
        required><br><br>

    <label>Tanggal Mulai:</label><br>
    <input type="date" name="tanggal_mulai"
        value="<?php echo htmlspecialchars($tanggal_mulai); ?>"
        required><br><br>

    <label>Tanggal Selesai:</label><br>
    <input type="date" name="tanggal_selesai"
        value="<?php echo htmlspecialchars($tanggal_selesai); ?>"
        required><br><br>

    <label>Status Aktif:</label><br>
    <select name="status_aktif" required>
        <option value="1" <?php echo ((string)$status_aktif === '1') ? 'selected' : ''; ?>>
            Aktif
        </option>
        <option value="0" <?php echo ((string)$status_aktif === '0') ? 'selected' : ''; ?>>
            Tidak Aktif
        </option>
    </select><br><br>

    <button type="submit">Simpan Perubahan</button>
    <a href="kelola_wali_kelas.php">Kembali</a>
</form>

</body>
</html>

