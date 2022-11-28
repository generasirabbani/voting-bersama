<?php
    include("config.php");
    session_start();
    if(!isset($_SESSION['email'])&&!isset($_SESSION['username'])){
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
        <?php
        if(isset($_SESSION['email'])){;
        ?>
		<div class="main">
		<ul class="navbar">
            <li><a href="beranda.php" class="dropdown">Home</a></li>
            <li><a href="livecount.php" class="tombolLogout">Live Count</a></li>		
        </ul>
            <a href="logout.php" class="tombolLogout">Log out</a>
		</div>
        <?php }elseif(isset($_SESSION['username'])){; ?>
        <div class="main">
        <ul class="navbar">
            <li><a href="berandaadmin.php" class="dropdown">Home</a></li>
            <li><a href="tambahkandidat.php">Tambah kandidat </a></li>
            <li><a href="livecount.php">Live Count </a></li>	
        </ul>
            <p>|</p>
            <a href="logout.php" class="tombolLogout">Log out</a>
		</div>
        <?php }; ?>
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
			<th>Suara</th>
			<th>suara dalam persen</th>
		</tr>
	</thead>
	<tbody>
		<?php
        $i = 1;
		$query = pg_query("SELECT * FROM kandidat where token = '".$_SESSION['token']."' order by nama asc");
        $count = pg_query("SELECT SUM(jumlahsuara) FROM kandidat");
        $count = pg_fetch_array($count);
		while($kandidat = pg_fetch_array($query)){
			$persen = 100.0*$kandidat['jumlahsuara']/$count[0];
            echo "<tr>";
			echo "<td>".$i."</td>";
			echo "<td>".$kandidat['nama']."</td>";
			echo "<td>".$kandidat['jumlahsuara']."</td>";
			echo "<td>".round($persen,2)."%</td>";
			}
			echo "</tr>";
		?>
	</tbody>
	</table>
	<p>Total Suara: <?php echo $count[0] ?></p>
</body>