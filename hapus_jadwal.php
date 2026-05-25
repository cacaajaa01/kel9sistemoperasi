<?php
// Memanggil koneksi database
include('koneksi.php');

// Memeriksa apakah ada parameter 'id' yang dikirimkan melalui URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query SQL untuk menghapus jadwal berdasarkan id_jadwal
    $delete = mysqli_query($koneksi, "DELETE FROM jadwal WHERE id_jadwal = '$id'");

    // Jika proses hapus berhasil, langsung dialihkan kembali ke halaman utama
    if($delete) {
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus jadwal perkuliahan.'); window.location='index.php';</script>";
    }
} else {
    // Jika file diakses langsung tanpa ID, kembalikan ke index.php
    header("Location: index.php");
    exit;
}
?>