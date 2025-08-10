<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  <!-- SweetAlert2 -->

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Pengiriman - NEEKE</title>
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
  <?php session_start(); 
  include '../php/db.php'; 
    $id_pembeli = $_SESSION['ID_pembeli'];
    $query = mysqli_query($conn, "
  SELECT p.*, pr.nama_produk, pr.gambar, pr.harga,
         (pr.harga * p.jumlah) AS total_harga
  FROM Pemesanan p
  JOIN Produk pr ON p.ID_produk = pr.ID_produk
  WHERE p.ID_pembeli = '$id_pembeli'
    AND p.status_pesanan IN ('Dikemas','Dibayar','Dikirim', 'Selesai')
");
?>
<style>
   .dropdown-wrapper {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle-btn {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px;
            min-width: 160px;
        }

        .dropdown-menu a {
            display: block;
            padding: 8px 10px;
            color: black;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background: #f1f1f1;
        }
</style>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm ">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="../index.php">NEEKE</a>

            <!-- Tombol toggle untuk mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">


                <!-- Icon Menu & Profil -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="../pengiriman/pengiriman.php">
                            <i data-feather="truck"></i>
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="../keranjang/keranjang.php">
                            <i data-feather="shopping-cart"></i>
                        </a>
                    </li>




                    <!-- Dropdown Profil -->

                    <?php
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    ?>

                    <?php if (!empty($_SESSION['username'])): ?>
                    <div class="dropdown-wrapper">
                        <button class="dropdown-toggle-btn" id="dropdownToggle">
                            <i data-feather="user"></i> <?= htmlspecialchars($_SESSION['username']); ?>
                            <i data-feather="chevron-down"></i>
                        </button>

                        <div class="dropdown-menu" id="dropdownMenu">
                            <?php if ($_SESSION['role'] === 'pembeli'): ?>
                            <a href="../biodata/biodata.php">
                                <i data-feather="id-card"></i> Biodata
                            </a>
                            <?php elseif ($_SESSION['role'] === 'karyawan'): ?>
                            <a href="../karyawan/home.php">
                                <i data-feather="tool"></i> Halaman Karyawan
                            </a>
                            <?php endif; ?>

                            <a href="../php/login/logout.php" class="text-danger">
                                <i data-feather="log-out"></i> Log Out
                            </a>
                        </div>
                    </div>

                    <?php else: ?>
                    <a href="../login/login.php" class="login-link">
                        <i data-feather="user"></i> Login
                    </a>
                    <?php endif; ?>


                </ul>
            </div>
        </div>
    </nav>
 

<main class="container my-5">
  <h2 class="text-center mb-4">Status Pengiriman</h2>
  
  <div class="row g-4">
    <?php while ($row = mysqli_fetch_assoc($query)) : ?>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card shadow-sm h-100">
          <img src="../img/produk/<?php echo $row['gambar']; ?>" 
               class="card-img-top" 
               alt="<?php echo htmlspecialchars($row['nama_produk']); ?>"
               style="object-fit: cover; height: 200px;">
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($row['nama_produk']); ?></h5>
            <p class="mb-1"><strong>Status:</strong> <?php echo htmlspecialchars($row['status_pesanan']); ?></p>
            <p class="mb-1"><strong>Jumlah:</strong> <?php echo (int)$row['jumlah']; ?> pcs</p>
            <p class="mb-1"><strong>Total:</strong> Rp<?php echo number_format($row['total_harga'], 0, ',', '.'); ?></p>
            <p class="mb-0"><strong>Estimasi:</strong> 
              <?php echo $row['estimasi_tiba'] 
                ? date('d M Y', strtotime($row['estimasi_tiba'])) 
                : 'Sedang Diproses'; ?>
            </p>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</main>


  <script>
    feather.replace();

    function toggleDropdown() {
      const dropdown = document.getElementById("dropdownMenu");
      dropdown.style.display = dropdown.style.display === "flex" ? "none" : "flex";
    }
      document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById("dropdownToggle");
            const menu = document.getElementById("dropdownMenu");

            if (toggleBtn) {
                toggleBtn.addEventListener("click", function (e) {
                    e.stopPropagation();
                    menu.style.display = (menu.style.display === "block") ? "none" : "block";
                });

                // Klik di luar dropdown untuk menutup
                document.addEventListener("click", function () {
                    menu.style.display = "none";
                });
            }
        });
  </script>
</body>

</html>