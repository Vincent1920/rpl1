<?php
$host = "localhost";
$user = "root";
$pass = ""; // ganti jika ada password
$dbname = "rpl1"; // ganti dengan nama database

$conn = new mysqli($host, $user, $pass, $dbname);

// cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
