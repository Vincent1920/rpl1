<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Dashboard - gudang - NEEKE</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Custom styles for this template -->
  <link href="dashboard.css" rel="stylesheet">
</head>

<body>
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
 <?php session_start(); ?>
<?php include 'header.php'; ?>


  <div class="container-fluid">
    <div class="row">
     <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">
                <span data-feather="home"></span>
                home
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
        

        <h2>Section title</h2>
        <div class="table-responsive">
          <table class=" table table-bordered table-striped">
                <thead>
                  <tr>
                    <th scope="col">keterangan</th>
                    <th scope="col">tanggal</th>
                    <th scope="col">jenis barang</th>
                    <th scope="col">jumlah</th>
                    <th scope="col">barang masuk</th>
                    <th scope="col">barang keluar</th>

                  </tr>
                </thead>


                <tbody>
                    <?php
                    include '../php/db.php'; // sesuaikan path jika beda folder
                    $query = "SELECT * FROM stok_gudang ORDER BY ID_gudang DESC";
                    $result = mysqli_query($conn, $query);
                    ?>
                  <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                  <tr>

                    <td><?= $row['keterangan']; ?></td>
                    <td><?= $row['tanggal']; ?></td>
                    <td><?= $row['jenis_barang']; ?></td>
                    <td><?= $row['jumlah']; ?></td>
                    <td><?= $row['barang_masuk']; ?></td>
                    <td><?= $row['barang_keluar']; ?></td>

                    <td></td>
                    
                      
                  </td>

                  </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
        </div>
      </main>
    </div>
  </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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