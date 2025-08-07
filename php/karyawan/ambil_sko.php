<?php
include '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_gudang = $_POST['id_gudang'];
    $nama_produk = $_POST['nama_produk'];
    $jumlah_ambil = (int) $_POST['jumlah_ambil'];
    $ukuran = $_POST['ukuran'];
    $warna = $_POST['warna'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];

    // Handle upload gambar
    $gambar_name = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $upload_dir = __DIR__ . "/../../img/produk/";
    $upload_path = $upload_dir . basename($gambar_name);

    // Cek apakah folder bisa ditulis
    if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
        die("Folder tujuan tidak ditemukan atau tidak dapat ditulis.");
    }

    // Validasi upload berhasil
    if (!move_uploaded_file($gambar_tmp, $upload_path)) {
        die("Gagal mengupload gambar.");
    }

    // Ambil stok gudang
    $stok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM stok_gudang WHERE ID_gudang = $id_gudang"));

    if (!$stok || $jumlah_ambil > $stok['jumlah']) {
        die("Stok tidak cukup atau tidak ditemukan.");
    }

    // Simpan ke tabel produk
    $gambar_db_name = basename($gambar_name); // nama file saja untuk disimpan di DB
    $sql_produk = "INSERT INTO produk (ID_gudang, nama_produk, gambar, stok, ukuran, warna, harga, kategori)
                   VALUES ($id_gudang, '$nama_produk', '$gambar_db_name', $jumlah_ambil, '$ukuran', '$warna', '$harga', '$kategori')";
    mysqli_query($conn, $sql_produk);

    // Kurangi stok di gudang dan update barang_keluar
    $sisa = $stok['jumlah'] - $jumlah_ambil;
    mysqli_query($conn, "UPDATE stok_gudang SET jumlah = $sisa, barang_keluar = $jumlah_ambil WHERE ID_gudang = $id_gudang");

    header("Location: ../../karyawan/home.php?success=Produk berhasil ditambahkan");
    exit();
}

?>
