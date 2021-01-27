# Trecias-sprintas

//prisijungimas prie DB
	$obj->host = 'localhost';
	$obj->username = 'root';
	$obj->password = 'mysql';
	$obj->db_name = 'minitvs';
	$obj->table = 'duomenys';
	$conn = $obj->connect();
	$obj->buildDB($conn);
	?>
  
  
