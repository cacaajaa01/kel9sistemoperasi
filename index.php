<?php include('koneksi.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary fw-bold">Sistem Informasi Mata Kuliah Digital</h2>
            <div>
                <a href="master_dosen.php" class="btn btn-outline-secondary btn-sm me-2">Kelola Dosen</a>
                <a href="master_mk.php" class="btn btn-outline-secondary btn-sm">Kelola Mata Kuliah</a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0 text-secondary">Jadwal Perkuliahan</h5>
                    <a href="tambah_jadwal.php" class="btn btn-success">+ Tambah Jadwal</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Dosen Pengampu</th>
                                <th>Ruangan</th>
                                <th class="text-center">Aksi</th>
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
                            
                            if(mysqli_num_rows($query) == 0) {
                                echo "<tr><td colspan='8' class='text-center text-muted py-4'>Belum ada jadwal kuliah.</td></tr>";
                            } else {
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
                                        <a href="hapus_jadwal.php?id=<?= $data['id_jadwal']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus jadwal ini?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php 
                                } 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>