<?php
session_start();
include'../koneksi.php';
if(isset($_POST['login'])){
  $nis=$_POST['nis'];
  $q=mysqli_query($conn,"SELECT * FROM siswa WHERE nis='$nis'");
  if(mysqli_num_rows($q)>0){
    $_SESSION['nis']=$nis;
    header("location:from_aspitasi.php");
  }else{$err="NIS tidak terdaftar di sistem!";}
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"rel="stylesheet">
</head>
<body class="bg-primary d-flex align-items-center" style="height:100vh;">
 <div class="card mx-auto p-4 shadow" style="width:350px;">
  <h4 class="text-center">LOGIN SISWA</h4><hr>
  <?php if(isset($err)) echo"<div class='alert alert-danger small'>$err</div>";?>
  <from method="POST">
    <input type="text" name="nis" class="from-control mb-3" placeholder="Masukan NIS"required>
    <button type="submit" name="login" class="btn btn-primary w-100">Masuk</button>
   </from>
 </div>
</body>
</html>