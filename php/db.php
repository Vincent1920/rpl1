<?php

require_once __DIR__ . '/../vendor/autoload.php';

/* The code snippet ` = Dotenv\Dotenv::createImmutable(__DIR__ . '/..'); ->load();` is
using the Dotenv library in PHP to load environment variables from a `.env` file located one
directory above the current directory. */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

$conn = new mysqli($host, $user, $pass, $dbname);

// cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
