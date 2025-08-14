<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="css/styles.css">
  <title>Home - NEEKE</title>
</head>

<body>
  <?php
      session_start();
      ?>
  <?php
        include 'php/db.php'; // koneksi database

        $query = "SELECT * FROM produk";
        $result = mysqli_query($conn, $query);
        ?>

  <header>
    <div class="logo">NEEKE</div>

    <div class="search">
      <input type="text" placeholder="Search">
      <button>SEARCH</button>
    </div>

    <div class="icons">
      <a href="pengiriman/pengiriman.php">

        <i data-feather="truck"></i>
      </a>
      <a href="keranjang/keranjang.php">
        <i data-feather="shopping-cart"></i>
      </a>

      <div class="profile" onclick="toggleDropdown()">
        <?php if (isset($_SESSION['username'])): ?>
        <i data-feather="user"></i> <?php echo $_SESSION['username']; ?>
        <i data-feather="chevron-down"></i>

        <div class="dropdown" id="dropdownMenu">
          <?php if ($_SESSION['role'] === 'pembeli'): ?>
          <a href="biodata/biodata.php"><i data-feather="id-card"></i> BIODATA</a>
          <?php elseif ($_SESSION['role'] === 'karyawan'): ?>
          <a href="karyawan/home.php"><i data-feather="tool"></i> Halaman Karyawan</a>
          <?php endif; ?>

          <a href="php/login/logout.php"><i data-feather="log-out"></i> LOG OUT</a>
        </div>

        <?php else: ?>
        <a href="login/login.php">
          <h3><i data-feather="user"></i> Login</h3>
        </a>
        <?php endif; ?>
      </div>
    </div>
  </header>


  <section class="cta">   
  <div class="cta-text">
    <h6>SUMMER ON SALE</h6>
    <h4>20% OFF <br> NEW ARRIVAL</h4>
    <a href="#" class="btn">Shop Now</a>
  </div>
</section>

    <?php
    include 'php/db.php';

    $kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : null;

    if ($kategori) {
        $result = mysqli_query($conn, "SELECT * FROM produk WHERE kategori = '$kategori'");
    } else {
        $result = mysqli_query($conn, "SELECT * FROM produk");
    }
    ?>

 <div class="category">
  <form method="GET" action="">
    <select name="kategori" onchange="this.form.submit()">
      <option value="">Semua Kategori</option>
      <?php
      // Ambil kategori unik dari produk
      $kategoriResult = mysqli_query($conn, "SELECT DISTINCT kategori FROM produk");
      while ($kat = mysqli_fetch_assoc($kategoriResult)) :
      ?>
        <option value="<?= htmlspecialchars($kat['kategori']); ?>" 
          <?= (isset($_GET['kategori']) && $_GET['kategori'] == $kat['kategori']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($kat['kategori']); ?>
        </option>
      <?php endwhile; ?>
    </select>
  </form>
</div>



<div class="new-content">
  <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <div class="box">
      <div class="sale">Sale</div>
      <a href="view/detail_produk.php?id=<?= $row['ID_produk']; ?>">
        <img src="img/produk/<?= htmlspecialchars($row['gambar']); ?>" alt="<?= htmlspecialchars($row['nama_produk']); ?>">
        <h5><?= htmlspecialchars($row['nama_produk']); ?></h5>
        <h6>RP. <?= number_format($row['harga'], 0, ',', '.'); ?></h6>
      </a>
    </div>
  <?php endwhile; ?>
</div>






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