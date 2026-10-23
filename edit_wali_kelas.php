
<?php
// edit_wali_kelas.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID wali kelas tidak valid.");
}

$id = (int) $_GET['id'];

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

$pesan = "";

/* Proses update */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tahun_ajaran_id = (int) ($_POST['tahun_ajaran_id'] ?? 0);
    $kelas_id = (int) ($_POST['kelas_id'] ?? 0);
    $guru_id = (int) ($_POST['guru_id'] ?? 0);
    $tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
    $tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
    $status_aktif = (int) ($_POST['status_aktif'] ?? -1);

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
            $pesan = "Gagal memperbarui data wali kelas.";
        }
    }
}

/* Nilai form */
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Wali Kelas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-3 col-md-3 col-lg-2 bg-dark text-white min-vh-100 p-3">

            <h4 class="mb-4">Pelanggaran Siswa</h4>

            <a href="dashboard.php"
               class="d-block text-white text-decoration-none p-2 mb-2">
                Dashboard
            </a>

            <a href="kelola_siswa.php"
               class="d-block text-white text-decoration-none p-2 mb-2">
                Data Siswa
            </a>

            <a href="kelola_guru.php"
               class="d-block text-white text-decoration-none p-2 mb-2">
                Data Guru
            </a>

            <a href="kelola_kelas.php"
               class="d-block text-white text-decoration-none p-2 mb-2">
                Data Kelas
            </a>

            <a href="kelola_tahun_ajaran.php"
               class="d-block text-white text-decoration-none p-2 mb-2">
                Data Tahun Ajaran
            </a>

            <a href="kelola_wali_kelas.php"
               class="d-block text-white text-decoration-none p-2 mb-2">
                Data Wali Kelas
            </a>

            <a href="penempatan_siswa.php"
               class="d-block text-white text-decoration-none p-2 mb-2">
                Penempatan Siswa
            </a>

            <a href="kelola_pelanggaran_kategori.php"
               class="d-block text-white text-decoration-none p-2 mb-2">
                Kategori Pelanggaran
            </a>

            <a href="about_me.php"
               class="d-block text-white text-decoration-none p-2 mb-2">
                About Me
            </a>

            <br><br>

            <a href="logout.php"
               class="d-block text-danger text-decoration-none p-2">
                Logout
            </a>

        </div>

        <!-- Konten Utama -->
        <div class="col-9 col-md-9 col-lg-10 p-4">

            <h3 class="mb-4">Edit Wali Kelas</h3>

            <div class="card rounded-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0">Form Edit Wali Kelas</h5>
                </div>

                <div class="card-body">

                    <a href="kelola_wali_kelas.php"
                       class="btn btn-secondary btn-sm mb-3">
                        Kembali ke Kelola Wali Kelas
                    </a>

                    <?php if ($pesan !== ''): ?>
                        <div class="alert alert-danger rounded-0">
                            <?= htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    <?php endif; ?>

                    <form action="edit_wali_kelas.php?id=<?= $id; ?>"
                          method="POST">

                        <div class="mb-3">
                            <label class="form-label">ID Tahun Ajaran</label>

                            <input type="number"
                                   name="tahun_ajaran_id"
                                   class="form-control rounded-0"
                                   min="1"
                                   value="<?= htmlspecialchars((string) $tahun_ajaran_id, ENT_QUOTES, 'UTF-8'); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ID Kelas</label>

                            <input type="number"
                                   name="kelas_id"
                                   class="form-control rounded-0"
                                   min="1"
                                   value="<?= htmlspecialchars((string) $kelas_id, ENT_QUOTES, 'UTF-8'); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ID Guru</label>

                            <input type="number"
                                   name="guru_id"
                                   class="form-control rounded-0"
                                   min="1"
                                   value="<?= htmlspecialchars((string) $guru_id, ENT_QUOTES, 'UTF-8'); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>

                            <input type="date"
                                   name="tanggal_mulai"
                                   class="form-control rounded-0"
                                   value="<?= htmlspecialchars($tanggal_mulai, ENT_QUOTES, 'UTF-8'); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>

                            <input type="date"
                                   name="tanggal_selesai"
                                   class="form-control rounded-0"
                                   value="<?= htmlspecialchars($tanggal_selesai, ENT_QUOTES, 'UTF-8'); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Aktif</label>

                            <select name="status_aktif"
                                    class="form-select rounded-0"
                                    required>

                                <option value="1"
                                    <?= (string) $status_aktif === '1' ? 'selected' : ''; ?>>
                                    Aktif
                                </option>

                                <option value="0"
                                    <?= (string) $status_aktif === '0' ? 'selected' : ''; ?>>
                                    Tidak Aktif
                                </option>

                            </select>
                        </div>

                        <button type="submit"
                                class="btn btn-primary btn-sm">
                            Simpan Perubahan
                        </button>

                        <a href="kelola_wali_kelas.php"
                           class="btn btn-secondary btn-sm">
                            Batal
                        </a>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
