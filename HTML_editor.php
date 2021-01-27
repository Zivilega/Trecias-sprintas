<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<title>WYSIWYG HTML editorius</title>
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
	<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
	<div align="center">
		</br>
		<h1>Mini turinio valdymo sistema</h1>
		<p>Atliko: Živilė Bataitė</p>
	</div>

	<div id="page-wrap">
    <form name="forma" action="display.php" method="post" onsubmit="return validateForm()">
      <label for="title">Pavadinimas:</label><br />
      <input name="title" id="title" type="text" maxlength="150" />
      <div class="clear"></div>
      <label for="bodytext">Žinutė:</label><br />
      <textarea name="bodytext" id="bodytext"></textarea>
      <div class="clear"></div>
      
      <input type="submit" value="Išsaugoti įrašą!" />&nbsp;&nbsp;
	  <input type="button" onclick="location.href='display.php?admin=1';" value="PLAIN TEXT redaktorius" />&nbsp;&nbsp;
	  <input type="button" onclick="location.href='display.php';" value="Grįžti į pradžią" />
    </form>
    <br />
	</div>
  
</body>
</html>

