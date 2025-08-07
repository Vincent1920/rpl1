<?php
session_start();
include '../db.php';

$id = $_POST['id_pesanan'];

$query = "SELECT jumlah FROM pemesanan WHERE ID_pesanan = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$jumlah = $row['jumlah'];

if (isset($_POST['tambah'])) {
    $jumlah++;
} elseif (isset($_POST['kurang']) && $jumlah > 1) {
    $jumlah--;
}

mysqli_query($conn, "UPDATE pemesanan SET jumlah = '$jumlah' WHERE ID_pesanan = '$id'");
header("Location: ../../keranjang/keranjang.php");
?>