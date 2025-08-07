<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>barang masuk - gudang - NEEKE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard.css">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        
        .body {
            /* background-color: #2d2d2d; */
            display: flex;
            justify-content: center;
            /* align-items: center; */
            /* height: 100vh; */
            width: 100px;
        }

        .quantity-container {
            display: flex;
            /* align-items: center; */
        }

        .quantity-container button {
            background: none;
            border: none;
            color: rgb(red, green, blue);
            font-size: 20px;
            /* width: 30px; */
            height: 30px;
            cursor: pointer;
        }

        .quantity-container input {
            width: 50px;
            text-align: center;
            background-color: #333;
            border: 1px solid #666;
            color: white;
            font-size: 18px;
            border-radius: 4px;
            margin: 0 5px;
        }

        .quantity-container button:focus,
        .quantity-container input:focus {
            outline: none;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
</head>

<body>

    <?php session_start(); ?>
   <?php include 'header.php'; ?>


    <div class="container-fluid">
        <div class="row">
              <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="dashboard.php">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="stok.php">
                <span data-feather="plus"></span>
                tamabah stok
              </a>
            </li>
          </ul>
        </div>
      </nav>


            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div class="col-lg-9">

                        <!-- <h1 class="h2">jumlah stok<?php echo $_SESSION['username']; ?></h1> -->
                        <div class="table-responsive">

                            <h2>Tambah Data Stok Gudang</h2>
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
                            <form method="POST" action="../php/gudang/create.php">
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Input</label>
                                    <input type="date" name="tanggal" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="jumlah" class="form-control" value="1" min="1" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jenis Barang</label>
                                    <input type="text" name="jenis_barang" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Barang Masuk</label>
                                    <input type="number" name="barang_masuk" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Barang Masuk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.querySelector('.minus-btn').addEventListener('click', function () {
            const input = document.querySelector('.quantity-input');
            input.stepDown();
        });

        document.querySelector('.plus-btn').addEventListener('click', function () {
            const input = document.querySelector('.quantity-input');
            input.stepUp();
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>
    <!-- <script src="../js/bootstrap.bundle.min.js"></script> -->
    <script src="../js/dashboard.js"></script>
</body>

</html>