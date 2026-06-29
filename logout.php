<?php
// 1. Memulai atau mengaktifkan session yang sedang berjalan
session_start();

// 2. Menghapus semua variabel session yang tersimpan
session_unset();

// 3. Menghancurkan/menghapus session secara total dari server
session_destroy();

// 4. Mengalihkan (redirect) halaman kembali ke login.php
header("Location: login.php");
exit;
?>