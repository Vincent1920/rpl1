<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>home - karyawan - NEEKE</title>
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
              <a class="nav-link " href="../karyawan/status_pesanan.php">
                <span data-feather="plus"></span>
                Status Pesanan
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../karyawan/stok_gudang.php">
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
        <h2 class=" text-sm-center">Home</h2>
        <h2>Daftar Produk</h2>

        <table class="table table-bordered table-striped">
          <thead class="">
            <tr>
              <!-- <th>ID</th> -->
              <th>Nama Produk</th>
              <th>Gambar</th>
              <th>Stok</th>
              <th>Ukuran</th>
              <th>Warna</th>
              <th>Harga</th>
              <th>Kategori</th>
              <!-- <th>Aksi</th>
                <th>Aksi</th> -->

            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
              <!-- <td><?= $row['ID_produk'] ?></td> -->
              <td><?= $row['nama_produk'] ?></td>
              <td>
                <?php if ($row['gambar']) : ?>
                <img src="../img/produk/<?=$row['gambar'] ?>" alt="Gambar" width="60">
                <?php else : ?>
                (Kosong)
                <?php endif; ?>
              </td>
              <td><?= $row['stok'] ?></td>
              <td><?= $row['ukuran'] ?></td>
              <td><?= $row['warna'] ?></td>
              <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
              <td><?= $row['kategori'] ?></td>
              <td>

                <a href="../karyawan/edit_produk.php?id=<?= $row['ID_produk'] ?>" class="btn btn-sm btn-warning">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-pencil" viewBox="0 0 16 16">
                    <path
                      d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                  </svg>
                </a>
                <a href="../php/karyawan/delete_stok.php?id=<?= $row['ID_produk']  ?>"
                  onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-sm btn-danger">Hapus</a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
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