<?php
session_start();
include '../koneksi.php';
if (!isset($_SESSION['nis'])) {
    header("location: login_siswa.php");
    exit;
}
$nis = $_SESSION['nis'];

if (isset($_POST['sub'])) {
    $id = rand(1000, 9999);
    $kat = $_POST['kat'];
    $_POST ['lok'];
    $ket= $_POST ['ket'];
    mysqli_query($conn, "INSERT INTO input_aspirasi VALUES ('$id', '$nis', '$kat', '$lokasi', '$ket')");
    mysqli_query($conn, "INSERT INTO aspirasi(id_aspirasi, status, id_kategori, feedback) VALUES('$id', 'menunggu', '$kat', 0)");
    echo "<script>alert('laporan terkirim!');window.location='history.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>From Aspirasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4 px-4 shadow">
        <span class="navbar-brand">PENGADUAN SAYA</span>
        <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
    </nav>
    <div class="container" style="max-width:600px;">
        <div class="card p-4 shadow-sm border-0">
            <h5>Buat Pengaduan</h5><hr>
            <form method="POST">  
                <label>Kategori</label>
                <select name="kat" class="form-select mb-3" required>
                    <option value="" disabled>Pilih Kategori</option>
                    <?php 
                    $k = mysqli_query($conn, "SELECT * FROM kategori");
                    while ($rk = mysqli_fetch_assoc($k)) {
                        echo "<option value='" . $rk['id_kategori'] . "'>" . $rk['ket_kategori'] . "</option>";
                    }
                    ?>
                </select>
                <label>Lokasi</label>
                <input type="text" name="lok" class="form-control mb-3" required>  
                <label>Keterangan Laporan</label>
                <textarea name="ket" class="form-control mb-3" required></textarea>  
                <button type="submit" name="sub" class="btn btn-primary w-100">Kirim Sekarang</button>  
                <a href="history.php" class="btn btn-outline-secondary w-100 mt-2">Lihat Riwayat</a>
            </form>  
        </div>
    </div>
</body>
</html>