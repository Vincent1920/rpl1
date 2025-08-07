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
                            <a class="nav-link active" aria-current="page" href="home.php">
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
                            <a class="nav-link" href="pembayaran.php">
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
                            <a class="nav-link" href="pemesanan.php">
                                <span data-feather="shopping-cart"></span>
                                Pemesanan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="container">

                    <!-- Form Filter -->
                    <h4 class="mb-3">Filter Data</h4>
                    <form class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Pesanan</label>
                            <input type="text" class="form-control" placeholder="Cari ID Pesanan">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pembayaran</label>
                            <input type="text" class="form-control" placeholder="Cari metode pembayaran">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stok Gudang</label>
                            <input type="text" class="form-control border border-2 border-primary"
                                placeholder="Cari jenis barang">
                        </div>
                    </form>

                    <!-- Tabel Pengiriman -->
                    <h4 class="mb-3">Data Pengiriman</h4>

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

                        $sql = "SELECT * FROM Pemesanan";
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


                    <!-- Tabel Pembayaran -->
                    <h4 class="mb-3 mt-5">Data Pembayaran</h4>
                    <?php
                            include '../php/db.php'; // sesuaikan dengan lokasi koneksi

                            // Ambil nilai filter
                            $tanggal = $_GET['tanggal'] ?? '';
                            $metode = $_GET['metode'] ?? '';
                            $jumlah = $_GET['jumlah'] ?? '';

                            // Query dasar
                            $sql = "SELECT * FROM pembayaran WHERE 1";

                            // Tambahkan filter jika ada input
                            if (!empty($tanggal)) {
                                $sql .= " AND tanggal_pembayaran = '$tanggal'";
                            }
                            if (!empty($metode)) {
                                $sql .= " AND metode_pembayaran = '$metode'";
                            }
                            if (!empty($jumlah)) {
                                $sql .= " AND jumlah_bayar >= $jumlah";
                            }

                            // Jalankan query
                            $result = mysqli_query($conn, $sql);
                            ?>

                    <!-- Tampilkan tabel -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>ID Pesanan</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Metode Pembayaran</th>
                                <th>Jumlah Bayar</th>
                                <th>Bukti Transfer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= $row['ID_pembayaran'] ?></td>
                                <td><?= $row['ID_pesanan'] ?></td>
                                <td><?= htmlspecialchars($row['tanggal_pembayaran']) ?></td>
                                <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
                                <td><?= number_format($row['jumlah_bayar'], 2) ?></td>
                                <td>
                                    <?php if (!empty($row['bukti_transfer'])): ?>
                                    <a href="../img/bukti_transfer/<?= $row['bukti_transfer'] ?>" target="_blank">Lihat
                                        Bukti</a>
                                    <?php else: ?>
                                    Tidak ada
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <!-- Tabel Stok Gudang -->
                    <h4 class="mb-3 mt-5">Data Stok Gudang</h4>
                    <?php
                    include '../php/db.php'; // ganti dengan koneksi kamu

                    // Ambil data filter dari form
                    $tanggal = $_GET['tanggal'] ?? '';
                    $jenis_barang = $_GET['jenis_barang'] ?? '';
                    $keterangan = $_GET['keterangan'] ?? '';

                    // Buat query dasar
                    $sql = "SELECT * FROM stok_gudang WHERE 1";

                    // Tambahkan filter jika ada
                    if (!empty($tanggal)) {
                        $sql .= " AND tanggal = '$tanggal'";
                    }
                    if (!empty($jenis_barang)) {
                        $sql .= " AND jenis_barang LIKE '%$jenis_barang%'";
                    }
                    if (!empty($keterangan)) {
                        $sql .= " AND keterangan LIKE '%$keterangan%'";
                    }

                    $result = mysqli_query($conn, $sql);
                    ?>

                <!-- Tabel Stok Gudang -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Barang</th>
                            <th>Keterangan</th>
                            <th>Barang Masuk</th>
                            <th>Barang Keluar</th>
                            <th>Jumlah Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td><?= htmlspecialchars($row['jenis_barang']) ?></td>
                            <td><?= htmlspecialchars($row['keterangan']) ?></td>
                            <td><?= $row['barang_masuk'] ?></td>
                            <td><?= $row['barang_keluar'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                </div>
        </div>
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