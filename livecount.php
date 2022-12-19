<?php
    include("config.php");
    session_start();
    if(isset($_SESSION['email'])){
        $data = pg_query("SELECT * from pengguna where email = '".$_SESSION['email']."'");
        $hehe = pg_fetch_array($data);
        $_SESSION['block'] = $hehe['block'];
    }
    $data2 = pg_query("SELECT * from admin where token = '".$_SESSION['token']."'");
    $hehehe = pg_fetch_array($data2);
    $_SESSION['start'] = $hehehe['start']; 
    if((!isset($_SESSION['email'])||$_SESSION['block'] == 't')&&!isset($_SESSION['username'])){
        header("Location: logout.php");
        exit;
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Count</title>
    <!-- <link rel="stylesheet" href="beranda.css"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
            borderWidth: {
                '3': '3px',
            }
        }
      }
    }
  </script>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<body class="bg-gray-100 w-full">
<header>
        <?php
        if(isset($_SESSION['email'])){;
        ?>
		<div class="main w-full bg-sky-900 flex justify-between p-5 text-xl text-slate-400 shadow-xl fixed">
            <div class="navbar flex">
                <div class="pl-12 hover:text-slate-100 duration-300"><a href="beranda.php" class="dropdown">Home</a></div>
                <div class="px-10 hover:text-slate-100 duration-300"><a href="livecount.php">Live Count</a></div>
            </div>
            <div class="main">
                <a href="logout.php" class="tombolLogout pr-16 hover:text-slate-100 duration-300">Log out</a>
            </div>
        </div>
        <?php }elseif(isset($_SESSION['username'])){; ?>
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
        <?php }; ?>
	</header>

    <div class="h-44"></div>

    <?php
    $lines = pg_fetch_array(pg_query("SELECT count(*) from kandidat where token = '".$_SESSION['token']."'"));
    ?>

	<table class="w-3/5 mx-auto text-xl">
	<thead class="text-zinc-800">
		<tr>
			<th class="bg-zinc-400 border-y-3 border-l-3 border-y-zinc-700 border-l-zinc-700 h-14 text-left p-3">No</th>
			<th class="bg-zinc-400 border-y-3 border-y-zinc-700 h-14 text-left p-3">Nama</th>
			<th class="bg-zinc-400 border-y-3 border-y-zinc-700 h-14 text-left p-3">Suara</th>
			<th class="bg-zinc-400 border-y-3 border-r-3 border-y-zinc-700 border-r-zinc-700 h-14 text-left p-3">Suara dalam persen</th>
		</tr>
	</thead>
	<tbody>
		<?php
        $i = 1;
		$query = pg_query("SELECT * FROM kandidat where token = '".$_SESSION['token']."' order by nama asc");
        $count = pg_query("SELECT SUM(jumlahsuara) FROM kandidat where token = '".$_SESSION['token']."'");
        $count = pg_fetch_array($count);
		while($kandidat = pg_fetch_array($query)){
            if($count[0] > 0){
			    $persen = 100.0*$kandidat['jumlahsuara']/$count[0];
            }
            else{
                $persen = 0;
            }?>

            <div></div>
            <?php if($i==$lines[0]){?>
                <tr class='text-xl'>
                    <td class='border-b-3 border-l-3 bg-gray-300 border-zinc-700 h-14 text-left p-3'><?php echo $i ?></td>
                    <td class='border-b-3 h-14 bg-gray-200 border-zinc-700 text-left p-3'><?php echo $kandidat['nama']?></td>
                    <td class='border-b-3 h-14 bg-gray-300 border-zinc-700 text-left p-3'><?php echo $kandidat['jumlahsuara']?></td>
                    <td class='border-b-3 border-r-3 bg-gray-200 border-zinc-700 h-14 text-left p-3'>
                        <?php if($persen!=0){?>
                        <div class="text-base">
                            <?php echo round($persen,2)."%"?>
                        </div> 
                        <div class="pl-4 bg-sky-600 rounded-xl h-8" style="width: <?php echo round($persen,0).'%'?> ">
                        </div>
                        <?php ;}else{?>
                            <div>
                            <?php echo round($persen,2)."%"?>
                        </div>
                        <?php ;}?>
                    </td>

                </tr>
            <?php }else{?>
            <tr class='text-xl'>
                <td class='border-l-3 bg-gray-300 border-l-zinc-700 h-14 text-left p-3'><?php echo $i ?></td>
                <td class='h-14 bg-gray-200 text-left p-3'><?php echo $kandidat['nama']?></td>
                <td class='h-14 bg-gray-300 text-left p-3'><?php echo $kandidat['jumlahsuara']?></td>
                <td class='border-r-3 bg-gray-200 border-r-zinc-700 h-14 text-left p-3'>
                    <?php if($persen!=0){?>
                    <div class="text-base">
                        <?php echo round($persen,2)."%"?>
                    </div> 
                    <div class="pl-4 bg-blue-800 rounded-xl h-7" style="width: <?php echo round($persen,0).'%'?> ">
                    </div>
                    <?php ;}else{?>
                        <div>
                        <?php echo round($persen,2)."%"?>
                    </div>
                    <?php ;}?>
                </td>

			</tr>
            <?php ;}?>
            <?php $i++;};
		?>
	</tbody>
	</table>
	<div class="text-2xl mx-auto w-3/5 my-8">Total Suara: <?php echo $count[0] ?></div>
    <div class="h-32 bg-red"></div>
</body>