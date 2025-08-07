<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="../css/biodata.css"> -->
  <link rel="stylesheet" href="../css/biodataEdit.css">
  <title>NEEKE - Biodata</title>
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="../css/styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>

  <?php session_start();
?>

  <header>
    <div class="logo">
      <a href="../index.php">NEEKE</a></div>
    <div class="icons">
      <i data-feather="truck"></i>
      <i data-feather="shopping-cart"></i>

      <div class="profile" onclick="toggleDropdown()">
        <?php if (isset($_SESSION['username'])): ?>
        <i data-feather="user"></i> <?php echo $_SESSION['username']; ?>
        <i data-feather="chevron-down"></i>

        <div class="dropdown" id="dropdownMenu">
          <a href="../biodata/biodata.php"><i data-feather="id-card"></i> BIODATA</a>
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

  <div class="biodata-container">
  <form method="POST" action="../php/pembeli/biodata.php" enctype="multipart/form-data" style="display: flex; flex-wrap: wrap; gap: 40px; justify-content: center;">
    
    <!-- FOTO -->
    <div class="photo-box">
      <div id="preview-container"
        style="width: 200px; height: 200px; border: 1px solid #000; display: flex; justify-content: center; align-items: center;">
        <span id="preview-text">Foto belum ada</span>
        <img id="preview-image" src="" alt="Preview Foto" style="display:none; max-width: 100%; max-height: 100%;" />
      </div>
      <input type="file" name="foto" id="foto" onchange="previewFoto()" required>
    </div>

    <!-- FORM -->
    <div class="form-section">
  <div class="form-box">
    <h2>Isi Biodata Diri</h2>

    <label for="nama">Nama</label>
    <input type="text" name="nama" id="nama" placeholder="Nama" />

    <label for="alamat">Alamat</label>
    <input type="text" name="alamat" id="alamat" placeholder="Alamat" />

    <label for="hp">No HP</label>
    <input type="text" id="hp" name="nomor_hp" placeholder="Nomor HP" />

    <label for="kodepos">Kode Pos</label>
    <input type="text" name="kode_pos" id="kodepos" placeholder="Kode Pos" />

    <button type="submit" class="submit-btn">Submit</button>
  </div>
</div>

    
  </form>
</div>


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