<?php
include '../db.php';

if (isset($_POST['id_pesanan'], $_POST['status_pengiriman'], $_POST['estimasi_tiba'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $status_pesanan = $_POST['status_pengiriman'];
    $estimasi_tiba = $_POST['estimasi_tiba'];

    $query = "UPDATE pemesanan 
              SET status_pesanan = '$status_pesanan', 
                  estimasi_tiba = '$estimasi_tiba'
              WHERE ID_pesanan = '$id_pesanan'";
echo '<pre>';
print_r($_POST);
echo '</pre>';

    if (mysqli_query($conn, $query)) {
        header("Location: ../../karyawan/status_pesanan.php?success=Status Berhasil diubah");
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
} else {
    echo "Data tidak lengkap yang dikirim ke server.";
}
?>
