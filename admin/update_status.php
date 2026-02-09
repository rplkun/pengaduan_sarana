    <?php
    session_start();
    include'../koneksi.php';
    if (!isset($_SESSION['admin'])){header("location:login_admin.php");exit;}
    $id=$_GET['id'];
    if(isset($_POST['simpan'])){
    $st=$_POST['status'];
    $fb=$_POST['feedback'];

    mysqli_query($conn,
    "UPDATE aspirasi SET status='$st',feedback='$fb' WHERE id_aspirasi='$id'");
    header("location:dashboard.php");
    }
    $q=mysqli_query($conn, "SELECT i.*,a.status, a.feedback FROM input_aspirasi i LEFT JOIN aspirasi a ON i.id_laporan=a.id_aspirasi WHERE i.id_laporan='$id'");
    $d=mysqli_fetch_assoc($q);
    ?>
<!DOCTYPE html> 
<html>
    <head>
        <title>Update Status</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="container mt-5">
            <div class="card mx-auto shadow-sm p-4" style="max-width: 500px;">
                <h5>Berikan Tanggapan #<?= $id ?></h5><hr>
                <form method="POST">
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status"class="form-select">
                            <option value="menunggu" <?=($d['status'] == 'menunggu' ? 'selected' : "") ?>>Menunggu</option>
                            <option value="proses" <?=($d['status'] == 'proses' ? 'selected' : "") ?>>Proses</option>
                            <option value="selesai" <?=($d['status'] == 'selesai' ? 'selected' : "") ?>>Selesai</option>
                        </select>
                        <div class="mb-3">
                            <label>Feedback (Angka)</label>
                            <input type="number" name="feedback" class="form-control" value="<?= $d['feedback'] ?>" required>
                        </div>
                        <button type="submit" name="simpan" class="btn btn-success w-100">Simpan Perubahan</button>
                        <a href="dashboard.php" class="btn btn-link w-100 mt-2 text-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>