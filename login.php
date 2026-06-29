<?php
session_start();
include('koneksi.php');

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Mencari data di tabel akun
    $query = mysqli_query($koneksi, "SELECT * FROM akun WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($query) === 1) {
        $data = mysqli_fetch_assoc($query);
        
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama']     = $data['nama'];
        $_SESSION['level']    = $data['level']; // Isinya berupa 'Dosen' atau 'Mahasiswa'
        
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1e3a8a; }
        .login-card { max-width: 400px; border-radius: 8px; margin-top: 10%; }
    </style>
</head>
<body class="bg-primary">
    <div class="container">
        <div class="card login-card mx-auto shadow p-4 bg-white">
            <div class="text-center mb-4">
                <img src="logo_uho.png" alt="Logo UHO" style="width: 90px; height: auto; display: block; margin: 0 auto 15px;">
                <h4 class="fw-bold mt-2 text-dark">Portal Academic</h4>
                <small class="text-muted">Silakan Login dengan Akun Anda</small>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger small py-2 text-center"><?= $error; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Username / NIM / NIDN</label>
                    <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100 fw-bold" style="background-color: #1e3a8a;">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>