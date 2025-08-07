<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/pengiriman.css">
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
  <header>
    <a href="../index.php" class="logo">NEEKE</a>
    <div class="search">
      <input type="text" placeholder="Search">
      <button>SEARCH</button>
    </div>
    <div class="icons">
      <a href="../pengiriman/pengiriman.php"><i data-feather="truck"></i></a>
      <a href="../keranjang/keranjang.php"><i data-feather="shopping-cart"></i></a>
      <div class="profile" onclick="toggleDropdown()">
        <?php if (isset($_SESSION['username'])): ?>
        <i data-feather="user"></i> <?php echo $_SESSION['username']; ?>
        <i data-feather="chevron-down"></i>
        <div class="dropdown" id="dropdownMenu">
          <?php if ($_SESSION['role'] === 'pembeli'): ?>
          <a href="../biodata/biodata.php"><i data-feather="id-card"></i> BIODATA</a>
          <?php elseif ($_SESSION['role'] === 'karyawan'): ?>
          <a href="../karyawan/dashboard.php"><i data-feather="tool"></i> Halaman Karyawan</a>
          <?php endif; ?>
          <a href="../php/login/logout.php"><i data-feather="log-out"></i> LOG OUT</a>
        </div>
        <?php else: ?>
        <a href="../login/login.php">
          <h3><i data-feather="user"></i> Login</h3>
        </a>
        <?php endif; ?>
      </div>
    </div>
  </header>

 

  <main class="pengiriman-container">
    <h2>Status Pengiriman</h2>
    <div class="pengiriman-grid">
      <?php while ($row = mysqli_fetch_assoc($query)) : ?>
      <div class="pengiriman-card">
        <img src="../img/produk/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_produk']; ?>">
        <div class="pengiriman-info">
          <h3><?php echo $row['nama_produk']; ?></h3>
          <p><strong>Status:</strong> <?php echo $row['status_pesanan']; ?></p>
          <p><strong>Jumlah:</strong> <?php echo $row['jumlah']; ?> pcs</p>
          <p><strong>Total:</strong> Rp<?php echo number_format($row['total_harga'], 0, ',', '.'); ?></p>
          <p><strong>Estimasi:</strong>
            <?php echo $row['estimasi_tiba'] ? date('d M Y', strtotime($row['estimasi_tiba'])) : 'Sedang Diproses'; ?>
          </p>

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
  </script>
</body>

</html>