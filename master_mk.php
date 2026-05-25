<?php 
include('koneksi.php'); 

if(isset($_POST['submit'])) {
    $kode_mk = $_POST['kode_mk'];
    $nama_mk = $_POST['nama_mk'];
    $sks = $_POST['sks'];
    $semester = $_POST['semester'];

    $cek_kode = mysqli_query($koneksi, "SELECT kode_mk FROM matakuliah WHERE kode_mk = '$kode_mk'");
    if(mysqli_num_rows($cek_kode) > 0) {
        echo "<script>alert('Error: Kode Mata Kuliah sudah terdaftar!');</script>";
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO matakuliah (kode_mk, nama_mk, sks, semester) VALUES ('$kode_mk', '$nama_mk', '$sks', '$semester')");
        if($insert) { header("Location: master_mk.php"); }
    }
}

if(isset($_GET['hapus'])) {
    $kode_hapus = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM matakuliah WHERE kode_mk = '$kode_hapus'");
    header("Location: master_mk.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="mb-4">
            <a href="index.php" class="btn btn-secondary btn-sm">← Kembali ke Dashboard</a>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-4 fw-bold text-primary">Tambah Mata Kuliah</h5>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kode MK</label>
                                <input type="text" name="kode_mk" class="form-control" placeholder="Contoh: INF201" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Mata Kuliah</label>
                                <input type="text" name="nama_mk" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Bobot SKS</label>
                                <select name="sks" class="form-select" required>
                                    <option value="1">1 SKS</option>
                                    <option value="2">2 SKS</option>
                                    <option value="3" selected>3 SKS</option>
                                    <option value="4">4 SKS</option>
                                    <option value="6">6 SKS</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Semester</label>
                                <input type="number" name="semester" class="form-control" min="1" max="8" placeholder="1-8" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary w-100 fw-bold">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-4 fw-bold text-secondary">Daftar Mata Kuliah Digital</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>Semester</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT * FROM matakuliah ORDER BY semester ASC, kode_mk ASC");
                                    if(mysqli_num_rows($query) == 0) {
                                        echo "<tr><td colspan='5' class='text-center text-muted'>Belum ada data mata kuliah.</td></tr>";
                                    } else {
                                        while($mk = mysqli_fetch_array($query)) {
                                            echo "<tr>";
                                            echo "<td><span class='badge bg-secondary'>".$mk['kode_mk']."</span></td>";
                                            echo "<td><strong>".$mk['nama_mk']."</strong></td>";
                                            echo "<td>".$mk['sks']." SKS</td>";
                                            echo "<td>Semester ".$mk['semester']."</td>";
                                            echo "<td class='text-center'><a href='master_mk.php?hapus=".$mk['kode_mk']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus mata kuliah ini?\")'>Hapus</a></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>