<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="../css/keranjang.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/pembayaran.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>pembayaran - NEEKE</title>
</head>

<body>
    <?php
session_start();
include "../php/db.php";

// Ambil ID_Pembeli dari session


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

// $result = mysqli_query($conn, $query);
?>


    <?php
session_start();
include '../php/db.php'; // koneksi ke database

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
// Lanjutkan ke halaman utama jika sudah isi biodata
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
            <i data-feather="shopping-cart"></i>

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



    <div class="pembayaran-container">
        <div class="produk-list">
            <?php
                $grandTotal = 0;
                $totalItem = 0;
                while ($row = mysqli_fetch_assoc($result)) :
                    $subtotal = $row['harga'] * $row['jumlah'];
                    $grandTotal += $subtotal;
                    $totalItem += $row['jumlah'];
                ?>
            <div class="produk-item">
                <img src="../img/produk/<?= $row['gambar'] ?>" alt="<?= $row['nama_produk'] ?>">
                <div class="produk-info">
                    <h4><?= $row['nama_produk'] ?></h4>
                    <p>Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
                </div>
            </div>
            <?php endwhile; ?>

            <div class="produk-total">
                <p><strong>Total Barang:</strong> <?= $totalItem ?></p>
                <p><strong>Harga Total:</strong> Rp <span
                        id="total-harga"><?= number_format( $grandTotal,0,',',',') ?></span></p>

            </div>
        </div>

        <div class="pembayaran-cardR">
            <?php
                    $id_pembeli = $_SESSION['ID_pembeli'];

            $query = mysqli_query($conn, "SELECT ID_pesanan FROM Pemesanan WHERE ID_Pembeli = '$id_pembeli' AND status_pesanan = 'Belum Dibayar'");
            // $query = mysqli_query($conn, "SELECT ID_pesanan FROM Pemesanan WHERE ID_Pembeli = '$id_pembeli' AND status_pesanan = ''");

            $id_pesanan_array = [];
            while ($row = mysqli_fetch_assoc($query)) {
                $id_pesanan_array[] = $row['ID_pesanan'];
            }

            $id_pesanan_str = implode(",", $id_pesanan_array);
            //echo "Debug: ID_Pesanan = " . $id_pesanan_str;
            ?>

            <form action="../php/pembayaran/pembayaran.php" method="post" enctype="multipart/form-data" class="payment-form">
                <input type="hidden" name="id_pesanan" value="<?= $id_pesanan_str ?>">

                <label for="tanggal">Tanggal Pembayaran:</label>
                <input type="date" name="tanggal_pembayaran" id="tanggal" value="<?= date('Y-m-d') ?>">

                <label for="metode">Metode Pembayaran:</label>
                <select name="metode_pembayaran" id="metode">
                    <option value="COD">COD</option>
                    <option value="Transfer">Transfer</option>
                </select>

                <div id="bank-options" style="display: none;">
                    <label for="bank">Pilih Bank:</label>
                    <table border="1">
                        <tr>
                            <td>BCA</td>
                            <td>1012333567</td>

                        </tr>
                        <tr>
                            <td>BNI</td>
                            <td>1012333566</td>
                        </tr>
                        <tr>
                            <td>BRI</td>
                            <td>0123335618</td>
                        </tr>
                    </table>
                    <br>
                    <label for="bukti">Upload Bukti Transfer:</label>
                    <br>
                    <input type="file" name="bukti_transfer" id="bukti" accept="image/*">
                </div>

                <label for="jumlah">Jumlah Bayar:</label>
                <input type="number" name="jumlah_bayar" id="jumlah" required>



                <button type="submit" name="submit" class="btn-checkout">Kirim Pembayaran</button>
            </form>

        </div>
    </div>


    <!-- TERBARUUUUUUUUU-->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const metodeSelect = document.getElementById('metode');
            const bankOptions = document.getElementById('bank-options');
            const buktiTransfer = document.getElementById('bukti');
            const form = document.querySelector('.payment-form');
            const jumlahInput = document.getElementById('jumlah');
            const totalHargaEl = document.getElementById('total-harga');

            function toggleBankAndUpload() {
                if (metodeSelect.value === 'Transfer') {
                    bankOptions.style.display = 'block';
                    buktiTransfer.required = true;
                } else {
                    bankOptions.style.display = 'none';
                    buktiTransfer.required = false;
                }
            }

            toggleBankAndUpload();
            metodeSelect.addEventListener('change', toggleBankAndUpload);

            form.addEventListener('submit', function (e) {
                const metode = metodeSelect.value;
                const bukti = buktiTransfer;
                const jumlahBayar = parseFloat(jumlahInput.value);
                const totalHargaText = totalHargaEl.innerText.replace(/[^\d]/g, '');
                const totalHarga = parseFloat(totalHargaText);

                // Validasi untuk Transfer
                if (metode === "Transfer") {
                    if (bukti.files.length === 0) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Bukti transfer wajib diunggah!',
                            confirmButtonColor: '#8126c0'
                        });
                        return;
                    }
                }

                // Validasi jumlah bayar
                if (jumlahBayar < totalHarga) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Jumlah bayar kurang!',
                        text: `Total yang harus dibayar adalah Rp ${totalHarga.toLocaleString('id-ID')}`,
                        confirmButtonColor: '#8126c0'
                    });
                }
            });
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