<?php
// kelola_jenis_pelanggaran.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil data jenis pelanggaran beserta kategori
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
    die("Query gagal: " . htmlspecialchars(
        mysqli_error($koneksi),
        ENT_QUOTES,
        'UTF-8'
    ));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Jenis Pelanggaran</title>

    <!-- Bootstrap 4 -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">

    <!-- DataTables -->
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">

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

        #tabelPelanggaran th,
        #tabelPelanggaran td {
            vertical-align: middle;
        }

        .dataTables_wrapper {
            padding-top: 10px;
        }

        .btn-aksi {
            margin: 2px;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <?php include 'layout/sidebar.php'; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h3 class="judul-halaman">Kelola Jenis Pelanggaran</h3>

            <!-- Pesan berhasil -->
            <?php if (isset($_SESSION['pesan_sukses'])) { ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars(
                        $_SESSION['pesan_sukses'],
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>
                </div>
                <?php unset($_SESSION['pesan_sukses']); ?>
            <?php } ?>

            <!-- Pesan gagal -->
            <?php if (isset($_SESSION['pesan_error'])) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars(
                        $_SESSION['pesan_error'],
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>
                </div>
                <?php unset($_SESSION['pesan_error']); ?>
            <?php } ?>

            <div class="card">

                <!-- HEADER CARD -->
                <div class="card-header bg-white d-flex
                            justify-content-between align-items-center">

                    <h5 class="mb-0">Data Jenis Pelanggaran</h5>

                    <a href="tambah_jenis_pelanggaran.php"
                       class="btn btn-primary btn-sm">
                        + Tambah Jenis Pelanggaran
                    </a>

                </div>

                <!-- ISI CARD -->
                <div class="card-body">

                    <div class="mb-3">
                        <a href="dashboard.php"
                           class="btn btn-secondary btn-sm">
                            Kembali ke Dashboard
                        </a>
                    </div>

                    <div class="table-responsive">

                        <table id="tabelPelanggaran"
                               class="table table-striped table-bordered table-hover"
                               style="width:100%">

                            <thead class="thead-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>ID</th>
                                    <th>Kategori</th>
                                    <th>Kode</th>
                                    <th>Nama Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Deskripsi</th>
                                    <th>Status Aktif</th>
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
                                    <td><?= $no++; ?></td>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) $row['id'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) ($row['nama_kategori'] ?? '-'),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) ($row['kode'] ?? ''),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) ($row['nama'] ?? ''),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= (int) $row['poin']; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) ($row['deskripsi'] ?? '-'),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?php if ((int) $row['status_aktif'] === 1) { ?>

                                            <span class="badge badge-success">
                                                Aktif
                                            </span>

                                        <?php } else { ?>

                                            <span class="badge badge-danger">
                                                Tidak Aktif
                                            </span>

                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) ($row['created_at'] ?? '-'),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) ($row['updated_at'] ?? '-'),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <td>
                                        <a
                                            href="edit_jenis_pelanggaran.php?id=<?= urlencode((string) $row['id']); ?>"
                                            class="btn btn-warning btn-sm btn-aksi">
                                            Edit
                                        </a>

                                        <a
                                            href="hapus_jenis_pelanggaran.php?id=<?= urlencode((string) $row['id']); ?>"
                                            class="btn btn-danger btn-sm btn-aksi"
                                            onclick="return confirm('Yakin ingin menghapus jenis pelanggaran ini?');">
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

<!-- Pengaturan tabel -->
<script>
$(document).ready(function () {

    $('#tabelPelanggaran').DataTable({

        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data tidak ditemukan",
            emptyTable: "Belum ada jenis pelanggaran",

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

        autoWidth: false,

        columnDefs: [
            {
                targets: [0, 10],
                orderable: false,
                searchable: false
            }
        ],

        order: [[4, 'asc']]

    });

});
</script>

</body>
</html>