
<?php
// about_me.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Data diri
$nama = "Tazkia Zahr4444a";
$kelas = "XI RPL";
$sekolah = "SMK Muhammadiyah Tasikmalaya";
$jurusan = "Rekayasa Perangkat Lunak";
$hobi = "Mendengarkan Musik";
$cita_cita = "Pramugari";

$folder = "uploads/profil/";
$pesan = "";

// Foto profil
if (!isset($_SESSION['foto_profil'])) {
    $_SESSION['foto_profil'] = "";
}

// Proses upload foto
if (isset($_POST['upload_foto'])) {

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {

        $tmpFile = $_FILES['foto']['tmp_name'];
        $ukuran = $_FILES['foto']['size'];
        $gambar = getimagesize($tmpFile);

        if ($gambar !== false && $ukuran <= 2000000) {

            $ekstensi = strtolower(
                pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION)
            );

            $ekstensiValid = ['jpg', 'jpeg', 'png'];

            if (in_array($ekstensi, $ekstensiValid)) {

                if (!is_dir($folder)) {
                    mkdir($folder, 0777, true);
                }

                $namaBaru = uniqid() . "." . $ekstensi;
                $tujuan = $folder . $namaBaru;

                if (move_uploaded_file($tmpFile, $tujuan)) {
                    $_SESSION['foto_profil'] = $tujuan;
                    $pesan = "Foto profil berhasil diperbarui.";
                } else {
                    $pesan = "Foto gagal diunggah.";
                }

            } else {
                $pesan = "Format foto harus JPG, JPEG, atau PNG.";
            }

        } else {
            $pesan = "Ukuran foto maksimal 2 MB.";
        }

    } else {
        $pesan = "Silakan pilih foto terlebih dahulu.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About Me</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background-color: #ffffff;
            color: #212529;
        }

        .konten {
            padding: 30px;
        }

        .judul {
            color: #212529;
            font-weight: bold;
        }

        .profil-card {
            background: white;
            border: 1px solid #0d6efd;
            border-radius: 7px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }

        .bagian-profil {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
        }

        .foto-profil {
            width: 170px;
            height: 170px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #0d6efd;
        }

        .nama {
            color: #0d6efd;
            font-weight: bold;
        }

        .badge-kelas {
            background: #0d6efd;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
        }

        .info-item {
            padding: 12px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #0d6efd;
            font-weight: bold;
        }

        .deskripsi {
            background: #f8f9fa;
            border-left: 4px solid #0d6efd;
            padding: 20px;
            border-radius: 5px;
        }

        .btn-sage {
            background: #0d6efd;
            color: white;
            border: none;
        }

        .btn-sage:hover {
            background: #0b5ed7;
            color: white;
        }

        @media (max-width: 768px) {
            .konten {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <?php include 'layout/sidebar.php'; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 konten">

            <!-- JUDUL -->
            <div class="mb-4">
                <h2 class="judul mb-1">About Me</h2>
                <p class="text-muted">
                    Selamat datang di halaman profil pribadi saya.
                </p>
            </div>

            <!-- PESAN -->
            <?php if ($pesan != "") { ?>
                <div class="alert alert-info">
                    <?= htmlspecialchars($pesan); ?>
                </div>
            <?php } ?>

            <!-- PROFIL -->
            <div class="profil-card p-4 mb-4">

                <div class="row align-items-center">

                    <!-- FOTO DAN IDENTITAS -->
                    <div class="col-lg-4 text-center mb-4 mb-lg-0">

                        <div class="bagian-profil">

                            <?php if (!empty($_SESSION['foto_profil']) &&
                                      file_exists($_SESSION['foto_profil'])) { ?>

                                <img src="<?= htmlspecialchars($_SESSION['foto_profil']); ?>"
                                     alt="Foto Profil"
                                     class="foto-profil">

                            <?php } else { ?>

                                <img src="https://via.placeholder.com/170"
                                     alt="Foto Profil"
                                     class="foto-profil">

                            <?php } ?>

                            <h4 class="nama mt-3 mb-2">
                                <?= htmlspecialchars($nama); ?>
                            </h4>

                            <span class="badge-kelas">
                                <?= htmlspecialchars($kelas); ?>
                            </span>

                            <p class="text-muted mt-3 mb-3">
                                Pelajar Rekayasa Perangkat Lunak
                            </p>

                            <!-- GANTI FOTO PROFIL -->
                            <form method="POST" enctype="multipart/form-data">

                                <input type="file"
                                       name="foto"
                                       class="form-control form-control-sm mb-2"
                                       accept=".jpg,.jpeg,.png"
                                       required>

                                <small class="text-muted d-block mb-3">
                                    JPG, JPEG, PNG maksimal 2 MB
                                </small>

                                <button type="submit"
                                        name="upload_foto"
                                        class="btn btn-sage w-100">
                                    Ganti Foto Profil
                                </button>

                            </form>

                        </div>

                    </div>

                    <!-- INFORMASI DIRI -->
                    <div class="col-lg-8">

                        <h4 class="judul mb-3">
                            Informasi Pribadi
                        </h4>

                        <div class="info-item">
                            <div class="info-label">Nama Lengkap</div>
                            <?= htmlspecialchars($nama); ?>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Kelas</div>
                            <?= htmlspecialchars($kelas); ?>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Sekolah</div>
                            <?= htmlspecialchars($sekolah); ?>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Jurusan</div>
                            <?= htmlspecialchars($jurusan); ?>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Hobi</div>
                            <?= htmlspecialchars($hobi); ?>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Cita-cita</div>
                            <?= htmlspecialchars($cita_cita); ?>
                        </div>

                    </div>

                </div>

            </div>

            <!-- DESKRIPSI -->
            <div class="profil-card p-4 mb-4">

                <h4 class="judul mb-3">
                    Tentang Saya
                </h4>

                <div class="deskripsi">
                    Halo! Perkenalkan, nama saya
                    <strong><?= htmlspecialchars($nama); ?></strong>.
                    Saya merupakan siswi kelas
                    <?= htmlspecialchars($kelas); ?> di
                    <?= htmlspecialchars($sekolah); ?>.

                    Saya mengambil jurusan
                    <?= htmlspecialchars($jurusan); ?> dan memiliki hobi
                    <?= htmlspecialchars($hobi); ?>.

                    Saya ingin terus belajar, mencoba hal baru, dan
                    mengembangkan kemampuan diri agar bisa meraih
                    cita-cita menjadi
                    <?= htmlspecialchars($cita_cita); ?>.
                </div>

            </div>

            <!-- KEMBALI -->
            <div class="mb-3">
                <a href="dashboard.php" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- FOOTER -->
            <div class="text-center text-muted mt-4">
                &copy; <?= date('Y'); ?>
                <?= htmlspecialchars($nama); ?>
            </div>

        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
