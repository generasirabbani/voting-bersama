<?php
    include("config.php");
    session_start();
    ob_start();
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
    <title>E-Voting | Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link rel="stylesheet" href="beranda.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'> -->
</head>
<body class="bg-gray-100">
    <header>
    <div class="main w-full bg-sky-900 flex justify-between p-5 text-xl text-slate-400 shadow-xl fixed">
		<div class="navbar flex">
			<div class="pl-12 hover:text-slate-100 duration-300"><a href="beranda.php" class="dropdown">Home</a></div>
            <div class="px-10 hover:text-slate-100 duration-300"><a href="livecount.php">Live Count</a></div>
        </div>
        <div class="main">
            <a href="logout.php" class="tombolLogout pr-16 hover:text-slate-100 duration-300">Log out</a>
		</div>
    </div>
	</header>
    
    <?php
    $lines = pg_fetch_array(pg_query("SELECT count(*) from kandidat where token = '".$_SESSION['token']."'"));
    ?>

    <div class="h-44"></div>
    <?php if($lines[0]==2){ ?>
        <div class="mx-60 flex justify-between">
    <?php } elseif($lines[0]==3){ ?>
        <div class="mx-24 flex justify-between">
    <?php }else{ ?>
        <!-- <div class="grid gap-8 grid-cols-3"> -->
    <?php } ?>

    <?php
    $i = 1;
    $query = pg_query("SELECT * from kandidat where token = '".$_SESSION['token']."' order by nama asc");
    while($kandidat = pg_fetch_array($query)){;
        $tes[$i] = $kandidat['idkandidat']?>
        <div class="w-96 rounded shadow-lg h-min">
            <div class="w-full text-8xl h-60 bg-slate-300 rounded-t pt-16">
                <div class="rounded-full bg-slate-600 w-28 h-28 text-center mx-auto align-middle text-slate-100"><?php echo $i?></div>
            </div>
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">
                    <?php echo $kandidat['nama']?>
                </div>
                    <a href="<?php echo $kandidat['link']?>" class="cpt-3"><?php echo $kandidat['link']?></a>
                    <p class="pt-3"><?php echo $kandidat['visi']?></p>
                    <p class="py-3"><?php echo $kandidat['misi']?></p>
            </div>
        <?php
        if($_SESSION['cek'] == 'f'){;?>
            <div class="">
                <form action = "" class="py-3"   method = "POST">
                <input type="submit" class="px-8 py-2 rounded bg-sky-600 ml-36 rounded-full text-slate-100 hover:bg-sky-700 duration-100" name="pilih[<?php echo $i; ?>]" class="login login-submit" value="Pilih">
                </form>
            </div>
        </div>
        <?php 
        } else { ?>
            </div>
        <?php }
            $i++;};
            for($j = 1; $j < $i; $j++){
                $pil = "pilih[$j]";
                if(isset($_POST["pilih"][$j])&&!empty($_POST['pilih'][$j])){
                    $ID = $tes[$j];
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
            }
        ?>
        <div class="h-32 bg-red"></div>
</body>