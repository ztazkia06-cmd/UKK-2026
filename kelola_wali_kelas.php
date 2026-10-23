
<?php
// kelola_wali_kelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql = "SELECT
            w.*,
            k.nama AS nama_kelas,
            g.nama AS nama_guru
        FROM t_wali_kelas w
        LEFT JOIN t_kelas k ON w.kelas_id = k.id
        LEFT JOIN t_guru g ON w.guru_id = g.id
        ORDER BY w.id DESC";

$hasil = mysqli_query($koneksi, $sql);

if (!$hasil) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Wali Kelas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        main {
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .judul-halaman {
            font-weight: 600;
            margin-bottom: 20px;
        }

        #tabelWaliKelas th,
        #tabelWaliKelas td {
            vertical-align: middle;
        }

        .btn-aksi {
            margin: 2px;
        }

        .dataTables_wrapper {
            padding-top: 10px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <?php include 'layout/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4">
            <h3 class="judul-halaman">Kelola Wali Kelas</h3>

            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0">Data Wali Kelas</h5>

                    <a href="tambah_wali_kelas.php"
                       class="btn btn-primary btn-sm">
                        + Tambah Wali Kelas
                    </a>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <a href="dashboard.php"
                           class="btn btn-secondary btn-sm">
                            Kembali ke Dashboard
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table id="tabelWaliKelas"
                               class="table table-striped table-bordered table-hover"
                               style="width:100%">

                            <thead class="table-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>ID</th>
                                    <th>Tahun Ajaran ID</th>
                                    <th>Kelas</th>
                                    <th>Guru</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($hasil)) {
                                    $id = (string) $row['id'];
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars((string) ($row['tahun_ajaran_id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars((string) ($row['nama_kelas'] ?? '-'), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars((string) ($row['nama_guru'] ?? '-'), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars((string) ($row['tanggal_mulai'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars((string) ($row['tanggal_selesai'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <?php if ((int) $row['status_aktif'] === 1) : ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="edit_wali_kelas.php?id=<?= urlencode($id); ?>"
                                               class="btn btn-warning btn-sm btn-aksi">
                                                Edit
                                            </a>

                                            <a href="hapus_wali_kelas.php?id=<?= urlencode($id); ?>"
                                               class="btn btn-danger btn-sm btn-aksi"
                                               onclick="return confirm('Yakin ingin menghapus data wali kelas ini?');">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#tabelWaliKelas').DataTable({
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data wali kelas",
            infoEmpty: "Tidak ada data wali kelas",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data wali kelas tidak ditemukan",
            emptyTable: "Belum ada data wali kelas",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        searching: true,
        ordering: true,
        paging: true,
        columnDefs: [
            {
                targets: [0, 8],
                orderable: false
            }
        ],
        order: [[1, 'desc']]
    });
});
</script>

</body>
</html>
