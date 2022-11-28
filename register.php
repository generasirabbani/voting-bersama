<?php
include("config.php");
session_start();
if(isset($_SESSION['email'])){
    header("Location: beranda.php");
    exit;
}
elseif(isset($_SESSION['user'])){
    header("Location: berandaadmin.php");
    exit;
}
if(isset($_POST['regis'])&&!empty($_POST['regis'])){
	$nama = $_POST['nama'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$passwordjuga = $_POST['passwordjuga'];
  $token = $_POST['token'];
  $check = pg_query("SELECT token from admin where token = '$token' ");
  if(empty($nama) || empty($email) || empty($password) || empty($token)){
    header('Location: register.php?status=empty');
  }else if($password != $passwordjuga || pg_num_rows($check) == 0){
    header('Location: register.php?status=gasama');
  }else{
    $hashpassword = md5($password);
    $query = pg_query("INSERT INTO pengguna (nama, email, password, token, cek) VALUEs ('$nama', '$email', '$hashpassword','$token', 'FALSE')");
    if($query == TRUE) {
      header('Location: log.php');
    } else {
      header('Location: register.php?status=gagal');
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
    <p>Register</p><hr><br><br>
  <form action = "" method = "POST">
    <input type="text" name="nama" placeholder="Name">
    <input type="text" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <input type="password" name="passwordjuga" placeholder="Retype Password">
    <input type="text" name="token" placeholder="Token">
    <input type="submit" name="regis" class="login login-submit" value="Register">
    <?php if(isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
      <p><span class="p-subtitlee">Email sudah terdaftar</span> </p>
    <?php endif; ?>
    <?php if(isset($_GET['status']) && $_GET['status'] == 'gasama'): ?>
      <p><span class="p-subtitlee">token atau password tidak sama</span></p>
    <?php endif; ?>
    <?php if(isset($_GET['status']) && $_GET['status'] == 'empty'): ?>
      <p> <span class="p-subtitlee">ada yang kosong</span> </p>
    <?php endif; ?>
  </form>

</div>