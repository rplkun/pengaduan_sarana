<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['nis'])) {
    header("location:login_siswa.php");
    exit;
}

$nis = $_SESSION['nis'];

// Perbaikan spasi pada ORDER BY
$query_str = "SELECT i.*, k.ket_kategori, a.status, a.feedback 
              FROM input_aspirasi i 
              JOIN kategori k ON i.id_kategori = k.id_kategori 
              LEFT JOIN aspirasi a ON i.id_laporan = a.id_aspirasi 
              WHERE i.nis = '$nis' 
              ORDER BY i.id_laporan DESC";

$q = mysqli_query($conn, $query_str);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Laporan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-primary mb-4 px-4 shadow">
    <span class="navbar-brand">RIWAYAT LAPORAN</span>
    <a href="form_aspirasi.php" class="btn btn-outline-light btn-sm">Kembali</a>
  </nav>

  <div class="container">
    <div class="table-responsive">
      <table class="table table-striped bg-white shadow-sm align-middle">
        <thead class="table-primary">
          <tr>
            <th>ID</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Feedback</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          // Cek apakah ada data
          if (mysqli_num_rows($q) > 0) {
              while ($row = mysqli_fetch_assoc($q)) {
                  $st = $row['status'] ?? 'Menunggu';
                  ?>
                  <tr>
                    <td>#<?php echo $row['id_laporan']; ?></td>
                    <td><?php echo $row['ket_kategori']; ?></td>
                    <td><?php echo $row['lokasi']; ?></td>
                    <td><span class="badge bg-info text-dark"><?php echo $st; ?></span></td>
                    <td>
                        <?php echo ($row['feedback'] == "" || $row['feedback'] == "0") ? '-' : 'ID: '.$row['feedback']; ?>
                    </td>
                  </tr>
                  <?php 
              } 
          } else {
              echo "<tr><td colspan='5' class='text-center'>Belum ada riwayat laporan.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>