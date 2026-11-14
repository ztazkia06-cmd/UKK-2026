
<?php
// edit_penempatan_siswa.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil ID penempatan
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = "ID penempatan tidak valid.";
    header("Location: penempatan_siswa.php");
    exit;
}

// Ambil data penempatan
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_kelas_siswa WHERE id = ?"
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

// Ambil data kelas yang sedang digunakan
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT nama, tingkat, jurusan
     FROM t_kelas
     WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $data['kelas_id']);
mysqli_stmt_execute($stmt);

$result_kelas = mysqli_stmt_get_result($stmt);
$data_kelas = mysqli_fetch_assoc($result_kelas);

mysqli_stmt_close($stmt);

// Ambil daftar siswa
$siswa = mysqli_query(
    $koneksi,
    "SELECT id, nis, nama, status_aktif
     FROM t_siswa
     ORDER BY nama ASC"
);

// Ambil daftar tahun ajaran
$tahun = mysqli_query(
    $koneksi,
    "SELECT id, nama, status_aktif
     FROM t_tahun_ajaran
     ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Penempatan Siswa</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
          rel="stylesheet">

    <!-- Select2 Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
          rel="stylesheet">

    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-2">Edit Penempatan Siswa</h2>

            <p class="text-muted">
                Ubah data penempatan siswa sesuai kebutuhan.
            </p>

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Edit Penempatan Siswa</h5>
                </div>

                <div class="card-body">

                    <form action="proses_edit_penempatan_siswa.php"
                          method="POST">

                        <input type="hidden"
                               name="id"
                               value="<?= (int) $data['id']; ?>">

                        <!-- SISWA -->
                        <div class="mb-3">

                            <label for="siswa_id" class="form-label">
                                Siswa
                            </label>

                            <select name="siswa_id"
                                    id="siswa_id"
                                    class="form-select"
                                    required>

                                <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>

                                    <option value="<?= (int) $s['id']; ?>"
                                        <?= ((int) $data['siswa_id'] === (int) $s['id']) ? 'selected' : ''; ?>
                                        <?= ((int) $s['status_aktif'] !== 1 && (int) $data['siswa_id'] !== (int) $s['id']) ? 'disabled' : ''; ?>>

                                        <?= htmlspecialchars($s['nis'] . ' - ' . $s['nama']); ?>

                                        <?= ((int) $s['status_aktif'] !== 1) ? ' (Tidak Aktif)' : ''; ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <!-- TAHUN AJARAN -->
                        <div class="mb-3">

                            <label for="tahun_ajaran_id" class="form-label">
                                Tahun Ajaran
                            </label>

                            <select name="tahun_ajaran_id"
                                    id="tahun_ajaran_id"
                                    class="form-select"
                                    required>

                                <?php while ($ta = mysqli_fetch_assoc($tahun)) { ?>

                                    <option value="<?= (int) $ta['id']; ?>"
                                        <?= ((int) $data['tahun_ajaran_id'] === (int) $ta['id']) ? 'selected' : ''; ?>
                                        <?= ((int) $ta['status_aktif'] !== 1 && (int) $data['tahun_ajaran_id'] !== (int) $ta['id']) ? 'disabled' : ''; ?>>

                                        <?= htmlspecialchars($ta['nama']); ?>

                                        <?= ((int) $ta['status_aktif'] !== 1) ? ' (Tidak Aktif)' : ''; ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <!-- KELAS TIDAK BISA DIUBAH -->
                        <div class="mb-3">

                            <label class="form-label">
                                Kelas
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="<?= htmlspecialchars(
                                       ($data_kelas['nama'] ?? '-') .
                                       ' - Tingkat ' .
                                       ($data_kelas['tingkat'] ?? '-') .
                                       ' - ' .
                                       ($data_kelas['jurusan'] ?? '-')
                                   ); ?>"
                                   readonly>

                            <small class="text-muted">
                                Kelas tidak dapat diubah melalui menu edit penempatan.
                            </small>

                        </div>

                        <!-- TANGGAL -->
                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label for="tanggal_mulai" class="form-label">
                                    Tanggal Mulai
                                </label>

                                <input type="date"
                                       name="tanggal_mulai"
                                       id="tanggal_mulai"
                                       class="form-control"
                                       value="<?= htmlspecialchars($data['tanggal_mulai']); ?>"
                                       required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label for="tanggal_selesai" class="form-label">
                                    Tanggal Selesai
                                </label>

                                <input type="date"
                                       name="tanggal_selesai"
                                       id="tanggal_selesai"
                                       class="form-control"
                                       value="<?= htmlspecialchars($data['tanggal_selesai']); ?>"
                                       required>

                            </div>

                        </div>

                        <!-- STATUS -->
                        <div class="mb-3">

                            <label for="status_aktif" class="form-label">
                                Status
                            </label>

                            <select name="status_aktif"
                                    id="status_aktif"
                                    class="form-select"
                                    required>

                                <option value="1"
                                    <?= ((int) $data['status_aktif'] === 1) ? 'selected' : ''; ?>>
                                    Aktif
                                </option>

                                <option value="0"
                                    <?= ((int) $data['status_aktif'] === 0) ? 'selected' : ''; ?>>
                                    Tidak Aktif
                                </option>

                            </select>

                        </div>

                        <!-- TOMBOL -->
                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>

                        <a href="penempatan_siswa.php"
                           class="btn btn-secondary">
                            Kembali
                        </a>

                    </form>

                </div>
            </div>

        </main>

    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {

    $('#siswa_id, #tahun_ajaran_id').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

});
</script>

</body>
</html>
