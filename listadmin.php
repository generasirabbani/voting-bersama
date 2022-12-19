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

    <div class="h-44"></div>

    <?php
    $lines = pg_fetch_array(pg_query("SELECT count(*) from useradmin where token = '".$_SESSION['token']."'"));
    echo $lines[0];
    ?>

    <table class="w-2/5 mx-auto text-xl">
	<thead>
        <tr class='text-xl'>
            <th class="bg-zinc-400 border-y-3 border-l-3 border-y-zinc-700 border-l-zinc-700 h-14 text-left p-3">No</th>
            <th class="bg-zinc-400 border-y-3 border-y-zinc-700 h-14 text-left p-3">Nama</th>
            <th class="bg-zinc-400 border-y-3 border-r-3 border-y-zinc-700 border-r-zinc-700 h-14 text-left p-3">Asal</th>
        </tr>
	</thead>
	<tbody>
		<?php
        $i = 1;
		$query = pg_query("SELECT * FROM useradmin where token = '".$_SESSION['token']."' order by namaadmin asc");
		while($useradmin = pg_fetch_array($query)){?>
            <?php if($i==$lines[0]){?>
                <tr class='text-xl'>
                    <td class='border-b-3 border-l-3 bg-gray-300 border-zinc-700 h-14 text-left p-3'><?php echo $i?></td>
                    <td class='border-b-3 h-14 bg-gray-200 border-zinc-700 text-left p-3'><?php echo $useradmin['namaadmin']?></td>
                    <td class='border-b-3 border-r-3 bg-gray-300 border-zinc-700 h-14 text-left p-3'><?php echo $useradmin['asal']?></td>
                </tr>
            <?php }else{?>
                <tr class='text-xl'>
                    <td class='border-l-3 bg-gray-300 border-l-zinc-700 h-14 text-left p-3'><?php echo $i?></td>
                    <td class='h-14 bg-gray-200 text-left p-3'><?php echo $useradmin['namaadmin']?></td>
                    <td class='border-r-3 bg-gray-300 border-r-zinc-700 h-14 text-left p-3'><?php echo $useradmin['asal']?></td>
                </tr>
            <?php ;} $i++;
			};
		?>
	</tbody>
	</table>
</body>