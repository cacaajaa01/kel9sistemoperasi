<?php 
session_start();
include('koneksi.php'); 

// Proteksi Halaman: Pastikan user sudah login sebelum masuk ke dashboard
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Proteksi Halaman: Pastikan user memiliki hak akses sebagai dosen
if ($_SESSION['level'] !== 'Dosen') {
    header("Location: login.php");
    exit;
}

$username_user = $_SESSION['username'];
$level_user = $_SESSION['level'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Mata Kuliah Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; }
        .sidebar { width: 260px; min-height: 100vh; background-color: #ffffff; box-shadow: 2px 0 5px rgba(0,0,0,0.05); position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { background-color: #112244; color: white; padding: 20px 15px; display: flex; align-items: center; font-weight: bold; font-size: 1rem; }
        .user-profile-box { padding: 20px 15px; text-align: center; border-bottom: 1px solid #f0f0f0; }
        .user-avatar { width: 65px; height: 65px; border-radius: 50%; background-color: #1e3a8a; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 10px; }
        .nav-menu { padding: 15px 0; }
        .nav-menu a { display: flex; align-items: center; padding: 12px 20px; color: #555; text-decoration: none; font-size: 0.95rem; transition: all 0.2s; }
        .nav-menu a i { margin-right: 15px; font-size: 1.1rem; width: 20px; }
        .nav-menu a:hover, .nav-menu a.active { background-color: #1e3a8a; color: white; font-weight: 500; }
        .topbar { height: 60px; background-color: #1e3a8a; position: fixed; top: 0; right: 0; left: 260px; z-index: 99; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .main-content { margin-left: 260px; padding: 85px 30px 30px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="logo_uho.png" alt="Logo UHO" style="width: 30px; height: auto; margin-right: 10px;">
            UNIVERSITAS HALU OLEO
        </div>
        <div class="user-profile-box">
            <div class="user-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <h6 class="mb-0 fw-bold text-dark"><?= $_SESSION['nama']; ?></h6>
            <small class="text-muted">Portal <?= $level_user; ?></small>
        </div>
        <div class="nav-menu">
            <a href="index.php" class="active"><i class="bi bi-calendar3"></i> Jadwal Kuliah</a>
            
            <?php if ($level_user === 'Dosen') : ?>
                <a href="master_dosen.php"><i class="bi bi-people-fill"></i> Data Dosen</a>
                <a href="master_mk.php"><i class="bi bi-book-fill"></i> Data Mata Kuliah</a>
            <?php endif; ?>
            
            <?php if ($level_user === 'Mahasiswa') : ?>
                <a href="ambil_mk.php"><i class="bi bi-journal-plus"></i> Penawaran RPS</a>
                <a href="krs_saya.php"><i class="bi bi-file-earmark-text"></i> KRS Saya</a>
            <?php endif; ?>
            
            <hr class="mx-3 my-2 text-muted">
            <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Keluar (Logout)</a>
        </div>
    </div>

    <div class="topbar d-flex align-items-center justify-content-between px-4">
        <div class="d-flex align-items-center text-white">
            <i class="bi bi-list fs-4 me-3" style="cursor: pointer;"></i>
            <span class="fw-semibold">Sistem Informasi Mata Kuliah Digital</span>
        </div>
        <div class="text-white d-flex align-items-center">
            <i class="bi bi-bell-fill me-3 fs-5" style="cursor: pointer;"></i>
            <i class="bi bi-person-circle fs-4" style="cursor: pointer;"></i>
        </div>
    </div>

    <div class="main-content">
        <div class="card shadow-sm p-4 mb-4 border-0 bg-white" style="border-left: 5px solid #1e3a8a !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">Sistem Informasi Mata Kuliah Digital</h2>
                    <p class="text-muted mb-0">Selamat Datang di Portal Manajemen Jadwal Perkuliahan.</p>
                </div>
                
                <?php if ($level_user === 'Mahasiswa') : ?>
                    <a href="ambil_mk.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Ambil Mata Kuliah (Tawar RPS)</a>
                <?php else : ?>
                    <a href="tambah_jadwal.php" class="btn btn-success"><i class="bi bi-calendar-plus"></i> Tambah Jadwal Kuliah</a>
                <?php endif; ?>
            </div>
        </div>

        <?php 
        if ($level_user === 'Mahasiswa') {
            $hitung_sks = mysqli_query($koneksi, "SELECT SUM(matakuliah.sks) AS total FROM krs 
                          INNER JOIN jadwal ON krs.id_jadwal = jadwal.id_jadwal
                          INNER JOIN matakuliah ON jadwal.kode_mk = matakuliah.kode_mk
                          WHERE krs.username = '$username_user'");
            $row_sks = mysqli_fetch_assoc($hitung_sks);
            $total_sks_sekarang = $row_sks['total'] ?? 0;
        ?>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 bg-white" style="border-left: 4px solid #ffc107 !important;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted small text-uppercase mb-1 fw-bold">Total SKS Diambil</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= $total_sks_sekarang; ?> <span class="fs-6 text-muted fw-normal">SKS</span></h3>
                        </div>
                        <div class="bg-warning-subtle text-warning p-3 rounded-circle fs-4 lh-1">
                            <i class="bi bi-book-half"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-table"></i> Jadwal Perkuliahan Semester Berjalan</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Waktu</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Dosen Pengampu</th>
                                <th>Ruangan</th>
                                <th class="text-center" style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT jadwal.id_jadwal, jadwal.hari, jadwal.jam, jadwal.ruangan,
                                           matakuliah.kode_mk, matakuliah.nama_mk, matakuliah.sks, matakuliah.semester,
                                           dosen.nama_dosen
                                    FROM jadwal
                                    INNER JOIN matakuliah ON jadwal.kode_mk = matakuliah.kode_mk
                                    INNER JOIN dosen ON jadwal.nidn = dosen.nidn
                                    ORDER BY jadwal.hari DESC, jadwal.jam ASC";
                            
                            $query = mysqli_query($koneksi, $sql);
                            $no = 1;

                            while($data = mysqli_fetch_array($query)){
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><span class="badge bg-primary"><?= $data['hari']; ?></span> <small class="text-muted"><?= $data['jam']; ?></small></td>
                                <td><strong><?= $data['kode_mk']; ?></strong> - <?= $data['nama_mk']; ?></td>
                                <td><?= $data['sks']; ?> SKS</td>
                                <td>Semester <?= $data['semester']; ?></td>
                                <td><?= $data['nama_dosen']; ?></td>
                                <td><span class="badge bg-secondary"><?= $data['ruangan']; ?></span></td>
                                <td class="text-center">
                                    <?php if ($level_user === 'Dosen') : ?>
                                        <a href="hapus_jadwal.php?id=<?= $data['id_jadwal']; ?>" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin menghapus jadwal kuliah ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    <?php else : ?>
                                        <button class="btn btn-outline-secondary btn-sm w-100" disabled>Read Only</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>