<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>barang keluar - gudang - NEEKE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard.css">

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


                            <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong></strong> <?php echo htmlspecialchars($_GET['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php endif; ?>
                            <?php
                                include '../php/db.php';

                                if (!isset($_GET['id'])) {
                                    die("ID tidak ditemukan");
                                }

                                $id = (int)$_GET['id'];

                                $query = mysqli_query($conn, "SELECT * FROM stok_gudang WHERE ID_gudang = $id");
                                $data = mysqli_fetch_assoc($query);

                                if (!$data) {
                                    die("Data tidak ditemukan");
                                }
                                ?>

                            <h3>Edit Barang Keluar</h3>

                            <form method="POST" action="../php/gudang/edit.php">
                                <input type="hidden" name="id" value="<?= $data['ID_gudang'] ?>">

                                <div class="mb-3">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" value="<?= $data['keterangan'] ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label>Jenis Barang</label>
                                    <input type="text" class="form-control" value="<?= $data['jenis_barang'] ?>"
                                        readonly>
                                </div>


                                <div class="mb-3">
                                    <label>Barang Keluar</label>
                                    <input type="numbar" name="barang_keluar" class="form-control"
                                        value="<?= $data['barang_keluar'] ?>" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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