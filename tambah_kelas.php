
<?php
// tambah_kelas.php

include 'includes/cek_session.php';
include 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Kelas</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Dropdown Jurusan */
        .jurusan-dropdown {
            position: relative;
            width: 100%;
        }

        /* Tombol Jurusan menyerupai select Bootstrap */
        #dropdownJurusan {
            width: 100%;
            text-align: left;
            font-weight: normal;
            color: #212529;
            background-color: #fff;
            cursor: pointer;
        }

        /* Memaksa menu muncul ke bawah */
        .jurusan-dropdown .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            bottom: auto !important;
            left: 0 !important;
            right: auto !important;
            transform: none !important;
            width: 100%;
            margin-top: 2px !important;
            z-index: 1060;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <?php include 'layout/sidebar.php'; ?>

            <!-- Konten Utama -->
            <main class="col-md-9 col-lg-10 p-4">

                <h3 class="mb-4">Tambah Kelas</h3>

                <div class="card shadow-sm">

                    <div class="card-header bg-primary text-white">
                        Form Tambah Kelas
                    </div>

                    <div class="card-body">

                        <form action="proses_tambah_kelas.php"
                              method="POST"
                              id="formTambahKelas">

                            <!-- Nama Kelas -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Nama Kelas
                                </label>

                                <input
                                    type="text"
                                    name="nama"
                                    id="nama"
                                    class="form-control"
                                    placeholder="Masukkan nama kelas"
                                    required>
                            </div>

                            <!-- Tingkat -->
                            <div class="mb-3">
                                <label for="tingkat" class="form-label">
                                    Tingkat
                                </label>

                                <select
                                    name="tingkat"
                                    id="tingkat"
                                    class="form-select"
                                    required>

                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>

                                </select>
                            </div>

                            <!-- Jurusan -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Jurusan
                                </label>

                                <input
                                    type="hidden"
                                    name="jurusan"
                                    id="jurusan">

                                <div class="jurusan-dropdown dropdown">

                                    <button
                                        type="button"
                                        class="form-select"
                                        id="dropdownJurusan"
                                        data-bs-toggle="dropdown"
                                        data-bs-display="static"
                                        aria-expanded="false">

                                        <span id="teksJurusan">
                                            -- Pilih Jurusan --
                                        </span>

                                    </button>

                                    <ul class="dropdown-menu">

                                        <li>
                                            <button type="button"
                                                class="dropdown-item"
                                                onclick="pilihJurusan('RPL')">
                                                RPL
                                            </button>
                                        </li>

                                        <li>
                                            <button type="button"
                                                class="dropdown-item"
                                                onclick="pilihJurusan('TKJ')">
                                                TKJ
                                            </button>
                                        </li>

                                        <li>
                                            <button type="button"
                                                class="dropdown-item"
                                                onclick="pilihJurusan('TKR')">
                                                TKR
                                            </button>
                                        </li>

                                        <li>
                                            <button type="button"
                                                class="dropdown-item"
                                                onclick="pilihJurusan('TSM')">
                                                TSM
                                            </button>
                                        </li>

                                        <li>
                                            <button type="button"
                                                class="dropdown-item"
                                                onclick="pilihJurusan('BD')">
                                                BD
                                            </button>
                                        </li>

                                    </ul>

                                </div>
                            </div>

                            <!-- Status Aktif -->
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

                            <!-- Tombol -->
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>

                            <a href="kelola_kelas.php" class="btn btn-secondary">
                                Kembali
                            </a>

                        </form>

                    </div>
                </div>

            </main>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Memilih jurusan
        function pilihJurusan(nilai) {
            document.getElementById('jurusan').value = nilai;
            document.getElementById('teksJurusan').textContent = nilai;

            // Tutup dropdown setelah memilih
            const tombol = document.getElementById('dropdownJurusan');
            const dropdown = bootstrap.Dropdown.getOrCreateInstance(tombol);
            dropdown.hide();
        }

        // Validasi sebelum menyimpan
        document.getElementById('formTambahKelas').addEventListener('submit', function(e) {

            const jurusan = document.getElementById('jurusan').value;

            if (jurusan === '') {
                e.preventDefault();
                alert('Silakan pilih jurusan terlebih dahulu!');
            }

        });
    </script>

</body>
</html>
