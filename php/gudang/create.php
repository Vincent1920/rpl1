<?php
include '../db.php'; // koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keterangan     = $_POST['keterangan'] ?? '';
    $tanggal        = $_POST['tanggal'] ?? '';
    $jumlah         = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 0;
    $jenis_barang   = $_POST['jenis_barang'] ?? '';
    $barang_masuk   = isset($_POST['barang_masuk']) ? (int)$_POST['barang_masuk'] : 0;

    // Validasi form
    if (empty($keterangan) || empty($tanggal) || empty($jenis_barang) || $jumlah < 1 || $barang_masuk < 1) {
        header("Location: ../../gudang/barang_masuk.php?error=Harap lengkapi semua kolom dan minimal jumlah & barang masuk = 1");
        exit;
    }

    // Simpan ke database
    $sql = "INSERT INTO stok_gudang 
            (keterangan, tanggal, jumlah, jenis_barang, barang_masuk, barang_keluar)
            VALUES (
                '$keterangan',
                '$tanggal',
                $jumlah,
                '$jenis_barang',
                $barang_masuk,
                NULL
            )";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../gudang/stok.php?success=Barang masuk berhasil disimpan");
    } else {
        $error = mysqli_error($conn);
        header("Location: ../../gudang/barang_masuk.php?error=Gagal menyimpan data: $error");
    }
}
