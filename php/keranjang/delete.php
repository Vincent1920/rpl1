<?php
session_start();
include '../db.php';
$id = $_POST['id_pemesanan'];
mysqli_query($conn, "DELETE FROM pemesanan WHERE ID_Pesanan = '$id'");
header("Location: ../../keranjang/keranjang.php");
?>