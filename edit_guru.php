
<?php
// edit_guru.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = $_GET['id'];

$sql = "SELECT * FROM t_guru WHERE id = '$id'";
$hasil = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($hasil);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <h3 class="mb-4">Edit Guru</h3>

            <div class="card">

                <div class="card-header bg-white">
                    <h5 class="mb-0">Form Edit Data Guru</h5>
                </div>

                <div class="card-body">

                    <a href="kelola_guru.php"
                       class="btn btn-secondary btn-sm mb-3">
                        Kembali ke Kelola Guru
                    </a>

                    <form action="proses_edit_guru.php" method="POST">

                        <input type="hidden" name="id"
                               value="<?php echo $data['id']; ?>">

                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" name="nip"
                                   class="form-control"
                                   value="<?php echo $data['nip']; ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input type="text" name="nama"
                                   class="form-control"
                                   value="<?php echo $data['nama']; ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email"
                                   class="form-control"
                                   value="<?php echo $data['email']; ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Status Aktif</label>
                            <select name="status_aktif"
                                    class="form-control" required>

                                <option value="1"
                                    <?php if ($data['status_aktif'] == 1) echo 'selected'; ?>>
                                    Aktif
                                </option>

                                <option value="0"
                                    <?php if ($data['status_aktif'] == 0) echo 'selected'; ?>>
                                    Tidak Aktif
                                </option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label>User ID</label>
                            <input type="number" name="user_id"
                                   class="form-control"
                                   value="<?php echo $data['user_id']; ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>

                        <a href="kelola_guru.php"
                           class="btn btn-secondary">
                            Batal
                        </a>

                    </form>

                </div>
            </div>

        </main>

    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
