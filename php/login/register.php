<?php
include '../db.php'; // koneksi database

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validasi input
if (empty($username) || empty($email) || empty($password)) {
    header("Location: ../login/register.php?error=Semua+field+wajib+diisi");
    exit();
}
// Cek apakah email sudah ada
$cek_email = $conn->prepare("SELECT ID_user FROM user WHERE Email = ?");
$cek_email->bind_param("s", $email);
$cek_email->execute();
$cek_email->store_result();

if ($cek_email->num_rows > 0) {
    // Email sudah terdaftar
    header("Location: ../../login/register.php?error=" . urlencode("Email sudah terdaftar"));
    exit();
}
$cek_email->close();

// Enkripsi password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Simpan ke tabel user
$sql = "INSERT INTO user (Username, Email, Password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $hashedPassword);

if ($stmt->execute()) {
    $id_user = $stmt->insert_id; 
    $sql_pembeli = "INSERT INTO pembeli (ID_user) VALUES (?)";
    $stmt_pembeli = $conn->prepare($sql_pembeli);
    $stmt_pembeli->bind_param("i", $id_user);
    $stmt_pembeli->execute();
    $stmt_pembeli->close();

    header("Location: ../../login/login.php?success=Berhasil+register!");
    exit();
} else {
    $error = $conn->errno === 1062 ? "Email+sudah+terdaftar" : "Registrasi+gagal";
    header("Location: ../../login/register.php?error=$error");
    exit();
}

$stmt->close();
$conn->close();
?>
