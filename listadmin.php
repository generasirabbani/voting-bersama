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

	<table border="1">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Asal</th>
		</tr>
	</thead>
	<tbody>
		<?php
        $i = 1;
		$query = pg_query("SELECT * FROM useradmin where token = '".$_SESSION['token']."' order by namaadmin asc");
		while($useradmin = pg_fetch_array($query)){
            echo "<tr>";
			echo "<td>".$i."</td>";
			echo "<td>".$useradmin['namaadmin']."</td>";
			echo "<td>".$useradmin['asal']."</td>";
            $i++;
			}
			echo "</tr>";
		?>
	</tbody>
	</table>
</body>
