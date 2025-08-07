<?php
include '../db.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['ID_user'])) {
    echo "Silakan login terlebih dahulu.";
    exit;
}

$id_user = $_SESSION['ID_user'];

// Ambil ID_pembeli dari tabel pembeli berdasarkan ID_user
$query_pembeli = mysqli_query($conn, "SELECT * FROM pembeli WHERE ID_user = '$id_user'");
$data_pembeli = mysqli_fetch_assoc($query_pembeli);

if (!$data_pembeli) {
    echo "Data pembeli tidak ditemukan.";
    exit;
}

$id_pembeli = $data_pembeli['ID_pembeli'];

// Ambil data produk dari form (POST atau GET tergantung pengiriman datanya)
$id_produk = $_GET['ID_produk'] ?? $_POST['ID_produk'] ?? null;
$nama_produk = $_POST['nama_produk'] ?? null;
$harga = $_POST['harga'] ?? 0;
$jumlah = $_POST['jumlah'] ?? 1;
$status_pesanan = "Belum Dibayar";
$metode = ""; // metode nanti diisi saat transaksi
$tanggal = date('Y-m-d'); // tanggal hari ini otomatis
$satuan = 'pcs';
// Validasi: jika ID_produk tidak tersedia
if (!$id_produk) {
    echo "ID produk tidak tersedia.";
    exit;
}

// Hitung subtotal
$subtotal = $harga * $jumlah;

// Query insert ke tabel pemesanan
$query = "INSERT INTO pemesanan 
(ID_produk, ID_pembeli, nama_produk, jumlah, harga, metode_pembayaran, status_pesanan, tanggal, satuan) 
VALUES 
('$id_produk', '$id_pembeli', '$nama_produk', '$jumlah', '$harga', '$metode', '$status_pesanan','$tanggal', '$satuan')";

mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirect kembali ke halaman produk atau keranjang
header("Location: ../../keranjang/keranjang.php?success=Berhasil+di+tambahkan!");
exit;
?>
