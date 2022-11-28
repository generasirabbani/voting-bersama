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
if(isset($_POST['login'])&&!empty($_POST['login'])){
    $hashpassword = md5($_POST['pass']);
    $password = $_POST['pass'];
    $data = pg_query("select * from pengguna where email = '".pg_escape_string($_POST['email'])."' and password ='".$hashpassword."'"); 
    $data1 = pg_query("select * from admin where username = '".pg_escape_string($_POST['email'])."' and password ='".$password."'"); 
    $login_check = pg_num_rows($data); 
    $admin_check = pg_num_rows($data1);
    if($login_check > 0){
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['token'] = pg_fetch_array($data)['token']; 
        $_SESSION['cek'] = pg_fetch_array($data)['cek']; 
        header('Location: beranda.php');
    }
    elseif($admin_check > 0){
      $_SESSION['username'] = $_POST['email'];
      $_SESSION['token'] = pg_fetch_array($data1)['token'];
      header('Location: berandaadmin.php');
    }
    else{
        header('Location: log.php?status=gagal');
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginPage</title>
    <link rel="stylesheet" href="log.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<div class="login-card">
    <p>
        Voting<span class="p-subtitle">Bersama</span><hr><br><br>
        <p>Log-in</p><br>
    </p>
  <form action = "" method = "POST">
    <input type="text" name="email" placeholder="Email">
    <input type="password" name="pass" placeholder="Password">
    <input type="submit" name="login" class="login login-submit" value="login">
  </form>
  <div class="login-help">
    <a href="register.php">Register</a>
  </div>
  <?php if(isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
  <div> 
    <p><span class="p-subtitlee">email atau password salah</span></p>
  </div>
  <?php endif; ?>
</div>
