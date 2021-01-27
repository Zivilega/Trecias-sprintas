<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>SPRINT 3: primityvi TVS</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

	<?php

	include_once('_class/simpleCMS.php');
	$obj = new simpleCMS();

	//prisijungimas prie DB
	$obj->host = 'localhost';
	$obj->username = 'root';
	$obj->password = 'mysql';
	$obj->db_name = 'minitvs';
	$obj->table = 'duomenys';
	$conn = $obj->connect();
	$obj->buildDB($conn);
	?>

	<div align="center">
		</br>
		<h1>Mini turinio valdymo sistema</h1>
		<p>
			Atliko: Živilė Bataitė.
			<?php echo ' PHP versija: ' . phpversion(); ?>
			<?php printf(", MySQL serverio versija: %s\n", mysqli_get_server_info($conn)); ?>.
		</p>
	</div>

	<div id="page-wrap">
		<?php

		// jei buvo ivesti duomenys formoje, vykdome irasyma i DB
		if ($_POST)
			$obj->write($conn);

		//jei buvo paspaustas istrynimo mygtukas, vykdome trynima DB
		$del = !empty($_GET['delete']) ? $_GET['delete'] : 0;
		if ($del <> 0)
			$obj->delete($conn);

		$adm = !empty($_GET['admin']) ? $_GET['admin'] : 0;
		if ($adm == 1)
			echo $obj->display_admin();
		else
			echo $obj->display_public($conn);

		mysqli_close($conn);
		?>
	</div>

	<p align="center">SPRINT 3: 2021</p>
	</br>

</body>

</html>