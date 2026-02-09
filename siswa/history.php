<?php
session_start();
include'../koneksi.php';
if(!isset($_SESSION['nis'])){header("location:login_siswa.php");exit;}
$nis=$_SESSION['nis'];
$q=mysqli_query($conn,"SELECT i.*,k.ket_kategori,a.status,a.feedback FROM input_aspirasi i JOIN kategori k ON i.id_kategori=k.id_kategori LEFT JOIN aspirasi a JOIN aspurasi a ON i.id_pelaporan=a.id_aspirasi WHERE i.nis='$nis'ORDER BY i.id_pelaporan DESC");

?>

<!DOCTYPE html>
<html>
<head>
  <title>Riwayat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootsttap.min.css"rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-primary mb-4 px-4 shadow"><span class="navbar-brand">RIWAYAT LAPORAN</span><a href="from_aspirasi.php"class="btn btn-outline-light btn-sm">Kembali </a></nav>
  <div class="container">
    <table class="table table-striped bg-white shadow-sm align-middle">
      <thead class="table-primary text-white"></thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($q)){
          $st=$row['status']??'Menunggu';
          ?>
          <tr>
            <td>#<?=$row['id_Pelaporan']?></td>
            <td><?=$row['ket_kategori']?></td>
            <td><?=$row['lokasi']?></td>
            <td><span class="badge bg-info text-dark"><?=$st?></span></td>
            <td><?=($row['feedback']==0?'-':'ID:'.$row['feedback']) ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>

</html>