<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="../css/biodata.css"> -->
  <link rel="stylesheet" href="../css/biodataEdit.css">
  <title>NEEKE - Biodata</title>
  <script src="https://unpkg.com/feather-icons"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  <!-- <link rel="stylesheet" href="../css/styles.css"> -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>

  <?php session_start();
?>
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
<?php
// Contoh ambil data user dari database

$id_user = $_SESSION['ID_user'];

include '../php/db.php';
$id_pembeli = $_SESSION['ID_pembeli'] ?? null;

// Default value
$nama = '';
$alamat = '';
$nomor_hp = '';
$kode_pos = '';
$foto = '';

// Cek apakah sudah ada data biodata di database
if ($id_pembeli) {
    $query = mysqli_query($conn, "SELECT * FROM pembeli WHERE ID_pembeli = '$id_pembeli' LIMIT 1");
    if ($row = mysqli_fetch_assoc($query)) {
        $nama = $row['nama'];
        $alamat = $row['alamat'];
        $nomor_hp = $row['nomor_hp'];
        $kode_pos = $row['kode_pos'];
        $foto = $row['foto']; // path foto kalau ada
    }
}
?>

  <div class="container my-5">
  <form method="POST" action="../php/pembeli/biodata.php" enctype="multipart/form-data">
  <div class="row justify-content-center g-4">

 
   <!-- FOTO -->
<div class="col-12 col-md-4">
  <div class="card shadow-sm p-3">
    <div class="d-flex justify-content-center align-items-center border mb-3" style="width: 100%; height: 250px; overflow: hidden;">
      <?php if ($foto): ?>
        <img id="preview-image" src="../uploads/<?= htmlspecialchars($foto) ?>" alt="Foto" style="max-width: 100%; max-height: 100%;" />
      <?php else: ?>
        <span id="preview-text" class="text-muted">Foto belum ada</span>
        <img id="preview-image" src="" alt="Preview Foto" style="display:none; max-width: 100%; max-height: 100%;" />
      <?php endif; ?>
    </div>
    <input type="file" class="form-control" name="foto" id="foto" onchange="previewFoto()" <?= $foto ? '' : 'required' ?>>
  </div>
</div>


    <!-- FORM -->
    <div class="col-12 col-md-6">
      <div class="card shadow-sm p-4">
        <h4 class="mb-4 text-center">Isi Biodata Diri</h4>

        <div class="mb-3">
          <label for="nama" class="form-label">Nama</label>
         <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?= htmlspecialchars($nama ?? '') ?>"
 required>
        </div>

        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
         <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat"  value="<?= htmlspecialchars($alamat ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label for="hp" class="form-label">No HP</label>
          <input type="text" class="form-control" id="hp" name="nomor_hp" placeholder="Nomor HP" value="<?= htmlspecialchars($nomor_hp ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label for="kodepos" class="form-label">Kode Pos</label>
          <input type="text" class="form-control" name="kode_pos" id="kodepos" placeholder="Kode Pos" value="<?= htmlspecialchars($kode_pos ?? '') ?>" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-dark">Submit</button>
        </div>
      </div>
    </div>

  </div>
</form>

</div>

<script>
function previewFoto() {
  const file = document.getElementById('foto').files[0];
  const previewImage = document.getElementById('preview-image');
  const previewText = document.getElementById('preview-text');

  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      previewImage.src = e.target.result;
      previewImage.style.display = 'block';
      previewText.style.display = 'none';
    };
    reader.readAsDataURL(file);
  }
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



  <script>
    function previewFoto() {
      const file = document.getElementById("foto").files[0];
      const previewImg = document.getElementById("preview-image");
      const previewText = document.getElementById("preview-text");

      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImg.src = e.target.result;
          previewImg.style.display = "block";
          previewText.style.display = "none";
        };
        reader.readAsDataURL(file);
      } else {
        previewImg.src = "";
        previewImg.style.display = "none";
        previewText.style.display = "block";
      }
    }
  </script>

  <script>
    function previewFoto() {
      const file = document.getElementById("foto").files[0];
      const previewImg = document.getElementById("preview-image");
      const previewText = document.getElementById("preview-text");

      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImg.src = e.target.result;
          previewImg.style.display = "block";
          previewText.style.display = "none";
        };
        reader.readAsDataURL(file);
      } else {
        previewImg.src = "";
        previewImg.style.display = "none";
        previewText.style.display = "block";
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