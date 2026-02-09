<?php 
  session_start();
  if(!isset($_SESSION['admin'])) { header("location:login_admin.php"); exit;}
  include '../koneksi.php';

  $filter_kat = $_GET['kategori']??"";
  $filter_st = $_GET['status']??"";
  $sort_by = $_GET['sort']??'id_pelaporan';
  $order = $_GET['order']??'DESC';
  $next_order = ($order == 'ASC') ? 'DESC' : 'ASC';

  $sql = "SELECT i.*, k.ket_kategori, a.status FROM input_aspirasi i JOIN kategori k ON i.id_kategori = k.id_kategori LEFT JOIN aspirasi a ON i.id_pelaporan = a.id_aspirasi";

  $cond = [];
  if($filter_kat) $cond[] = "i.id_kategori = '$filter_kat'";
  if($filter_st) $cond[] = ($filter_st == 'menunggu' ? "(a.status = 'menunggu' OR a.status IS NULL)" : "a.status='$filter_st'");

  if($cond) $sql .= "WHERE".implode("AND", $cond);

 $sql .= " ORDER BY $sort_by $order";
 $res = mysqli_query($conn, $sql);

  function sortUrl($col, $ord) {
    $p = $_GET; $p['sort'] = $col; $p['order'] = $ord;
    return "?" .http_build_query($p);
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-dark mb-4 px-4 shadow">
   <span class="navbar-brand fw-bold">ADMIN PANEL</span>
   <a href="../logout.php"class="btn btn-danger btn-sm">Logout</a>
  </nav>
  <div class="container">
   <h4 class="mb-3">Kelola Aspirasi</h4>
   <div class="card p-3 border-0 shadow-sm mb-4">
    <form method="GET"class="row g-2">
     <div class="col-md-4">
      <select name="kategori"class="form-select">
       <option value="">--Semua Kategori--</option>
       <?php $k = mysqli_query($conn,"SELECT * FROM kategori");
       while( $rk = mysqli_fetch_assoc($k)) {
        $s = ( $filter_kat == $rk['id_kategori'] ? 'selected': "");
        echo "<option value='".$rk['id_kategori']."' $s> ".$rk['ket_kategori']."</option>";
       } ?>
      </select>
   </div>
  <div class="col-md-3">
  <select name="status" class="form-select">
    <option value="">-- Semua Status --</option>
     <option value="menunggu" <?=($filter_st == 'menunggu' ? 'selected' : "")?>>Menunggu</option>
     <option value="proses" <?=($filter_st == 'proses' ? 'selected': "")?>>Proses</option>
     <option value="selesai"<?=($filter_st == 'selesai' ? 'selected': "")?>>Selesai</option>
    </select>
  </div>
     <div class="col-md-2"><button type="submit"class="btn btn-primary w-100">Cari</button></div>
     <div class="col-md-2"><a href="dashboard.php"class="btn btn-outline-secondary w-100">Reset</a></div>
    </form>
  </div>
  
 <table class="table table-hover bg-white shadow-sm align-middle">
   <thead class="table-dark">
    <tr>
     <th class="text-center"><a href="<?=sortUrl('id_pelaporan',$next_order) ?>" class = "text-white text-decoration-none">ID</a></th>
     <th><a href="<?= sortUrl('nis',$next_order) ?>" class = "text-white text-decoration-none">NIS</a></th>
     <th>Kategori</th>
     <th>Laporan</th>
     <th class="text-center">Status</th>
     <th class="text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = mysqli_fetch_assoc($res)){
      $st = $row['status'] ?? 'menunggu';
      $bg = ($st == 'selesai' ? 'success' : ($st == 'proses' ? 'warning text-dark' : 'secondary'));
    ?>
 <tr>
    <td class="text-center">#<?= $row['id_pelaporan'] ?></td>
    <td><?= $row['nis'] ?></td>
    <td><?= $row['ket_kategori'] ?></td>
    <td><?= $row['keterangan'] ?></td>
    <td class="text-center"><span class="badge bg-<?= $bg ?>"><?= $st ?></span></td>
    <td class="text-center"><a href="update_status.php?id=<?= $row['id_pelaporan'] ?>" class="btn btn-sm btn-primary px-3">Tanggapi</a></td>
    </tr>
    <?php } ?>
  </tbody>
 </table>
 </div>
</body>
</html>