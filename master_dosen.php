<?php 
include('koneksi.php'); 

if(isset($_POST['submit'])) {
    $nidn = $_POST['nidn'];
    $nama_dosen = $_POST['nama_dosen'];
    $email = $_POST['email'];

    $cek_nidn = mysqli_query($koneksi, "SELECT nidn FROM dosen WHERE nidn = '$nidn'");
    if(mysqli_num_rows($cek_nidn) > 0) {
        echo "<script>alert('Error: NIDN sudah terdaftar!');</script>";
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO dosen (nidn, nama_dosen, email) VALUES ('$nidn', '$nama_dosen', '$email')");
        if($insert) { header("Location: master_dosen.php"); }
    }
}

if(isset($_GET['hapus'])) {
    $nidn_hapus = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM dosen WHERE nidn = '$nidn_hapus'");
    header("Location: master_dosen.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Dosen</title>
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
                        <h5 class="card-title mb-4 fw-bold text-primary">Tambah Dosen</h5>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">NIDN</label>
                                <input type="text" name="nidn" class="form-control" placeholder="Contoh: 0412038901" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama_dosen" class="form-control" placeholder="Nama & Gelar" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="nama@univ.ac.id">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary w-100 fw-bold">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-4 fw-bold text-secondary">Daftar Dosen Pengampu</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>NIDN</th>
                                        <th>Nama Dosen</th>
                                        <th>Email</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT * FROM dosen ORDER BY nama_dosen ASC");
                                    if(mysqli_num_rows($query) == 0) {
                                        echo "<tr><td colspan='4' class='text-center text-muted'>Belum ada data dosen.</td></tr>";
                                    } else {
                                        while($dosen = mysqli_fetch_array($query)) {
                                            echo "<tr>";
                                            echo "<td>".$dosen['nidn']."</td>";
                                            echo "<td><strong>".$dosen['nama_dosen']."</strong></td>";
                                            echo "<td>".($dosen['email'] ? $dosen['email'] : '<span class="text-muted">-</span>')."</td>";
                                            echo "<td class='text-center'><a href='master_dosen.php?hapus=".$dosen['nidn']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus dosen ini?\")'>Hapus</a></td>";
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