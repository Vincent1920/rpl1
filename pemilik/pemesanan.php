<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Dashboard Template · Bootstrap v5.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard.css">

    <style>
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <?php
include '../php/db.php'; // koneksi database
$result = mysqli_query($conn, "SELECT * FROM produk");
?>
    <?php
$gambar = isset($row['bukti_transfer']) ? htmlspecialchars($row['bukti_transfer']) : 'default.jpg';
?>
    <!-- <img src="img/pengiriman/<?= $gambar ?>" class="img-fluid rounded" style="width: 100px;"> -->

    <?php session_start(); ?>
    <?php include 'header.php'; ?>


    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="home.php">
                                <span data-feather="home"></span>

                                home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="stok_gudang.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-box-seam-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z" />
                                </svg>
                                Stok Gudang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="pembayaran.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-credit-card" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z" />
                                    <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                                </svg>
                                Pembayaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active " href="pemesanan.php">
                                <span data-feather="shopping-cart"></span>
                                Pemesanan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label for="status_pesanan" class="form-label">Status Pesanan</label>
                        <select name="status_pesanan" class="form-select">
                            <option value="">-- Semua --</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Dikirim">Dikirim</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select">
                            <option value="">-- Semua --</option>
                            <option value="Transfer">Transfer</option>
                            <option value="COD">COD</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="tanggal" class="form-label">Tanggal Pemesanan</label>
                        <input type="date" name="tanggal" class="form-control">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>

                <?php
include '../php/db.php';

$where = [];

if (!empty($_GET['status_pesanan'])) {
    $status = mysqli_real_escape_string($conn, $_GET['status_pesanan']);
    $where[] = "status_pesanan = '$status'";
}

if (!empty($_GET['metode_pembayaran'])) {
    $metode = mysqli_real_escape_string($conn, $_GET['metode_pembayaran']);
    $where[] = "metode_pembayaran = '$metode'";
}

if (!empty($_GET['tanggal'])) {
    $tanggal = mysqli_real_escape_string($conn, $_GET['tanggal']);
    $where[] = "tanggal = '$tanggal'";
}

$sql = "SELECT * FROM pemesanan";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY tanggal DESC";

$result = mysqli_query($conn, $sql);
?>

                <table class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Status</th>
                            <th>Metode Pembayaran</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Tanggal</th>
                            <th>Estimasi Tiba</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                            <td><?= htmlspecialchars($row['status_pesanan']) ?></td>
                            <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><?= $row['estimasi_tiba'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>



            </main>
        </div>
    </div>



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