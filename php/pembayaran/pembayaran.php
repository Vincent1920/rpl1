<?php
include '../db.php';
session_start();

if (isset($_POST['submit'])) {
      $id_pesanan_str = trim($_POST['id_pesanan']); //
    if (empty($id_pesanan_str)) {
        // Kembalikan ke halaman sebelumnya dengan pesan error
        header("Location: ../../keranjang/keranjang.php?error=Tidak ada pesanan. Silakan tambahkan produk ke pesanan terlebih dahulu.");
        exit;
    }
    $id_pesanan_str = $_POST['id_pesanan']; // "3,5,6"
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    // Upload bukti transfer
 $bukti_transfer = "";
if ($_FILES['bukti_transfer']['name'] != "") {
    $target_dir = __DIR__ . "/../../img/bukti_transfer/";
    $bukti_transfer = basename($_FILES["bukti_transfer"]["name"]);
    move_uploaded_file($_FILES["bukti_transfer"]["tmp_name"], $target_dir . $bukti_transfer);
}


    // Pecah ID_Pesanan jadi array
    $id_pesanan_array = explode(",", $id_pesanan_str);

    foreach ($id_pesanan_array as $id_pesanan) {
        // Insert ke tabel pembayaran
        mysqli_query($conn, "INSERT INTO pembayaran (ID_pesanan, tanggal_pembayaran, metode_pembayaran, jumlah_bayar, bukti_transfer) VALUES ('$id_pesanan', '$tanggal_pembayaran', '$metode_pembayaran', '$jumlah_bayar', '$bukti_transfer')");
mysqli_query($conn, "UPDATE pemesanan 
    SET status_pesanan = 'Dibayar', 
        metode_pembayaran = '$metode_pembayaran',
        bukti_transfer = '$bukti_transfer'
    WHERE ID_pesanan = '$id_pesanan'");

    }

    echo "Pembayaran berhasil!";
    header("Location: ../../pengiriman/pengiriman.php?success=berhasi di bayar"); 
    exit;
}
?>
