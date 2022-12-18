<?php
    include("config.php");
    session_start();
    ob_start();
    if(!isset($_SESSION['username'])){
        header("Location: log.php");
        exit;
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Voting | Beranda Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link rel="stylesheet" href="beranda.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'> -->
</head>
<body class="bg-gray-100">
    <header>
        <div class="main w-full bg-sky-900 flex justify-between p-5 text-xl text-slate-400 shadow-xl fixed">
            <div class="navbar flex">
                <div class="pl-12 hover:text-slate-100 duration-300"><a href="berandaadmin.php" class="dropdown">Home</a></div>
                <div class="pl-10 hover:text-slate-100 duration-300"><a href="tambahkandidat.php">Tambah kandidat</a></div>
                <div class="pl-10 hover:text-slate-100 duration-300"><a href="livecount.php">Live Count</a></div>
                <div class="pl-10 hover:text-slate-100 duration-300"><a href="listadmin.php">List Admin </a></div>
                <div class="pl-10 hover:text-slate-100 duration-300"><a href="listvoter.php">List Voter </a></div>
            </div>
            <div class="main">
                <a href="logout.php" class="tombolLogout pr-16 hover:text-slate-100 duration-300">Log out</a>
            </div>
        </div>
	</header>

    <!-- <div> -->
    <?php
    $count = pg_fetch_array(pg_query("SELECT count(*) from kandidat where token = '".$_SESSION['token']."'"));
    // echo gettype($count[0]);
    // $count[0] = (int)$count[0];
    // echo gettype($count[0]);
    // echo gettype(2);
    ?>
    <!-- </div> -->

    <div class="h-44"></div>
    <?php if($count[0]==2){ ?>
        <div class="mx-60 flex justify-between">
    <?php } elseif($count[0]==3){ ?>
        <div class="mx-24 flex justify-between">
    <?php } elseif($count[0]==1){ ?>
        <div class="mx-24 flex justify-between">
    <?php }else{ ?>
        <!-- <div class="grid gap-8 grid-cols-3"> -->
    <?php } ?>
    
    <?php
    $i = 1;
    $query = pg_query("SELECT * from kandidat where token = '".$_SESSION['token']."' order by nama asc");
    while($kandidat = pg_fetch_array($query)){;
        $edt[$i] = $kandidat['idkandidat']?>
        <div class="w-96 rounded shadow-lg bg-slate-100">
            <div class="w-full text-8xl h-60 bg-slate-300 pt-16 rounded-t">
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
            <form class="px-6 pt-4 pb-2 text-xl justify-end flex" action = "" method = "POST">
                <input type="submit" name="edit[<?php echo $i; ?>]" class="shadow-lg border-r-2 border-sky-800 login login-submit pl-4 pr-3 py-2 rounded-r bg-sky-700 rounded-full text-slate-100 hover:bg-sky-900 duration-100" value="Edit">
                <input type="submit" name="delete[<?php echo $i; ?>]" class="shadow-lg login login-submit pr-4 pl-3 py-2 rounded-l bg-sky-700 rounded-full text-slate-100 hover:bg-sky-900 duration-100" value="Delete">
            </form>
        </div>
        <?php
            $i++;}
            for($j = 1; $j < $i; $j++){
                if(isset($_POST["edit"][$j])&&!empty($_POST['edit'][$j])){
                    $_SESSION['id_edit'] = $edt[$j];
                    header('Location: editkandidat.php');
                }
            }
            for($j = 1; $j < $i; $j++){
                if(isset($_POST["delete"][$j])&&!empty($_POST['delete'][$j])){
                    $ID = $edt[$j];
                    $query = pg_query("DELETE FROM kandidat WHERE idkandidat ='$ID'");
                    if($query){
                        header('Location: berandaadmin.php');
                    }
                    else{
                        die("gagal menghapus...");
                    }
                }
            }
        ?>
        </div>
            <?php
            $query2 = pg_query("SELECT * from admin where token = '".$_SESSION['token']."'");
            $voting = pg_fetch_array($query2);
            if($voting['start'] == 'f'){;
            ?>
        
            <form action = "" class="<?php if(($count[0]==1)||($count[0]==3)){echo 'mx-24';}else{echo 'mx-60';}?> my-12 text-2xl" method = "POST">
                <input type="submit" name="start" class="login login-submit px-4 py-2 bg-red-700 rounded-xl text-slate-100" value="Start Voting">
            </form>
            <?php
                if(isset($_POST['start']) &&$voting['start'] == 'f'){
                    $query3 = pg_query("UPDATE admin SET start = 'TRUE' WHERE token= '".$_SESSION['token']."'");
                    header('Location: berandaadmin.php');
                }
            }else{;
                ?>
            <form action = "" class="<?php if(($count[0]==1)||($count[0]==3)){echo 'mx-24';}else{echo 'mx-60';}?> my-12 text-2xl" method = "POST">
                <input type="submit" name="stop" class="login login-submit px-4 py-2 bg-red-700 rounded-xl text-slate-100" value="Stop">
            </form>
            <?php
            if(isset($_POST['stop'])&&$voting['start'] == 't'){
                    $query3 = pg_query("UPDATE admin SET start = 'FALSE' WHERE token= '".$_SESSION['token']."'");
                    header('Location: berandaadmin.php');
                }
            }
            ?>
            <div class="h-32 bg-red"></div>
</body>