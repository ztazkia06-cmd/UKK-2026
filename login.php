
<?php
// login.php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Sistem Pelanggaran Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
</head>

<body class="bg-light">

    <!-- HEADER -->
    

    <!-- FORM LOGIN -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">Login</h4>
                    </div>

                    <div class="card-body p-4">

                        <h5 class="text-center mb-2">
                            Sistem Pelanggaran Siswa
                        </h5>

                        <p class="text-center text-secondary mb-4">
                            Silakan login menggunakan akun kamu.
                        </p>

                        <?php
                        if (isset($_SESSION['pesan_error'])) {
                            echo '<div class="alert alert-danger" role="alert">';
                            echo htmlspecialchars(
                                $_SESSION['pesan_error'],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            echo '</div>';

                            unset($_SESSION['pesan_error']);
                        }
                        ?>

                        <form action="proses_login.php" method="POST">

                            <div class="mb-3">
                                <label for="exampleInputEmail1"
                                       class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    placeholder="Masukkan email"
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label for="exampleInputPassword1"
                                       class="form-label">
                                    Password
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    id="exampleInputPassword1"
                                    placeholder="Masukkan password"
                                    required
                                >
                            </div>

                            <button type="submit"
                                    class="btn btn-primary w-100">
                                Login
                            </button>

                        </form>

                    </div>
                </div>

                <p class="text-center text-secondary mt-3 small">
                    Sistem Informasi Pelanggaran Siswa
                </p>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

</body>
</html>
