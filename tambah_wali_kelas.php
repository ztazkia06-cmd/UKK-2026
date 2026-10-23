
<?php
// tambah_wali_kelas.php

include 'includes/cek_session.php';
include 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Wali Kelas</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <?php include 'layout/sidebar.php'; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h1 class="mb-4">Tambah Wali Kelas</h1>

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    Form Tambah Wali Kelas
                </div>

                <div class="card-body">

                    <form action="proses_tambah_wali_kelas.php"
                          method="POST"
                          id="formTambahWaliKelas">

                        <div class="mb-3">
                            <label for="id_guru" class="form-label">
                                ID Guru
                            </label>

                            <input
                                type="number"
                                name="id_guru"
                                id="id_guru"
                                class="form-control"
                                min="1"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="id_kelas" class="form-label">
                                ID Kelas
                            </label>

                            <input
                                type="number"
                                name="id_kelas"
                                id="id_kelas"
                                class="form-control"
                                min="1"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="tahun_ajaran" class="form-label">
                                Tahun Ajaran
                            </label>

                            <input
                                type="text"
                                name="tahun_ajaran"
                                id="tahun_ajaran"
                                class="form-control"
                                placeholder="Contoh: 2026/2027"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan Wali Kelas
                        </button>

                        <a href="kelola_wali_kelas.php"
                           class="btn btn-secondary">
                            Kembali
                        </a>

                    </form>

                </div>
            </div>

        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
