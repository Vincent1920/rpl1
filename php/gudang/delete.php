<?php
include '../db.php'; // menyesuaikan path relatif dari folder `php/gudang`

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $sql = "DELETE FROM stok_gudang WHERE ID_gudang = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../gudang/stok.php?success=Data berhasil dihapus");
        exit;
    } else {
        header("Location: ../../gudang/stok.php.php?error=Gagal menghapus data: " . mysqli_error($conn));
        exit;
    }
} else {
    header("Location: ../../gudang/stok.php.php?error=ID tidak ditemukan");
    exit;
}
?>
