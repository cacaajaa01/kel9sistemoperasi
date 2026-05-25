<?php
// Konfigurasi Database
$host = "localhost"; // Jika kamu menggunakan Docker, ganti "localhost" menjadi "db"
$user = "root";      // Username default MySQL di XAMPP/Laragon biasanya "root"
$pass = "";          // Password default MySQL di XAMPP/Laragon biasanya kosong
$db   = "db_perkuliahan_digital"; // Nama database relasional yang sudah kita buat

// Membuat koneksi ke database MySQL
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Memeriksa apakah koneksi berhasil atau gagal
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>