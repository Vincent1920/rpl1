<?php
include '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['ID_user'])) {
        die("Error: User belum login");
    }

    $ID_user = $_SESSION['ID_user'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kode_pos = $_POST['kode_pos'];
    $nomor_hp = $_POST['nomor_hp'];

    // Path absolut untuk folder penyimpanan
    $folder = __DIR__ . "/../../img/biodata/";
    $relative_folder = "img/biodata/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true); // Buat folder jika belum ada
    }

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

    $allowed_ext = ['jpg', 'jpeg', 'png'];
    $newFileName = uniqid('foto_', true) . '.' . $ext;
    $fullPath = $folder . $newFileName;

    // Cek apakah user sudah punya data biodata
    $cek = mysqli_query($conn, "SELECT * FROM pembeli WHERE ID_user = '$ID_user'");
    $biodataAda = mysqli_num_rows($cek) > 0;

    // Jika ada file foto yang diupload
    if (!empty($foto)) {
        if (in_array($ext, $allowed_ext)) {
            if (move_uploaded_file($tmp, $fullPath)) {
                if ($biodataAda) {
                    // UPDATE dengan foto baru
                    $sql = "UPDATE pembeli 
                            SET foto = '$newFileName', nama = '$nama', alamat = '$alamat', kode_pos = '$kode_pos', nomor_hp = '$nomor_hp'
                            WHERE ID_user = '$ID_user'";
                } else {
                    // INSERT data baru
                    $sql = "INSERT INTO pembeli (ID_user, foto, nama, alamat, kode_pos, nomor_hp)
                            VALUES ('$ID_user', '$newFileName', '$nama', '$alamat', '$kode_pos', '$nomor_hp')";
                }
            } else {
                header("Location: ../../biodata/biodataEdit.php?error=Gagal upload foto");
                exit;
            }
        } else {
            header("Location: ../../biodata/biodataEdit.php?error=Format gambar harus jpg/jpeg/png");
            exit;
        }
    } else {
        // Jika tidak upload foto (update tanpa ganti foto)
        if ($biodataAda) {
            $sql = "UPDATE pembeli 
                    SET nama = '$nama', alamat = '$alamat', kode_pos = '$kode_pos', nomor_hp = '$nomor_hp'
                    WHERE ID_user = '$ID_user'";
        } else {
            header("Location: ../../biodata/biodataEdit.php?error=Foto wajib diisi saat pertama kali");
            exit;
        }
    }

    // Eksekusi SQL
    if (mysqli_query($conn, $sql)) {
        header("Location: ../../biodata/biodata.php?success=Biodata berhasil disimpan");
    } else {
        header("Location: ../../biodata/biodataEdit.php?error=Gagal menyimpan ke database");
    }
} else {
    header("Location: ../../biodata/biodataEdit.php?error=Akses ditolak");
    exit;
}
?>
