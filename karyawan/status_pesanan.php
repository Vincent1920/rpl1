<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>status pesanan- karyawan - NEEKE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
</head>

<body>
    <?php
include '../php/db.php'; 

?>


    <?php session_start(); ?>
    <?php include 'header.php'; ?>



    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="home.php">
                                <span data-feather="home"></span>

                                home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../karyawan/status_pesanan.php">
                                <span data-feather="plus"></span>
                                Status Pesanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " href="../karyawan/stok_gudang.php">
                                <span data-feather="shopping-cart"></span>
                                stok gudang
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>


            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
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

                <h2> status pesanan</h2>
                <div class="table-responsive">
                   <?php
$query = "SELECT 
    pemesanan.ID_pesanan,
    pemesanan.status_pesanan,
    pemesanan.tanggal,
    pemesanan.jumlah,
    pemesanan.estimasi_tiba,
    pembayaran.bukti_transfer,
    pembayaran.jumlah_bayar,
    pembayaran.tanggal_pembayaran,
    pembeli.Nama AS nama_pembeli,
    pembeli.kode_pos,
    pembeli.nomor_HP,
    pembeli.Alamat
FROM pemesanan 
JOIN pembayaran ON pemesanan.ID_pesanan = pembayaran.ID_pesanan
JOIN pembeli ON pemesanan.ID_pembeli = pembeli.ID_pembeli
WHERE pemesanan.status_pesanan IN ('Dibayar', 'Dikemas')
ORDER BY pemesanan.ID_pesanan DESC";

$result = mysqli_query($conn, $query);
?>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Nama Pembeli</th>
                                <th scope="col">Kode Pos</th>
                                <th scope="col">Nomor HP</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Status Pesanan</th>
                                <th scope="col">Estimasi Tiba</th>
                                <th scope="col">Bukti Transfer</th>
                                <th scope="col">Jumlah </th>
                                <th scope="col">Jumlah Bayar</th>
                                <th scope="col">Tanggal pesanan</th>
                                <th scope="col">Tanggal Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= $row['nama_pembeli']; ?></td>
                                <td><?= $row['kode_pos']; ?></td>
                                <td><?= $row['nomor_HP']; ?></td>
                                <td><?= $row['Alamat']; ?></td>
                                <td><?= $row['status_pesanan']; ?></td>
                                
                                <td><?= $row['estimasi_tiba']; ?></td>
                                <td>
                                    <?php if (!empty($row['bukti_transfer'])): ?>
                                    <!-- <img src="../img/bukti_transfer/<?= $row['bukti_transfer']; ?>" width="100"> -->
                                     <a href="../img/bukti_transfer/<?= $row['bukti_transfer'] ?>" target="_blank">Lihat Bukti</a>
                                    <?php else: ?>
                                    Tidak Ada (cod)
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($row['jumlah']); ?></td>
                                <td><?= number_format($row['jumlah_bayar']); ?></td>
                                <td><?= $row['tanggal']; ?></td>
                                <td><?= $row['tanggal_pembayaran']; ?></td>
                                <td>
                                    <a href="../karyawan/ubah_status.php?id=<?= $row['ID_pesanan']; ?>"
                                        class="btn btn-success btn-sm">
                                        Ubah Status
                                    </a>
                                </td>
                            </tr>

                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <h4>Pesanan - Dikirim</h4>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Pembeli</th>
                                <th>Status</th>
                                <th>Estimasi Tiba</th>
                                <th>Bukti Transfer</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              $result = mysqli_query($conn, "
    SELECT p.*, b.nama AS nama_pembeli, bayar.bukti_transfer
    FROM Pemesanan p
    JOIN Pembeli b ON p.ID_pembeli = b.ID_pembeli
    LEFT JOIN Pembayaran bayar ON p.ID_pesanan = bayar.ID_pesanan
    WHERE p.status_pesanan = 'Dikirim'
");

                                while ($row = mysqli_fetch_assoc($result)) :
                                ?>
                            <tr>
                               <td><?= $row['nama_pembeli']; ?></td>
                                <td><?= $row['status_pesanan']; ?></td>
                                <td><?= $row['estimasi_tiba']; ?></td>
                                <td>
                                    <?php if (!empty($row['bukti_transfer'])): ?>
                                    <!-- <img src="../img/bukti_transfer/<?= $row['bukti_transfer']; ?>" width="100"> -->
                                     <a href="../img/bukti_transfer/<?= $row['bukti_transfer'] ?>" target="_blank">Lihat Bukti</a>
                                    <?php else: ?>
                                    Tidak Ada
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="ubah_status.php?id=<?= $row['ID_pesanan']; ?>"
                                        class="btn btn-success btn-sm">
                                        Ubah Status
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <h4>Pesanan - Selesai</h4>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Pembeli</th>
                                <th>Status</th>
                                <th>Estimasi Tiba</th>
                                <th>Bukti Transfer</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             $result = mysqli_query($conn, "
    SELECT p.*, b.nama AS nama_pembeli, bayar.bukti_transfer
    FROM Pemesanan p
    JOIN Pembeli b ON p.ID_pembeli = b.ID_pembeli
    LEFT JOIN Pembayaran bayar ON p.ID_pesanan = bayar.ID_pesanan
    WHERE p.status_pesanan = 'selesai'
");


                                while ($row = mysqli_fetch_assoc($result)) :
                                ?>
                            <tr>
                                <td><?= $row['nama_pembeli']; ?></td>
                                <td><?= $row['status_pesanan']; ?></td>
                                <td><?= $row['estimasi_tiba']; ?></td>
                                <td>
                                    <?php if (!empty($row['bukti_transfer'])): ?>
                                    <img src="../img/bukti_transfer/<?= $row['bukti_transfer']; ?>" width="100">
                                    <?php else: ?>
                                    Tidak Ada
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="ubah_status.php?id=<?= $row['ID_pesanan']; ?>"
                                        class="btn btn-success btn-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                </div>
        </div>
    </div>


    <!-- <script>
    function myFunction() {
      alert("🔔 Ini adalah notifikasi pop-up dari tombol.");
    }
  </script> -->
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