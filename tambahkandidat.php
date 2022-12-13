<?php
include("config.php");
session_start();
if(!isset($_SESSION['username'])){
    header("Location: log.php");
    exit;
}
if(isset($_POST['regis'])&&!empty($_POST['regis'])){
	$ID = $_POST['ID'];
    $nama = $_POST['nama'];
	$link = $_POST['link'];
	$visi = $_POST['visi'];
	$misi = $_POST['misi'];
  $token = $_SESSION['token'];
  if(empty($ID) || empty($nama) || empty($link) || empty($visi) ||empty($misi) || empty($token) ){
    header('Location: tambahkandidat.php?status=empty');
  }else{
    $query = pg_query("INSERT INTO kandidat (idkandidat, nama, link, visi, misi, token, jumlahsuara) VALUEs ('$ID','$nama', '$link','$visi','$misi','$token', 0)");
    if($query == TRUE) {
      header('Location: berandaadmin.php');
    } else {
      header('Location: tambahkandidat.php?status=gagal');
    }
  }
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
    <p>Tambah Kandidat</p><hr><br><br>
  <form action = "" method = "POST">
    <input type="text" name="ID" placeholder="ID">
    <input type="text" name="nama" placeholder="Nama Lengkap">
    <input type="text" name="link" placeholder="Link Grand Design">
    <input type="text" name="visi" placeholder="Visi">
    <input type="text" name="misi" placeholder="Misi">
    <input type="submit" name="regis" class="login login-submit" value="Tambahkan">
    <?php if(isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
      <p><span class="p-subtitlee">Kandidat sudah terdaftar</span> </p>
    <?php endif; ?>
    <?php if(isset($_GET['status']) && $_GET['status'] == 'empty'): ?>
      <p> <span class="p-subtitlee">ada yang kosong</span> </p>
    <?php endif; ?>
  </form>

</div>