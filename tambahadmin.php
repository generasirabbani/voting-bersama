<?php
include("config.php");
session_start();
if(isset($_SESSION['email'])){
    header("Location: beranda.php");
    exit;
}
elseif(isset($_SESSION['username'])){
    header("Location: berandaadmin.php");
    exit;
}
if(isset($_POST['next'])&&!empty($_POST['next'])){
	$ID = $_POST['idadmin'];
    $nama = $_POST['nama'];
	$asal = $_POST['asal'];
    $token = $_SESSION['token'];
  if(empty($ID) || empty($nama) || empty($asal)){
    header('Location: tambahadmin.php?status=empty');
  }else{
    $query = pg_query("INSERT INTO useradmin (idadmin, namaadmin, asal, token) VALUEs ('$ID','$nama', '$asal', '$token')");
    if($query == TRUE ) {
        header('Location: tambahadmin.php?status=berhasil');
    } else {
      header('Location: tambahadmin.php?status=gagal');
    }
  }
}
if(isset($_POST['regis'])&&!empty($_POST['regis'])){
    session_start();
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("Location: log.php?status=regadminberhasil");
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="log.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<div class="login-card">
    <p>Daftarkan Pengguna Akun</p><hr><br><br>
  <form action = "" method = "POST">
    <input type="text" name="idadmin" placeholder="ID">
    <input type="text" name="nama" placeholder="Nama Lengkap">
    <input type="text" name="asal" placeholder="Asal Institusi">
    <input type="submit" name="next" class="login-help" value="tambahkan admin">
    <input type="submit" name="regis" class="login login-submit" value="Selesai">
    <?php if(isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
      <p><span class="p-subtitlee">Admin sudah terdaftar</span> </p>
    <?php endif; ?>
    <?php if(isset($_GET['status']) && $_GET['status'] == 'empty'): ?>
      <p> <span class="p-subtitlee">ada yang kosong</span> </p>
    <?php endif; ?>
    <?php if(isset($_GET['status']) && $_GET['status'] == 'berhasil'): ?>
      <p> <span class="p-subtitlee">admin berhasil ditambahkan</span> </p>
    <?php endif; ?>
  </form>

</div>