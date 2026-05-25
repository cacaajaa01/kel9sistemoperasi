<?php 
include('koneksi.php'); 

if(isset($_POST['submit'])) {
    $kode_mk = $_POST['kode_mk'];
    $nidn = $_POST['nidn'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $ruangan = $_POST['ruangan'];

    $insert = mysqli_query($koneksi, "INSERT INTO jadwal (kode_mk, nidn, hari, jam, ruangan) VALUES ('$kode_mk', '$nidn', '$hari', '$jam', '$ruangan')");
    if($insert) {
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal menambah jadwal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4 fw-bold text-primary text-center">Buat Jadwal Kuliah Baru</h4>
                        <form action="" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pilih Mata Kuliah</label>
                                <select name="kode_mk" class="form-select" required>
                                    <option value="">-- Hubungkan Mata Kuliah --</option>
                                    <?php
                                    $query_mk = mysqli_query($koneksi, "SELECT * FROM matakuliah");
                                    while($mk = mysqli_fetch_array($query_mk)) {
                                        echo "<option value='".$mk['kode_mk']."'>".$mk['kode_mk']." - ".$mk['nama_mk']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pilih Dosen Pengampu</label>
                                <select name="nidn" class="form-select" required>
                                    <option value="">-- Hubungkan Dosen --</option>
                                    <?php
                                    $query_dosen = mysqli_query($koneksi, "SELECT * FROM dosen");
                                    while($dosen = mysqli_fetch_array($query_dosen)) {
                                        echo "<option value='".$dosen['nidn']."'>".$dosen['nama_dosen']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Hari</label>
                                    <select name="hari" class="form-select" required>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Jam Mulai</label>
                                    <input type="time" name="jam" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Ruangan</label>
                                <input type="text" name="ruangan" class="form-control" placeholder="Contoh: Lab Komputer 2" required>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" name="submit" class="btn btn-success flex-grow-1 fw-bold">Simpan Jadwal</button>
                                <a href="index.php" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>