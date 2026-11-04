
<?php
// kelola_jenis_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil data jenis pelanggaran beserta nama kategorinya
$sql = "SELECT
            p.id,
            p.pelanggaran_kategori_id,
            pk.nama AS nama_kategori,
            p.kode,
            p.nama,
            p.poin,
            p.deskripsi,
            p.status_aktif,
            p.created_at,
            p.updated_at
        FROM t_pelanggaran p
        LEFT JOIN t_pelanggaran_kategori pk
            ON p.pelanggaran_kategori_id = pk.id
        ORDER BY p.nama ASC";

$hasil = mysqli_query($koneksi, $sql);

if (!$hasil) {
    die("Gagal mengambil data: " .
        htmlspecialchars(mysqli_error($koneksi)));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Jenis Pelanggaran</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2>Kelola Jenis Pelanggaran</h2>
            <p>Selamat datang di halaman Jenis Pelanggaran.</p>

            <?php if (isset($_SESSION['pesan_sukses'])) { ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['pesan_sukses']); ?>
                </div>
                <?php unset($_SESSION['pesan_sukses']); ?>
            <?php } ?>

            <?php if (isset($_SESSION['pesan_error'])) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['pesan_error']); ?>
                </div>
                <?php unset($_SESSION['pesan_error']); ?>
            <?php } ?>

            <div class="mb-3">
                <a href="dashboard.php" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>

                <a href="tambah_jenis_pelanggaran.php"
                   class="btn btn-primary">
                    Tambah Jenis Pelanggaran
                </a>
            </div>

            <!-- TABEL JENIS PELANGGARAN -->
            <div class="table-responsive">

                <table id="tabelPelanggaran"
                       class="table table-striped table-bordered table-hover">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Kategori</th>
                            <th>Kode</th>
                            <th>Nama Pelanggaran</th>
                            <th>Poin</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th>Diubah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $no = 1;

                    while ($row = mysqli_fetch_assoc($hasil)) {
                    ?>

                        <tr>
                            <td><?php echo $no++; ?></td>

                            <td>
                                <?php echo (int) $row['id']; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['nama_kategori'] ?? '-'); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['kode'] ?? ''); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['nama'] ?? ''); ?>
                            </td>

                            <td>
                                <?php echo (int) $row['poin']; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['deskripsi'] ?? '-'); ?>
                            </td>

                            <td>
                                <?php
                                echo ($row['status_aktif'] == 1)
                                    ? 'Aktif'
                                    : 'Tidak Aktif';
                                ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['created_at'] ?? '-'); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['updated_at'] ?? '-'); ?>
                            </td>

                            <td>
                                <a href="edit_jenis_pelanggaran.php?id=<?php echo urlencode($row['id']); ?>"
                                   class="btn btn-primary btn-sm">
                                    Edit
                                </a>

                                <a href="hapus_jenis_pelanggaran.php?id=<?php echo urlencode($row['id']); ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menghapus jenis pelanggaran ini?');">
                                    Hapus
                                </a>
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </main>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Mengaktifkan DataTables -->
<script>
$(document).ready(function () {

    $('#tabelPelanggaran').DataTable({

        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data jenis pelanggaran",
            zeroRecords: "Data jenis pelanggaran tidak ditemukan",
            emptyTable: "Belum ada data jenis pelanggaran",

            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        columnDefs: [
            {
                targets: [0, 10],
                orderable: false,
                searchable: false
            }
        ],

        order: [],

        drawCallback: function () {
            var api = this.api();
            var info = api.page.info();

            api.column(0, {
                page: 'current'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = info.start + i + 1;
            });
        }

    });

});
</script>

</body>
</html>
