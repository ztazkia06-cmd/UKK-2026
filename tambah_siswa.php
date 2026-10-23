
<?php
// tambah_siswa.php
include 'includes/cek_session.php';
include 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Siswa</title>

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

            <h1 class="mb-4">Tambah Siswa</h1>

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    Form Tambah Siswa
                </div>

                <div class="card-body">

                    <form action="proses_tambah_siswa.php"
                          method="POST"
                          id="formTambahSiswa">

                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <input
                                type="text"
                                name="nis"
                                id="nis"
                                maxlength="10"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input
                                type="text"
                                name="nisn"
                                id="nisn"
                                maxlength="10"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Siswa</label>
                            <input
                                type="text"
                                name="nama"
                                id="nama"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">
                                Jenis Kelamin
                            </label>

                            <select
                                name="jenis_kelamin"
                                id="jenis_kelamin"
                                class="form-select"
                                required>

                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">
                                Tanggal Lahir
                            </label>

                            <input
                                type="date"
                                name="tanggal_lahir"
                                id="tanggal_lahir"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>

                            <textarea
                                name="alamat"
                                id="alamat"
                                class="form-control"
                                rows="4"
                                required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="status_aktif" class="form-label">
                                Status Aktif
                            </label>

                            <select
                                name="status_aktif"
                                id="status_aktif"
                                class="form-select"
                                required>

                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan Siswa
                        </button>

                        <a href="kelola_siswa.php" class="btn btn-secondary">
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
