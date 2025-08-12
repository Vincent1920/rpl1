<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/biodata.css">
  <title>NEEKE - Biodata</title>

  <!-- Tambahkan di <head> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Tambahkan sebelum </body> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Styling untuk dropdown custom */
        .dropdown-wrapper {
            position: relative;
        }
        .dropdown-toggle-btn {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }
        .dropdown-menu-custom {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            min-width: 180px;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            padding: 10px 0;
            z-index: 1000;
        }
        .dropdown-menu-custom a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            color: #333;
            text-decoration: none;
        }
        .dropdown-menu-custom a:hover {
            background: #f8f9fa;
        }
        .dropdown-menu-custom a.text-danger:hover {
            background: #f8d7da;
        }
    </style>
</head>

<body>

  <?php
session_start();
require '../php/db.php'; // pastikan koneksi ada di sini

if (!isset($_SESSION['ID_user'])) {
    die("Anda belum login.");
}

$id_user = $_SESSION['ID_user'];

// Query ambil biodata pembeli
$sql = "SELECT foto, nama, alamat, nomor_hp, kode_pos 
        FROM pembeli 
        WHERE ID_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$pembeli = $result->fetch_assoc();
$stmt->close();
?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
      <!-- Logo -->
      <a class="navbar-brand fw-bold" href="../index.php">NEEKE</a>

      <!-- Toggle button mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <!-- Icon Pengiriman -->
          <li class="nav-item me-3">
            <a class="nav-link" href="../pengiriman/pengiriman.php">
              <i class="bi bi-truck"></i>
            </a>
          </li>
          <!-- Icon Keranjang -->
          <li class="nav-item me-3">
            <a class="nav-link" href="../keranjang/keranjang.php">
              <i class="bi bi-cart3"></i>
            </a>
          </li>

          <!-- Dropdown Profil -->
          <li class="nav-item dropdown-wrapper">
            <?php if (!empty($_SESSION['username'])): ?>
            <button class="dropdown-toggle-btn" id="dropdownToggle">
              <i class="bi bi-person"></i> <?= htmlspecialchars($_SESSION['username']); ?>
              <i class="bi bi-chevron-down"></i>
            </button>
            <div class="dropdown-menu-custom" id="dropdownMenu">
              <?php if ($_SESSION['role'] === 'pembeli'): ?>
              <a href="../biodata/biodata.php">
                <i class="bi bi-person-badge"></i> Biodata
              </a>
              <?php elseif ($_SESSION['role'] === 'karyawan'): ?>
              <a href="../karyawan/home.php">
                <i class="bi bi-tools"></i> Halaman Karyawan
              </a>
              <?php endif; ?>
              <a href="../php/login/logout.php" class="text-danger">
                <i class="bi bi-box-arrow-right"></i> Log Out
              </a>
            </div>
            <?php else: ?>
            <a href="../login/login.php" class="login-link">
              <i class="bi bi-person"></i> Login
            </a>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>

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



  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4 d-flex align-items-center">

            <!-- Foto -->
            <div class="me-4" style="flex-shrink: 0; width: 150px; height: 150px;">
              <?php if (!empty($pembeli['foto'])): ?>
              <img src="../img/biodata/<?= htmlspecialchars($pembeli['foto']); ?>" alt="Foto Biodata"
                class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
              <?php else: ?>
              <div class="d-flex justify-content-center align-items-center bg-secondary text-white rounded"
                style="width: 100%; height: 100%;">
                Foto belum ada
              </div>
              <?php endif; ?>
            </div>

            <!-- Data Biodata -->
            <div>
              <h4 class="mb-3">Isi Biodata Diri</h4>
              <p><strong>Nama:</strong>
                <?= !empty($pembeli['nama']) ? htmlspecialchars($pembeli['nama']) : 'Belum diisi'; ?></p>
              <p><strong>Alamat:</strong>
                <?= !empty($pembeli['alamat']) ? htmlspecialchars($pembeli['alamat']) : 'Belum diisi'; ?></p>
              <p><strong>No HP:</strong>
                <?= !empty($pembeli['nomor_hp']) ? htmlspecialchars($pembeli['nomor_hp']) : 'Belum diisi'; ?></p>
              <p><strong>Kode Pos:</strong>
                <?= !empty($pembeli['kode_pos']) ? htmlspecialchars($pembeli['kode_pos']) : 'Belum diisi'; ?></p>

              <a href="../biodata/biodataEdit.php" class="btn btn-primary mt-2">
                <i class="bi bi-pencil-square"></i> Edit
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>




  <!-- Bootstrap Icons & JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Dropdown toggle script
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("dropdownToggle");
        const menu = document.getElementById("dropdownMenu");

        if (toggleBtn) {
            toggleBtn.addEventListener("click", function () {
                menu.style.display = (menu.style.display === "block") ? "none" : "block";
            });
            document.addEventListener("click", function (e) {
                if (!toggleBtn.contains(e.target) && !menu.contains(e.target)) {
                    menu.style.display = "none";
                }
            });
        }
    });
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