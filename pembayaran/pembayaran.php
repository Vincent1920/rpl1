<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
  
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <title>pembayaran - NEEKE</title>
</head>

<body>

    <style>
        .payment-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 20px;
            max-width: 400px;
            margin: auto;
        }

        .payment-card label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        .payment-card input,
        .payment-card select {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px;
            width: 100%;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .payment-card button {
            background-color: #8126c0;
            color: white;
            font-weight: 600;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }


        .bob {
            background-color: #6a1fa1;
        }

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
                    <a href="login/login.php" class="login-link">
                        <i data-feather="user"></i> Login
                    </a>
                    <?php endif; ?>


                </ul>
            </div>
        </div>
    </nav>




    <div class="container my-4">
        <div class="row">
            <!-- Daftar Produk -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <?php
                        $grandTotal = 0;
                        $totalItem = 0;
                        while ($row = mysqli_fetch_assoc($result)) :
                            $subtotal = $row['harga'] * $row['jumlah'];
                            $grandTotal += $subtotal;
                            $totalItem += $row['jumlah'];
                    ?>
                        <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                            <img src="../img/produk/<?= $row['gambar'] ?>" alt="<?= $row['nama_produk'] ?>"
                                class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <div>
                                <h5 class="mb-1"><?= $row['nama_produk'] ?></h5>
                                <p class="mb-0 text-muted">Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <?php endwhile; ?>

                        <div class="mt-3">
                            <p class="fw-bold">Total Barang: <?= $totalItem ?></p>
                            <p class="fw-bold">Harga Total: Rp
                                <span id="total-harga"><?= number_format($grandTotal, 0, ',', '.') ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Pembayaran -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <?php
                        $id_pembeli = $_SESSION['ID_pembeli'];
                        $query = mysqli_query($conn, "SELECT ID_pesanan FROM Pemesanan WHERE ID_Pembeli = '$id_pembeli' AND status_pesanan = 'Belum Dibayar'");
                        $id_pesanan_array = [];
                        while ($row = mysqli_fetch_assoc($query)) {
                            $id_pesanan_array[] = $row['ID_pesanan'];
                        }
                        $id_pesanan_str = implode(",", $id_pesanan_array);
                    ?>

                        <!-- Form Pembayaran -->
                        <form action="../php/pembayaran/pembayaran.php" method="post" enctype="multipart/form-data"
                            class="payment-form mt-3">
                            <input type="hidden" name="id_pesanan" value="<?= $id_pesanan_str ?>">

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Pembayaran</label>
                                <input type="date" name="tanggal_pembayaran" id="tanggal" value="<?= date('Y-m-d') ?>"
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="metode" class="form-label">Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="metode" class="form-select">
                                    <option value="COD">COD</option>
                                    <option value="Transfer">Transfer</option>
                                </select>
                            </div>

                            <div id="bank-options" class="mb-3" style="display: none;">
                                <label class="form-label">Pilih Bank</label>
                                <table class="table table-bordered">
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

                                <label for="bukti" class="form-label">Upload Bukti Transfer</label>
                                <input type="file" name="bukti_transfer" id="bukti" accept="image/*"
                                    class="form-control">
                            </div>
                            <input type="hidden" id="total-harga" value="<?= $total_harga ?>">
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Bayar</label>
                                <input type="number" name="jumlah_bayar" id="jumlah" class="form-control" required>
                            </div>

                            <button type="submit" name="submit" class="btn bob btn-primary w-100">Kirim
                                Pembayaran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleBankOptions() {
            const metode = document.getElementById("metode").value;
            document.getElementById("bank-options").style.display = (metode === "Transfer") ? "block" : "none";
        }
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const metodeSelect = document.getElementById('metode');
            const bankOptions = document.getElementById('bank-options');
            const buktiTransfer = document.getElementById('bukti');
            const form = document.querySelector('.payment-form');
            const jumlahInput = document.getElementById('jumlah');

            // Ambil total harga dari tampilan, lalu konversi ke angka
            const totalHargaText = document.getElementById('total-harga').innerText.replace(/[^\d]/g, '');
            const totalHarga = parseFloat(totalHargaText);

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
                const jumlahBayar = parseFloat(jumlahInput.value);

                // Validasi Transfer
                if (metode === "Transfer" && buktiTransfer.files.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Bukti transfer wajib diunggah!',
                        confirmButtonColor: '#8126c0'
                    });
                    return;
                }

                // Validasi jumlah bayar harus >= total harga
                // Validasi jumlah bayar harus sama persis
                if (isNaN(jumlahBayar) || jumlahBayar !== totalHarga) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Jumlah bayar tidak sesuai!',
                        text: `Total yang harus dibayar adalah Rp ${totalHarga.toLocaleString('id-ID')}`,
                        confirmButtonColor: '#8126c0'
                    });
                }

            });

            // Feather Icons
            feather.replace();
        });

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
