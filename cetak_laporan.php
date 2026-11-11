
<?php
// cetak_poin.php

include "config/koneksi.php";

// ====================================
// AMBIL DATA PELANGGARAN SISWA
// ====================================

$data = mysqli_query(
    $koneksi,
    "SELECT
        s.nis,
        s.nama,
        p.nama AS pelanggaran,
        p.poin
    FROM t_pelanggaran_siswa ps
    JOIN t_siswa s
        ON ps.siswa_id = s.id
    JOIN t_pelanggaran p
        ON ps.pelanggaran_id = p.id
    ORDER BY ps.id DESC"
);

if (!$data) {
    die("Gagal mengambil data: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cetak Poin Pelanggaran Siswa</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            text-align: center;
            background-color: #eee;
        }

        td:first-child {
            text-align: center;
            width: 50px;
        }

        @media print {
            body {
                margin: 15px;
            }
        }

    </style>

</head>

<body>

    <h2>LAPORAN POIN PELANGGARAN SISWA</h2>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
            </tr>

        </thead>

        <tbody>

            <?php
            $no = 1;

            if (mysqli_num_rows($data) > 0) {

                while ($row = mysqli_fetch_assoc($data)) {
            ?>

                    <tr>

                        <td><?php echo $no++; ?></td>

                        <td>
                            <?php echo htmlspecialchars($row['nis']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['nama']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['pelanggaran']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['poin']); ?>
                        </td>

                    </tr>

                <?php
                }

            } else {
                ?>

                <tr>
                    <td colspan="5" style="text-align:center;">
                        Belum ada data pelanggaran siswa.
                    </td>
                </tr>

            <?php } ?>

        </tbody>

    </table>

    <script>
        window.print();
    </script>

</body>

</html>
