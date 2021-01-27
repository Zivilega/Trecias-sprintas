<?php

class simpleCMS {

  var $host;
  var $username;
  var $password;
  var $db_name;
  var $table;

  
  public function display_public($link) {
    $q = "SELECT * FROM " . $this->table . " ORDER BY created DESC";
    $r = mysqli_query($link, $q);
	$edit = !empty($_GET['edit'])?$_GET['edit']:0;
	if ($edit == 1)
	{
		$hid1 = 'hidden';
		$hid2 = '';
	}
	else
	{
		$hid1 = '';
		$hid2 = 'hidden';
	}
	
    $entry_display = <<<ADMIN_OPTION
			<p class="admin_link" align="right">
			  <a href="{$_SERVER['PHP_SELF']}?admin=1">Pridėti naują įrašą</a> 
			  <span $hid1> | <a href="{$_SERVER['PHP_SELF']}?edit=1">Įjungti redagavimą</a></span>
			  <span $hid2> | <a href="{$_SERVER['PHP_SELF']}">Išjungti redagavimą</a></span>
			</p>
ADMIN_OPTION;

    if ( $r !== false && mysqli_num_rows($r) > 0 )
	{
      while ( $a = mysqli_fetch_assoc($r) )
	  {
        $title = stripslashes($a['title']);
        $bodytext = stripslashes($a['bodytext']);
		$created = stripslashes($a['created']);
		if ($edit)
			$del = "<span><a href=" . $_SERVER['PHP_SELF'] . "?edit=1&delete=" . $created . "><img src='delete.png' width=15 border=0></a></span>";
		else
			$del = '';
        $entry_display .= <<<ENTRY_DISPLAY
			<div class="post">
				<h2>
					$title $del
				</h2>
				<p>
				  $bodytext
				</p>
			</div>
ENTRY_DISPLAY;
      }
    }
	else
	{
      $entry_display .= <<<ENTRY_DISPLAY
			<h2> Puslapis - kuriamas. </h2>
			<p>
			  Nėra jokių įrašų DB. Patikrinkite ar reikiama DB sukurta serveryje!
			</p>
			</br>
ENTRY_DISPLAY;
    }


    return $entry_display;
  }

  
  public function display_admin() {
    return <<<ADMIN_FORM
	<script>
		function validateForm() {
			var x = document.forms["forma"]["title"].value;
			var y = document.forms["forma"]["bodytext"].value;
			if (x == "" || y == "") {
				alert("Formos laukai turi būti užpildyti!");
				return false;
			}
		}
	</script>
    <form name="forma" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="return validateForm()">
      <label for="title">Pavadinimas:</label><br />
      <input name="title" id="title" type="text" maxlength="150" />
      <div class="clear"></div>
      <label for="bodytext">Žinutė:</label><br />
      <textarea name="bodytext" id="bodytext"></textarea>
      <div class="clear"></div>
      <input type="submit" value="Išsaugoti įrašą!" />&nbsp;&nbsp;
	  <input type="button" onclick="location.href='HTML_editor.php';" value="WYSIWYG HTML redaktorius" />&nbsp;&nbsp;
	  <input type="button" onclick="location.href='display.php';" value="Grįžti į pradžią" />
    </form>
    <br />

ADMIN_FORM;
  }

  
  public function write($link) {
    if ( $_POST['title'] )
      $title = mysqli_real_escape_string($link, $_POST['title']);
    if ( $_POST['bodytext'])
      $bodytext = mysqli_real_escape_string($link, $_POST['bodytext']);
    if ( $title && $bodytext ) {
      $created = time();
      $sql = "INSERT INTO " . $this->table . " VALUES('$title','$bodytext','$created')";
      return mysqli_query($link, $sql);
    } else {
      return false;
    }
  }

  
  public function delete($link) {
      $id = $_GET['delete'];
      $sql = "DELETE FROM " . $this->table . " WHERE created = " . $id;
      return mysqli_query($link, $sql);
  }

  
  public function connect() {
    $link = mysqli_connect($this->host,$this->username,$this->password);
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Neįmanoma prisijungti prie DB serverio: %s\n", mysqli_connect_error());
		exit();
	}
    //mysql_select_db($this->db_name) or die("Nerasata duomenų bazė: " . mysql_error());

	//jei nera sukurta DB, pirmojo paleidimo metu sukuriam ja
	$sql = "CREATE DATABASE IF NOT EXISTS " . $this->db_name;
	mysqli_query($link, $sql) or die("Neimanoma sukurti duomenų bazės '" . $this->db_name .  "': %s\n" . mysqli_error($link));
	
	//patikrinam ar pavyko prisijungti prie nurodytos DB
	$db = mysqli_select_db($link, $this->db_name);
	if (!$db) {
		die ('Nerasta duomenų bazė: ' . mysqli_error($link));
    }

    return $link;
  }

  
  public function buildDB($link) {

	$sql = <<<MySQL_QUERY
			CREATE TABLE IF NOT EXISTS $this->table (
			title		VARCHAR(150),
			bodytext	TEXT,
			created		VARCHAR(100)
			)
MySQL_QUERY;
	
	mysqli_query($link, $sql) or die("Neimanoma sukurti lentelės: '" . $this->table .  "': %s\n" . mysqli_error($link));
	
    return 1;
  }

}

?>