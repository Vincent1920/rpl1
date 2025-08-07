<?php
include '../db.php'; // koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id             = (int)$_POST['id'];
    $barang_keluar  = isset($_POST['barang_keluar']) ? (int)$_POST['barang_keluar'] : 0;

    // Validasi: barang_keluar tidak boleh negatif
    if ($barang_keluar < 0) {
        header("Location: ../../gudang/stok.php?error=Barang keluar tidak boleh bernilai negatif");
        exit;
    }

    // Ambil data stok lama
    $query = "SELECT jumlah, barang_keluar FROM stok_gudang WHERE ID_gudang = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        header("Location: ../../gudang/stok.php?error=Data tidak ditemukan");
        exit;
    }

    $jumlah_sekarang = $data['jumlah'];
    $barang_keluar_lama = (int)$data['barang_keluar'];
    $barang_keluar_baru = $barang_keluar;

    // Hitung sisa stok baru
    $jumlah_baru = $jumlah_sekarang - ($barang_keluar_baru - $barang_keluar_lama);

    if ($jumlah_baru < 0) {
        header("Location: ../../gudang/stok.php?error=Barang keluar melebihi stok tersedia");
        exit;
    }

    // Update stok dan barang_keluar
    $sql = "UPDATE stok_gudang 
            SET barang_keluar = $barang_keluar_baru,
                jumlah = $jumlah_baru
            WHERE ID_gudang = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../gudang/stok.php?success=Barang keluar berhasil diperbarui");
    } else {
        $error = mysqli_error($conn);
        header("Location: ../../gudang/stok.php?error=Gagal update: $error");
    }
}
?>
