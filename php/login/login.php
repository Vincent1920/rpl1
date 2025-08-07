<?php
session_start();
include '../db.php'; // koneksi ke database

// Ambil input dari form
$email = $_POST['email'];
$password = $_POST['password'];

// Cek apakah email ada di tabel user
$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Simpan data user ke session
        $_SESSION['ID_user'] = $user['ID_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Kalau user adalah pembeli, ambil ID_pembeli dari tabel pembeli
        if ($user['role'] == 'pembeli') {
            $stmt2 = $conn->prepare("SELECT ID_pembeli FROM pembeli WHERE ID_user = ?");
            $stmt2->bind_param("i", $user['ID_user']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($result2->num_rows === 1) {
                $pembeli = $result2->fetch_assoc();
                $_SESSION['ID_pembeli'] = $pembeli['ID_pembeli'];

                // Redirect ke home pembeli
                header("Location: ../../index.php");
                exit;
            } else {
                // Belum isi biodata → arahkan ke halaman isi biodata
                $_SESSION['ID_pembeli'] = null;
                header("Location: ../../biodata/biodata.php?error=Isi biodata terlebih dahulu");
                exit;
            }
        }

        // Role lain (admin, gudang, pemilik)
        elseif ($user['role'] == 'admin_gudang') {
            header("Location: ../../gudang/dashboard.php");
            exit;
        } elseif ($user['role'] == 'karyawan') {
            header("Location: ../../karyawan/home.php");
            exit;
        } elseif ($user['role'] == 'pemilik') {
            header("Location: ../../pemilik/home.php");
            exit;
        }

    } else {
        header("Location: ../../login/login.php?error=Password salah");
        exit;
    }
} else {
    header("Location: ../../login/login.php?error=Email tidak ditemukan");
    exit;
}
?>
