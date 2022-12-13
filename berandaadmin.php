<?php
    include("config.php");
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: log.php");
        exit;
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BerandaAdmin</title>
    <link rel="stylesheet" href="beranda.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<body>
    <header>
		<ul class="navbar">
			<li><a href="berandaadmin.php" class="dropdown">Home</a></li>
            <li><a href="tambahkandidat.php">Tambah kandidat </a></li>
            <li><a href="livecount.php">Live Count </a></li>
            <li><a href="listadmin.php">List Admin </a></li>
            <li><a href="listvoter.php">List Voter </a></li>
        </ul>
        <div class="main">
            <span class="nyambutUser">Hi!  </span>
            <p>|</p>
            <a href="logout.php" class="tombolLogout">Log out</a>
		</div>
	</header>
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
        <form action = "" method = "POST">
        <input type="submit" name="edit" class="login login-submit" value="Edit">
        <input type="submit" name="delete" class="login login-submit" value="Delete">
        </form>
        <?php 
            if(isset($_POST['delete'])&&!empty($_POST['delete'])){
                $ID = $kandidat['idkandidat'];
                $query = pg_query("DELETE FROM kandidat WHERE idkandidat ='$ID'");
                if($query){
                    header('Location: berandaadmin.php');
                }
                else{
                    die("gagal menghapus...");
                }
            }
            $_SESSION['id_edit'] = $kandidat['idkandidat'];
            if(isset($_POST['edit'])){
                header('Location: editkandidat.php');
            }
            $i++;}
            $query2 = pg_query("SELECT * from admin where token = '".$_SESSION['token']."'");
            $voting = pg_fetch_array($query2);
            if($voting['start'] == 'f'){;
            ?>
            <form action = "" method = "POST">
            <input type="submit" name="start" class="login login-submit" value="start voting">
            </form>
            <?php
                if(isset($_POST['start']) &&$voting['start'] == 'f'){
                    $query3 = pg_query("UPDATE admin SET start = 'TRUE' WHERE token= '".$_SESSION['token']."'");
                    header('Location: berandaadmin.php');
                }
            }else{;
                ?>
            <form action = "" method = "POST">
            <input type="submit" name="stop" class="login login-submit" value="Stop">
            </form>
            <?php
            if(isset($_POST['stop'])&&$voting['start'] == 't'){
                    $query3 = pg_query("UPDATE admin SET start = 'FALSE' WHERE token= '".$_SESSION['token']."'");
                    header('Location: berandaadmin.php');
                }
            }
            ?>
</body>
