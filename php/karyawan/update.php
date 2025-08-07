<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $nama = $_POST['nama_produk'];
    $stok_baru = (int)$_POST['stok'];
    $ukuran = $_POST['ukuran'];
    $warna = $_POST['warna'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];

    // Ambil data produk lama
    $result = mysqli_query($conn, "SELECT stok, ID_gudang FROM produk WHERE ID_produk = $id");
    $produk_lama = mysqli_fetch_assoc($result);

    $stok_lama = (int)$produk_lama['stok'];
    $selisih = $stok_baru - $stok_lama;
    $id_gudang = (int)$produk_lama['ID_gudang'];

    // Upload gambar jika ada
    $gambarBaru = '';
    if (!empty($_FILES['gambar']['name'])) {
        $gambarBaru = basename($_FILES['gambar']['name']);
        $targetPath = "../img/produk/" . $gambarBaru;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath);
    }

    // Update produk
    $sql = "UPDATE produk SET 
        nama_produk = '$nama',
        stok = $stok_baru,
        ukuran = '$ukuran',
        warna = '$warna',
        harga = $harga,
        kategori = '$kategori'"
        . ($gambarBaru ? ", gambar = '$gambarBaru'" : "") .
        " WHERE ID_produk = $id";

    $updateProduk = mysqli_query($conn, $sql);

    if (!$updateProduk) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    // Update stok gudang jika stok bertambah
    if ($selisih > 0) {
        mysqli_query($conn, "
            UPDATE stok_gudang 
            SET 
                jumlah = jumlah - $selisih,
                barang_keluar = barang_keluar + $selisih
            WHERE ID_gudang = $id_gudang
        ");
    }

    header("Location: ../../karyawan/home.php?success=Produk berhasil diupdate");
    exit;
}
?>
