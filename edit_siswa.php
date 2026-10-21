
<?php
// edit_siswa.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

if (!isset($_GET['nis'])) {
    echo "NIS siswa tidak ditemukan!";
    exit;
}

$nis = mysqli_real_escape_string($koneksi, $_GET['nis']);

$sql = "SELECT * FROM t_siswa WHERE nis = '$nis'";
$hasil = mysqli_query($koneksi, $sql);

if (!$hasil) {
    die("Query gagal: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    echo "Data siswa tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <h3 class="mb-4">Edit Siswa</h3>

            <div class="card">

                <div class="card-header bg-white">
                    <h5 class="mb-0">Form Edit Data Siswa</h5>
                </div>

                <div class="card-body">

                    <a href="kelola_siswa.php"
                       class="btn btn-secondary btn-sm mb-3">
                        Kembali ke Kelola Siswa
                    </a>

                    <form action="proses_edit_siswa.php" method="POST">

                        <input type="hidden" name="id"
                               value="<?= htmlspecialchars($data['id'] ?? ''); ?>">

                        <input type="hidden" name="nis_lama"
                               value="<?= htmlspecialchars($data['nis']); ?>">

                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" name="nis"
                                   class="form-control"
                                   value="<?= htmlspecialchars($data['nis']); ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" name="nisn"
                                   class="form-control"
                                   value="<?= htmlspecialchars($data['nisn']); ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama"
                                   class="form-control"
                                   value="<?= htmlspecialchars($data['nama']); ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                    class="form-control" required>
                                <option value="L"
                                    <?= $data['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>
                                    Laki-laki
                                </option>
                                <option value="P"
                                    <?= $data['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                   class="form-control"
                                   value="<?= htmlspecialchars($data['tanggal_lahir']); ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat"
                                      class="form-control"
                                      rows="3"
                                      required><?= htmlspecialchars($data['alamat']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status Aktif</label>
                            <select name="status_aktif"
                                    class="form-control" required>
                                <option value="1"
                                    <?= (string)$data['status_aktif'] === '1' ? 'selected' : ''; ?>>
                                    Aktif
                                </option>
                                <option value="0"
                                    <?= (string)$data['status_aktif'] === '0' ? 'selected' : ''; ?>>
                                    Tidak Aktif
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>

                        <a href="kelola_siswa.php"
                           class="btn btn-secondary">
                            Batal
                        </a>

                    </form>

                </div>
            </div>

        </main>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
