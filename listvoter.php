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

	<table border="1">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Email</th>
			<th>Block Voter</th>
		</tr>
	</thead>
	<tbody>
		<?php
        $i = 1;
		$query = pg_query("SELECT * FROM pengguna where token = '".$_SESSION['token']."' order by nama asc");
		while($pengguna = pg_fetch_array($query)){
            echo "<tr>";
			echo "<td>".$i."</td>";
			echo "<td>".$pengguna['nama']."</td>";
			echo "<td>".$pengguna['email']."</td>";
            if($pengguna['block']== 'f'){;?>
            <form action = "" method = "POST">
            <td><input type="submit" name="block" class="login login-submit" value="Block"></td>
            </form>
            <?php 
                if(isset($_POST['block'])&&!empty($_POST['block'])){
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
            <td><input type="submit" name="unblock" class="login login-submit" value="Unblock"></td>
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
            }
            $i++;
			}
			echo "</tr>";
		?>
	</tbody>
	</table>
</body>
