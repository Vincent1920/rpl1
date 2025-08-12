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

    // Folder upload
    $folder = __DIR__ . '/../../img/biodata/';
    if (!is_dir($folder)) {
        mkdir($folder, 0775, true);
    }

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

    $allowed_ext = ['jpg', 'jpeg', 'png'];
    $newFileName = uniqid('foto_', true) . '.' . $ext;
    $fullPath = $folder . $newFileName;

    // Cek apakah user sudah punya biodata
    $cek = mysqli_query($conn, "SELECT * FROM pembeli WHERE ID_user = '$ID_user'");
    $biodataAda = mysqli_num_rows($cek) > 0;
    $dataLama = $biodataAda ? mysqli_fetch_assoc($cek) : null;

    if (!empty($foto)) {
        if (in_array($ext, $allowed_ext)) {
            if (move_uploaded_file($tmp, $fullPath)) {
                // Hapus foto lama jika ada
                if ($biodataAda && !empty($dataLama['foto'])) {
                    $oldFilePath = $folder . $dataLama['foto'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                if ($biodataAda) {
                    $sql = "UPDATE pembeli 
                            SET foto = '$newFileName', nama = '$nama', alamat = '$alamat', kode_pos = '$kode_pos', nomor_hp = '$nomor_hp'
                            WHERE ID_user = '$ID_user'";
                } else {
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
        if ($biodataAda) {
            $sql = "UPDATE pembeli 
                    SET nama = '$nama', alamat = '$alamat', kode_pos = '$kode_pos', nomor_hp = '$nomor_hp'
                    WHERE ID_user = '$ID_user'";
        } else {
            header("Location: ../../biodata/biodataEdit.php?error=Foto wajib diisi saat pertama kali");
            exit;
        }
    }

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
