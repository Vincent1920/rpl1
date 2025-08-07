<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/biodata.css">
  <title>NEEKE - Biodata</title>
  <!-- Tambahkan di <head> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Tambahkan sebelum </body> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
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

if (!isset($_SESSION['ID_user'])) {
    header("Location: ../login/login.php?error=Silakan login dulu");
    exit;
}
$id_user = $_SESSION['ID_user'];

$sql = "SELECT * FROM pembeli WHERE ID_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$pembeli = $result->fetch_assoc();
?>

   <header>
    <div class="logo">
      <a  style="text-decoration: none; " href="../index.php">
        <p style="clear:black;" class="logo_biodata">

          NEEKE
        </p>
      </a>
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
  <div class="biodata-container mt-120">
  <div class="photo-box">
    <?php if (!empty($pembeli['foto'])): ?>
      <img src="../img/biodata/<?= htmlspecialchars($pembeli['foto']); ?>" alt="Foto Biodata"
        style="width: 100%; border-radius: 5px; height: 100%; object-fit: cover;">
    <?php else: ?>
      <div style="text-align: center; width: 100%;">
        <p>Foto belum ada</p>
        <!-- <form action="uploadFoto.php" method="POST" enctype="multipart/form-data">
          <input type="file" name="foto" accept="image/*" required style="margin-top: 10px;">
          <button type="submit" class="edit-btn" style="margin-top: 10px;">Upload Foto</button>
        </form> -->
      </div>
    <?php endif; ?>
  </div>

  <div class="data-box">
    <h2>Isi Biodata Diri</h2>
    <p>Nama: <?= isset($pembeli['nama']) ? htmlspecialchars($pembeli['nama']) : 'Belum diisi'; ?></p>
    <p>Alamat: <?= isset($pembeli['alamat']) ? htmlspecialchars($pembeli['alamat']) : 'Belum diisi'; ?></p>
    <p>No HP: <?= isset($pembeli['nomor_hp']) ? htmlspecialchars($pembeli['nomor_hp']) : 'Belum diisi'; ?></p>
    <p>Kode Pos: <?= isset($pembeli['kode_pos']) ? htmlspecialchars($pembeli['kode_pos']) : 'Belum diisi'; ?></p>

    <a href="../biodata/biodataEdit.php">
      <button class="edit-btn">Edit</button>
    </a>
  </div>
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