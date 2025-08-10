<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Keranjang - NEEKE</title>
  <link href="https://unpkg.com/feather-icons" rel="stylesheet">
  <link rel="stylesheet" href="../css/keranjang.css">
  <link rel="stylesheet" href="../css/styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php
    session_start();
    include '../php/db.php';

    // Cek apakah user sudah login
    if (!isset($_SESSION['ID_pembeli'])) {
        echo "Silakan isi biodata dan logout dan login lagi.";
        exit;
    }


    $id_pembeli = $_SESSION['ID_pembeli'];
    // Ambil semua pemesanan milik pembeli ini
    $sql = "SELECT pemesanan.*, produk.nama_produk, produk.gambar, produk.harga
            FROM pemesanan
            JOIN produk ON pemesanan.ID_produk = produk.ID_produk
            WHERE pemesanan.ID_pembeli = ? AND pemesanan.status_pesanan = 'Belum Dibayar'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_pembeli); // "i" = integer
    $stmt->execute();
    $result = $stmt->get_result();

    ?>


  <header>
    <div class="logo">
      <a href="../index.php">
        NEEKE
      </a>
    </div>

    <div class="search">
      <input type="text" placeholder="Search">
      <button>SEARCH</button>
    </div>

    <div class="icons">
      <a href="../pengiriman/pengiriman.php">
        <i data-feather="truck"></i>
      </a>
    <a href="../keranjang/keranjang.php">

      <i data-feather="shopping-cart"></i>
    </a>

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




  <main class="cart-container">
  <h2 class="cart-title">Keranjang Belanja</h2>

  <?php
  $grand_total = 0;
  while ($row = mysqli_fetch_assoc($result)) :
      $subtotal = $row['harga'] * $row['jumlah'];
      $grand_total += $subtotal;
  ?>
  <div class="cart-item">
    <div class="item-img">
      <img src="../img/produk/<?= $row['gambar'] ?>" alt="<?= $row['nama_produk'] ?>">
    </div>
    <div class="item-details">
      <h4><?= $row['nama_produk'] ?></h4>
      <p>Harga Satuan: Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>

      <form action="../php/keranjang/update_jumlah.php" method="POST" class="quantity-form">
        <input type="hidden" name="id_pesanan" value="<?= $row['ID_pesanan'] ?>">
        <button type="submit" name="kurang">−</button>
        <input type="text" name="jumlah" value="<?= $row['jumlah'] ?>" readonly>
        <button type="submit" name="tambah">+</button>
      </form>

      <form action="../php/keranjang/delete.php" method="POST">
        <input type="hidden" name="id_pemesanan" value="<?= $row['ID_pesanan'] ?>">
        <button type="submit" class="hapus-btn">Hapus</button>
      </form>
    </div>
    <div class="item-subtotal">
      Rp <?= number_format($subtotal, 0, ',', '.') ?>
    </div>
  </div>
  <?php endwhile; ?>

  <div class="cart-total">
    <strong>Grand Total:</strong> Rp <?= number_format($grand_total, 0, ',', '.') ?>
  </div>

<div class="checkout-section">
  <a href="../pembayaran/pembayaran.php">
    <button type="submit" class="checkout-btn">Checkout</button>
  </a>
</div>
</main>

  <script>
    feather.replace();
  </script>
  <script>
    feather.replace();
    const userLoggedIn = true;

    if (!userLoggedIn) {
      document.querySelector(".profile").style.display = "none";
    }

    function toggleDropdown() {
      const dropdown = document.getElementById("dropdownMenu");
      dropdown.style.display = dropdown.style.display === "flex" ? "none" : "flex";
    }
  </script>
</body>

</html>