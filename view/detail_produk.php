<!DOCTYPE html>
<html lang="da">

<head>
    <meta charset="UTF-8">
    <title>Detail Produk - NEEKE</title>
    <link rel="stylesheet" href="../css/detail_produk.css">
    <link rel="stylesheet" href="../css/styles.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>



    <?php
session_start();
include "../php/db.php";

if (!isset($_SESSION['ID_user'])) {
    header("Location: ../auth/login.php");
    exit;
}


$id_user = $_SESSION['ID_user'];

// Cek apakah user sudah punya data di tabel pembeli
$query = mysqli_query($conn, "SELECT * FROM pembeli WHERE ID_user = '$id_user'");
$data = mysqli_fetch_assoc($query);

// Cek apakah data pembeli belum ada atau alamat masih kosong
if (!$data || empty($data['alamat'])) {
    // Redirect ke halaman biodata
   header("Location: ../biodata/biodata.php?error=Lengkapi biodata terlebih dahulu");
    exit();
}

?>

    <?php
        include '../php/db.php';

        $id_produk = $_GET['id'];
        $query = mysqli_query($conn, "SELECT * FROM produk WHERE ID_produk = $id_produk");
        $produk = mysqli_fetch_assoc($query);
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
                    <a href="/rpl1/karyawan/dashboard.php"><i data-feather="tool"></i> Halaman Karyawan</a>
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

    <div class="product-container">
  <div class="product-img">
    <img src="../img/produk/<?= $produk['gambar'] ?>" alt="<?= $produk['nama_produk'] ?>">
  </div>
  <div class="product-info">
    <h2><?= $produk['nama_produk'] ?></h2>
    <p class="desc"><?= $produk['warna'] ?> - <?= $produk['ukuran'] ?></p>
    <p class="price">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>

    <form method="post" action="../php/keranjang/tambah_ke_keranjang.php" class="buy-form">
      <input type="hidden" name="ID_produk" value="<?= $produk['ID_produk']; ?>">
      <input type="hidden" name="nama_produk" value="<?= $produk['nama_produk']; ?>">
      <input type="hidden" name="harga" value="<?= $produk['harga']; ?>">
      <label>Jumlah:</label>
      <input type="number" name="jumlah" min="1" value="1" required>
      <input type="hidden" name="metode_pembayaran" value="COD">
      <button type="submit" name="beli" class="btn-buy">Beli Sekarang</button>
    </form>

    <div class="desc-box">
      <h4>Deskripsi Produk</h4>
        <p><?= $produk['kategori'] ?></p>
        </div>
        </div>
    </div>

    <script>
        function increase() {
            let qty = document.getElementById("qty");
            qty.value = parseInt(qty.value) + 1;
        }

        function decrease() {
            let qty = document.getElementById("qty");
            if (parseInt(qty.value) > 1) {
                qty.value = parseInt(qty.value) - 1;
            }
        }
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