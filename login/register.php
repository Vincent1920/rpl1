<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
          <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">register</h2>
                                  <?php
                                        $success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : null;
                                        $error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : null;
                                        ?>

                                        <?php if ($success): ?>
                                        <script>
                                            Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: "<?= $success ?>",
                                            confirmButtonColor: '#3085d6'
                                            });
                                        </script>
                                        <?php elseif ($error): ?>
                                        <script>
                                            Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal!',
                                            text: "<?= $error ?>",
                                            confirmButtonColor: '#d33'
                                            });
                                        </script>
                                        <?php endif; ?>
                                <form action="../php/login/register.php"  method="POST">

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <input type="text" placeholder="username" name="username" id="typeEmailX"
                                            class="form-control form-control-lg" />
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <input type="email"  placeholder="Email" name="email" id="typeEmailX"
                                            class="form-control form-control-lg" />
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <input type="password" placeholder="Password" name="password" id="typePasswordX"
                                            class="form-control form-control-lg" />
                                    </div>
                                    <button data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-outline-light btn-lg px-5" type="submit">register</button>
                                </form>

                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                </div>

                            </div>

                            <div>
                                <p class="mb-0"> <a href="../login/login.php" class="text-white-50 fw-bold">login</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>