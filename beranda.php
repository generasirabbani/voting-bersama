<?php
    include("config.php");
    session_start();
    $data = pg_query("SELECT * from pengguna where email = '".$_SESSION['email']."'");
    $data2 = pg_query("SELECT * from admin where token = '".$_SESSION['token']."'");
    $hehe = pg_fetch_array($data);
    $hehehe = pg_fetch_array($data2);
    $_SESSION['start'] = $hehehe['start']; 
    $_SESSION['block'] = $hehe['block']; 
    if(!isset($_SESSION['email'])||$_SESSION['start'] == 'f'||$_SESSION['block'] == 't'){
        header("Location: log.php");
        exit;
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="beranda.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<body>
    <header>
    <div class="main">
        <ul class="navbar">
                <li><a href="beranda.php" class="dropdown">Home</a></li>
                <li><a href="livecount.php" class="tombolLogout">Live Count</a></li>
        </ul>
        <p>|</p>
        <a href="logout.php" class="tombolLogout">Log out</a>
	</div>
	</header>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php
    $i = 1;
    $query = pg_query("SELECT * from kandidat where token = '".$_SESSION['token']."' order by nama asc");
    while($kandidat = pg_fetch_array($query)){;?>
        <p><?php echo $i?></p>
        <p><?php echo $kandidat['nama']?></p>
        <a href="<?php echo $kandidat['link']?>"><?php echo $kandidat['link']?></a>
        <p><?php echo $kandidat['visi']?></p>
        <p><?php echo $kandidat['misi']?></p>
        <?php
        if($_SESSION['cek'] == 'f'){;?>
        <div>
        <form action = "" method = "POST">
        <input type="submit" name="pilih" class="login login-submit" value="Pilih">
        </form>
        </div>
        <?php 
        }
            if(isset($_POST['pilih'])&&!empty($_POST['pilih'])){
                $ID = $kandidat['idkandidat'];
                $query = pg_query("UPDATE kandidat SET jumlahsuara= jumlahsuara + 1 WHERE idkandidat='$ID'");
                $query1 = pg_query("UPDATE pengguna SET cek = 'TRUE' WHERE email= '".$_SESSION['email']."'");
                $query3 = pg_query("UPDATE pengguna SET pilih = '$ID' WHERE email= '".$_SESSION['email']."'");
                $query2 = pg_query("Select * from pengguna WHERE email= '".$_SESSION['email']."'");
                $_SESSION['cek'] = pg_fetch_array($query2)['cek']; 
                if($query && $query1 && $query3){
                    header('Location: beranda.php');
                }
                else{
                    die("gagal menghapus...");
                }
            }
            $i++;};
        ?>
</body>
