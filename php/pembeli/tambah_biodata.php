<?php
include '../../php/db.php';
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

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $folder = "../../img/biodata/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $path = $folder . basename($foto);

    if (move_uploaded_file($tmp, $path)) {
        $sql = "INSERT INTO pembeli (ID_user, foto, nama, alamat, kode_pos, nomor_hp)
                VALUES ('$ID_user', '$foto', '$nama', '$alamat', '$kode_pos', '$nomor_hp')";
        if (mysqli_query($conn, $sql)) {
            header("Location: ../../biodata/biodata.php?success=Biodata berhasil disimpan");
            exit;
        } else {
            header("Location: ../../biodata/biodataEdit.php?error=Gagal menyimpan biodata");
            exit;
        }
    } else {
        header("Location: ../../biodata/biodataEdit.php?error=Gagal upload foto");
        exit;
    }
} else {
    header("Location: ../../biodata/biodataEdit.php?error=Akses ditolak");
    exit;
}
?>
