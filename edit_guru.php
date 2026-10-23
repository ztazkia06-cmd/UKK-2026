
<?php
// edit_guru.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID guru tidak valid.");
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare($koneksi, "SELECT * FROM t_guru WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    die("Data guru tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru</title>

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

            <h3 class="mb-4">Edit Guru</h3>

            <div class="card rounded-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0">Form Edit Data Guru</h5>
                </div>

                <div class="card-body">

                    <a href="kelola_guru.php"
                       class="btn btn-secondary btn-sm mb-3">
                        Kembali ke Kelola Guru
                    </a>

                    <form action="proses_edit_guru.php" method="POST">

                        <input type="hidden" name="id"
                               value="<?= (int) $data['id']; ?>">

                        <div class="mb-3">
                            <label class="form-label">NIP</label>

                            <input type="text"
                                   name="nip"
                                   maxlength="10"
                                   class="form-control rounded-0"
                                   value="<?= htmlspecialchars($data['nip'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Guru</label>

                            <input type="text"
                                   name="nama"
                                   class="form-control rounded-0"
                                   value="<?= htmlspecialchars($data['nama'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>

                            <input type="email"
                                   name="email"
                                   class="form-control rounded-0"
                                   value="<?= htmlspecialchars($data['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Aktif</label>

                            <select name="status_aktif"
                                    class="form-select rounded-0"
                                    required>

                                <option value="1"
                                    <?= ($data['status_aktif'] == 1) ? 'selected' : ''; ?>>
                                    Aktif
                                </option>

                                <option value="0"
                                    <?= ($data['status_aktif'] == 0) ? 'selected' : ''; ?>>
                                    Tidak Aktif
                                </option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">User ID</label>

                            <input type="number"
                                   name="user_id"
                                   class="form-control rounded-0"
                                   value="<?= htmlspecialchars((string) ($data['user_id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">
                            Simpan Perubahan
                        </button>

                        <a href="kelola_guru.php"
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
