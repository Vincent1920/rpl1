<?php
include '../../php/db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Ambil data produk (gambar, stok, ID_gudang)
    $getData = mysqli_query($conn, "SELECT gambar, stok, ID_gudang FROM produk WHERE ID_produk = $id");
    $data = mysqli_fetch_assoc($getData);

    if ($data) {
        $gambar = $data['gambar'];
        $stok_produk = (int)$data['stok'];
        $id_gudang = (int)$data['ID_gudang'];

        // Hapus file gambar jika ada
        if (!empty($gambar)) {
            $filePath = '../../img/produk/' . $gambar;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Kembalikan stok ke gudang
        $updateGudang = mysqli_query($conn, "
            UPDATE stok_gudang 
            SET 
                jumlah = jumlah + $stok_produk,
                barang_keluar = barang_keluar - $stok_produk
            WHERE ID_gudang = $id_gudang
        ");

        // Hapus produk
        $delete = mysqli_query($conn, "DELETE FROM produk WHERE ID_produk = $id");

        if ($delete && $updateGudang) {
            header("Location: ../../karyawan/home.php?success=Produk berhasil dihapus dan stok gudang dikembalikan");
        } else {
            header("Location: ../../karyawan/home.php?error=Gagal menghapus produk atau mengembalikan stok");
        }
    } else {
        header("Location: ../../karyawan/home.php?error=Produk tidak ditemukan");
    }
} else {
    header("Location: ../../karyawan/home.php?error=ID tidak ditemukan");
}
?>
