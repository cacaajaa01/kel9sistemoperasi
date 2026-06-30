<?php 
session_start();
include('koneksi.php'); 

// Proteksi Halaman: Hanya Mahasiswa yang boleh melihat halaman ini
if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'Mahasiswa') {
    header("Location: login.php");
    exit;
}

$username_mhs = $_SESSION['username'];

// --- PROSES PEMBATALAN LANGSUNG DARI HALAMAN KRS SAYA ---
if (isset($_GET['aksi']) && $_GET['aksi'] == 'batal') {
    $id_jadwal = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    $hapus = mysqli_query($koneksi, "DELETE FROM krs WHERE username='$username_mhs' AND id_jadwal='$id_jadwal'");
    if ($hapus) {
        echo "<script>alert('Mata kuliah berhasil dihapus dari KRS kamu.'); window.location.href='krs_saya.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KRS Saya - Kartu Rencana Studi</title>
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
        @media print {
            .sidebar, .topbar, .btn-batal, .btn-cetak-box { display: none !important; }
            .main-content { margin-left: 0 !important; padding: 0 !important; }
            body { background-color: #fff; }
        }
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
            <small class="text-muted">Portal <?= $_SESSION['level']; ?></small>
        </div>
        <div class="nav-menu">
            <a href="index.php"><i class="bi bi-calendar3"></i> Jadwal Kuliah</a>
            <a href="ambil_mk.php"><i class="bi bi-journal-plus"></i> Penawaran RPS</a>
            <a href="krs_saya.php" class="active"><i class="bi bi-file-earmark-text"></i> KRS Saya</a>
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
        <div class="card shadow-sm p-4 mb-4 border-0 bg-white" style="border-left: 5px solid #112244 !important;">
            <div class="d-flex justify-content-between align-items-center btn-cetak-box">
                <div>
                    <h2 class="text-dark fw-bold mb-1">Kartu Rencana Studi (KRS)</h2>
                    <p class="text-muted mb-0">Berikut adalah daftar seluruh mata kuliah resmi yang kamu programkan.</p>
                </div>
                <button onclick="window.print()" class="btn btn-dark"><i class="bi bi-printer"></i> Cetak KRS</button>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                
                <div class="row mb-4 text-dark border-bottom pb-3">
                    <div class="col-md-6">
                        <table>
                            <tr><td style="width: 120px;" class="fw-bold">Nama</td><td>: <?= $_SESSION['nama']; ?></td></tr>
                            <tr><td class="fw-bold">NIM / Username</td><td>: <?= $_SESSION['username']; ?></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <table>
                            <tr><td style="width: 120px;" class="fw-bold">Status</td><td>: Aktif</td></tr>
                            <tr><td class="fw-bold">Institusi</td><td>: Universitas Halu Oleo</td></tr>
                        </table>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light text-dark">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Waktu Kuliah</th>
                                <th>Kode & Mata Kuliah</th>
                                <th class="text-center" style="width: 100px;">SKS</th>
                                <th class="text-center" style="width: 120px;">Semester</th>
                                <th>Dosen Pengampu</th>
                                <th>Ruangan</th>
                                <th class="text-center btn-batal" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_krs = "SELECT krs.id_krs, jadwal.hari, jadwal.jam, jadwal.ruangan, jadwal.id_jadwal,
                                               matakuliah.kode_mk, matakuliah.nama_mk, matakuliah.sks, matakuliah.semester,
                                               dosen.nama_dosen
                                        FROM krs
                                        INNER JOIN jadwal ON krs.id_jadwal = jadwal.id_jadwal
                                        INNER JOIN matakuliah ON jadwal.kode_mk = matakuliah.kode_mk
                                        INNER JOIN dosen ON jadwal.nidn = dosen.nidn
                                        WHERE krs.username = '$username_mhs'
                                        ORDER BY jadwal.hari DESC, jadwal.jam ASC";
                            
                            $query_krs = mysqli_query($koneksi, $sql_krs);
                            $no = 1;
                            $total_sks = 0;

                            if(mysqli_num_rows($query_krs) == 0) {
                                echo "<tr><td colspan='8' class='text-center text-muted py-4'>Kamu belum memprogramkan mata kuliah apapun semester ini.</td></tr>";
                            } else {
                                while($data = mysqli_fetch_array($query_krs)){
                                    $total_sks += $data['sks'];
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><span class="badge bg-primary"><?= $data['hari']; ?></span> <small class="text-muted"><?= $data['jam']; ?></small></td>
                                    <td><strong><?= $data['kode_mk']; ?></strong> - <?= $data['nama_mk']; ?></td>
                                    <td class="text-center"><?= $data['sks']; ?></td>
                                    <td class="text-center">Semester <?= $data['semester']; ?></td>
                                    <td><?= $data['nama_dosen']; ?></td>
                                    <td><span class="badge bg-secondary"><?= $data['ruangan']; ?></span></td>
                                    <td class="text-center btn-batal">
                                        <a href="krs_saya.php?aksi=batal&id=<?= $data['id_jadwal']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Batalkan memprogram mata kuliah ini?')">
                                            <i class="bi bi-trash3"></i> Batal
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                }
                                ?>
                                <tr class="table-dark text-white fw-bold">
                                    <td colspan="3" class="text-end">Jumlah Total SKS yang Diambil:</td>
                                    <td class="text-center"><?= $total_sks; ?> SKS</td>
                                    <td colspan="4"></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php if(mysqli_num_rows($query_krs) > 0) : ?>
                <div class="row mt-5 pt-3">
                    <div class="col-6">
                        </div>
                    <div class="col-6 text-end">
                        <p class="mb-0">Kendari, <?= date('d M Y'); ?></p>
                        <p class="fw-bold mb-5">Mahasiswa Yang Bersangkutan,</p>
                        <br>
                        <p class="fw-bold text-decoration-underline mb-0"><?= $_SESSION['nama']; ?></p>
                        <small class="text-muted">NIM. <?= $_SESSION['username']; ?></small>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>