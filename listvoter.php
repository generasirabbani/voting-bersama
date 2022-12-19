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
    <title>List Voter</title>
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
    $lines = pg_fetch_array(pg_query("SELECT count(*) from pengguna where token = '".$_SESSION['token']."'"));
    echo $lines[0];
    ?>

	<table class="w-2/5 mx-auto text-xl">
	<thead class="text-zinc-800">
		<tr>
            <th class="bg-zinc-400 border-y-3 border-l-3 border-y-zinc-700 border-l-zinc-700 h-14 text-left p-3">No</th>
            <th class="bg-zinc-400 border-y-3 border-y-zinc-700 h-14 text-left p-3">Nama</th>
            <th class="bg-zinc-400 border-y-3 border-y-zinc-700 h-14 text-left p-3">Email</th>
            <th class="bg-zinc-400 border-y-3 border-r-3 border-y-zinc-700 border-r-zinc-700 h-14 text-left p-3">Block Voter</th>
		</tr>
	</thead>
	<tbody>
		<?php
        $i = 1;
		$query = pg_query("SELECT * FROM pengguna where token = '".$_SESSION['token']."' order by nama asc");
		while($pengguna = pg_fetch_array($query)){?>
            <?php if($i==$lines[0]){?>
                <tr class='text-xl'>
                    <td class='border-b-3 border-l-3 bg-gray-300 border-zinc-700 h-14 text-left p-3'><?php echo $i ?></td>
                    <td class='border-b-3 h-14 bg-gray-200 border-zinc-700 text-left p-3'><?php echo $pengguna['nama']?></td>
			        <td class='border-b-3 h-14 bg-gray-300 border-zinc-700 text-left p-3'><?php echo $pengguna['email']?></td>
                    <?php if($pengguna['block']== 'f'){;?>
                        <form action = "" method = "POST">
                            <td class='border-b-3 border-r-3 bg-gray-200 border-zinc-700 h-14 text-left p-3'><input type="submit" name="block" class="login login-submit px-4 py-2 bg-red-600 rounded-xl text-slate-100" value="Block"></td>
                        </form>
                        <?php if(isset($_POST['block'])&&!empty($_POST['block'])){
                            $ID = $pengguna['email'];
                            $pilih = $pengguna['pilih'];
                            $cek = $pengguna['cek'];
                            if($cek == 't'){
                                $query = pg_query("UPDATE kandidat SET jumlahsuara= jumlahsuara - 1 WHERE idkandidat='$pilih'");
                            }
                            $query = pg_query("UPDATE pengguna SET block = 'TRUE' WHERE email='$ID'");
                            if($query){
                                header('Location: listvoter.php');
                            }
                            else{
                                die("gagal");
                            }
                        }
                    }else{;?>
                        <form action = "" method = "POST">
                            <td class='border-b-3 border-r-3 bg-gray-200 border-zinc-700 h-14 text-left p-3'><input type="submit" name="unblock" class="login login-submit px-4 py-2 bg-red-600 rounded-xl text-slate-100" value="Unblock"></td>
                        </form>
                        <?php if(isset($_POST['unblock'])&&!empty($_POST['unblock'])){
                            $ID = $pengguna['email'];
                            $pilih = $pengguna['pilih'];
                            $cek = $pengguna['cek'];
                            if($cek == 't'){
                                $query = pg_query("UPDATE kandidat SET jumlahsuara= jumlahsuara + 1 WHERE idkandidat='$pilih'");
                            }
                            $query = pg_query("UPDATE pengguna SET block = 'FALSE' WHERE email='$ID'");
                            if($query){
                                header('Location: listvoter.php');
                            }
                            else{
                                die("gagal");
                            }
                        }
                    }?>
                </tr>
            <?php }else{?>
                <tr class='text-xl'>
                    <td class='border-l-3 bg-gray-300 border-l-zinc-700 h-14 text-left p-3'><?php echo $i ?></td>
                    <td class='h-14 bg-gray-200 text-left p-3'><?php echo $pengguna['nama']?></td>
			        <td class='h-14 bg-gray-300 text-left p-3'><?php echo $pengguna['email']?></td>
                    <?php if($pengguna['block']== 'f'){;?>
                        <form action = "" method = "POST">
                            <td class='border-r-3 bg-gray-200 border-r-zinc-700 h-14 text-left p-3'><input type="submit" name="block" class="login login-submit px-4 py-2 bg-red-700 rounded-xl text-slate-100" value="Block"></td>
                        </form>
                        <?php if(isset($_POST['block'])&&!empty($_POST['block'])){
                            $ID = $pengguna['email'];
                            $pilih = $pengguna['pilih'];
                            $cek = $pengguna['cek'];
                            if($cek == 't'){
                                $query = pg_query("UPDATE kandidat SET jumlahsuara= jumlahsuara - 1 WHERE idkandidat='$pilih'");
                            }
                            $query = pg_query("UPDATE pengguna SET block = 'TRUE' WHERE email='$ID'");
                            if($query){
                                header('Location: listvoter.php');
                            }
                            else{
                                die("gagal");
                            }
                        }
                    }else{;?>
                        <form action = "" method = "POST">
                            <td><input type="submit" name="unblock" class="login login-submit px-4 py-2 bg-red-700 rounded-xl text-slate-100" value="Unblock"></td>
                        </form>
                    <?php 
                        if(isset($_POST['unblock'])&&!empty($_POST['unblock'])){
                            $ID = $pengguna['email'];
                            $pilih = $pengguna['pilih'];
                            $cek = $pengguna['cek'];
                            if($cek == 't'){
                                $query = pg_query("UPDATE kandidat SET jumlahsuara= jumlahsuara + 1 WHERE idkandidat='$pilih'");
                            }
                            $query = pg_query("UPDATE pengguna SET block = 'FALSE' WHERE email='$ID'");
                            if($query){
                                header('Location: listvoter.php');
                            }
                            else{
                                die("gagal");
                            }
                        }
                    }?>
                </tr>
            <?php ;} $i++;
			}
			;
		?>
	</tbody>
	</table>
    <div class="h-32 bg-red"></div>
</body>