  <?php 
  session_start();
  include "../koneksi.php";
  if (isset($_POST['login'])) {
    $u = $_POST['user']; $p = $_POST['pass'];
    $q = mysqli_query($conn, "SELECT * FROM admin where username = '$u' AND password = '$p' ");
    if (mysqli_num_rows($q) > 0){
      $_SESSION['admin']=$u;
      header ("location:dashboard.php");
    }else {$err="Username atau Password salah!";}
    }
  ?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>Login Admin</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-secondary">
      <div class="container mt-5">
        <div class="card mx-auto p-4 shadow"style="max-width:400px;">
          <h4 class="text-center">LOGIN ADMIN </h4>
          <hr>
          <?php if (isset($err)) echo"<div class='alert alert-danger small'>$err</div>";?>
          <form method="POST">
            <input type="text" name="user" class="form-control mb-3" placeholder="username"required>
            <input type="password" name="pass" class="form-control mb-3" placeholder="password" required>
           <button type="submit" name="login" class="btn btn-dark w-100">Masuk</button>
          </form>
        </div>
      </div>
    </body>
  </html>