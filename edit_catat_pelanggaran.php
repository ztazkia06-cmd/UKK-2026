
<?php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil role login
$role = $_SESSION['role'] ?? '';
$isWaliKelas = ($role === 'guru');

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    $_SESSION['pesan_error'] = "ID pelanggaran tidak valid.";
    header("Location: catat_pelanggaran.php");
    exit;
}

$id = (int) $_GET['id'];

// Ambil data pelanggaran
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_pelanggaran_siswa WHERE id = ?"
);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);
mysqli_stmt_close($stmt);

if (!$data) {
    $_SESSION['pesan_error'] = "Data pelanggaran tidak ditemukan.";
    header("Location: catat_pelanggaran.php");
    exit;
}

// Daftar siswa
$siswa = mysqli_query($koneksi, "
    SELECT id, nis, nama
    FROM t_siswa
    WHERE status_aktif = 1 OR id = " . (int)$data['siswa_id'] . "
    ORDER BY nama ASC
");

// Daftar tahun ajaran
$tahun = mysqli_query($koneksi, "
    SELECT id, nama
    FROM t_tahun_ajaran
    WHERE status_aktif = 1 OR id = " . (int)$data['tahun_ajaran_id'] . "
    ORDER BY id DESC
");

// Daftar kelas
$kelas = mysqli_query($koneksi, "
    SELECT id, nama, tingkat, jurusan
    FROM t_kelas
    WHERE status_aktif = 1 OR id = " . (int)$data['kelas_id'] . "
    ORDER BY nama ASC
");

// Daftar pelanggaran
$pelanggaran = mysqli_query($koneksi, "
    SELECT id, nama, poin, pelanggaran_kategori_id
    FROM t_pelanggaran
    WHERE status_aktif = 1 OR id = " . (int)$data['pelanggaran_id'] . "
    ORDER BY nama ASC
");

function e($nilai) {
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Catatan Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-4">Edit Catatan Pelanggaran Siswa</h2>

            <div class="card">
                <div class="card-header bg-primary text-light">
                    Form Edit Pelanggaran
                </div>

                <div class="card-body">

                    <form action="proses_edit_catat_pelanggaran.php"
                          method="POST">

                        <input type="hidden" name="id"
                               value="<?php echo (int)$data['id']; ?>">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Siswa</label>

                                <select name="siswa_id"
                                        class="form-select" required>

                                    <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
                                        <option value="<?php echo $s['id']; ?>"
                                            <?php echo $data['siswa_id'] == $s['id'] ? 'selected' : ''; ?>>

                                            <?php echo e($s['nis'].' - '.$s['nama']); ?>

                                        </option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Ajaran</label>

                                <select name="tahun_ajaran_id"
                                        class="form-select" required>

                                    <?php while ($ta = mysqli_fetch_assoc($tahun)) { ?>
                                        <option value="<?php echo $ta['id']; ?>"
                                            <?php echo $data['tahun_ajaran_id'] == $ta['id'] ? 'selected' : ''; ?>>

                                            <?php echo e($ta['nama']); ?>

                                        </option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas</label>

                                <select name="kelas_id"
                                        class="form-select"
                                        <?php echo $isWaliKelas ? 'disabled' : ''; ?>
                                        required>

                                    <?php while ($k = mysqli_fetch_assoc($kelas)) { ?>
                                        <option value="<?php echo $k['id']; ?>"
                                            <?php echo $data['kelas_id'] == $k['id'] ? 'selected' : ''; ?>>

                                            <?php echo e(
                                                $k['nama'].' - '.
                                                $k['tingkat'].' - '.
                                                $k['jurusan']
                                            ); ?>

                                        </option>
                                    <?php } ?>

                                </select>

                                <?php if ($isWaliKelas) { ?>
                                    <input type="hidden"
                                           name="kelas_id"
                                           value="<?php echo (int)$data['kelas_id']; ?>">
                                <?php } ?>

                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Pelanggaran</label>

                                <select name="pelanggaran_id"
                                        id="pelanggaran"
                                        class="form-select" required>

                                    <?php while ($p = mysqli_fetch_assoc($pelanggaran)) { ?>
                                        <option
                                            value="<?php echo $p['id']; ?>"
                                            data-poin="<?php echo $p['poin']; ?>"
                                            data-kategori="<?php echo $p['pelanggaran_kategori_id']; ?>"
                                            <?php echo $data['pelanggaran_id'] == $p['id'] ? 'selected' : ''; ?>>

                                            <?php echo e(
                                                $p['nama'].' ('.$p['poin'].' poin)'
                                            ); ?>

                                        </option>
                                    <?php } ?>

                                </select>

                                <input type="hidden"
                                       name="pelanggaran_kategori_id"
                                       id="kategori"
                                       value="<?php echo (int)$data['pelanggaran_kategori_id']; ?>">

                                <small class="text-muted" id="infoPoin"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal</label>

                                <input type="date"
                                       name="tanggal"
                                       class="form-control"
                                       value="<?php echo e($data['tanggal']); ?>"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>

                                <select name="status"
                                        class="form-select" required>

                                    <?php
                                    $statusList = [
                                        'Ditindaklanjuti',
                                        'Proses',
                                        'Selesai'
                                    ];

                                    foreach ($statusList as $st) {
                                    ?>
                                        <option value="<?php echo e($st); ?>"
                                            <?php echo $data['status'] == $st ? 'selected' : ''; ?>>

                                            <?php echo e($st); ?>

                                        </option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Keterangan</label>

                                <textarea name="keterangan"
                                          class="form-control"
                                          rows="3"><?php echo e($data['keterangan']); ?></textarea>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>

                        <a href="catat_pelanggaran.php"
                           class="btn btn-secondary">
                            Kembali
                        </a>

                    </form>

                </div>
            </div>

        </main>
    </div>
</div>

<script>
const pilihanPelanggaran = document.getElementById('pelanggaran');
const inputKategori = document.getElementById('kategori');
const infoPoin = document.getElementById('infoPoin');

function tampilkanPoin() {
    const opsi = pilihanPelanggaran.options[pilihanPelanggaran.selectedIndex];

    if (opsi) {
        infoPoin.textContent = 'Poin pelanggaran: ' + (opsi.dataset.poin || '0');
        inputKategori.value = opsi.dataset.kategori || '';
    }
}

pilihanPelanggaran.addEventListener('change', tampilkanPoin);

tampilkanPoin();
</script>

</body>
</html>
