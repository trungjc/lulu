<?php
if (isset($_GET['rf'])) {
	unlink('upload/'.$_GET['rf']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IMPORT CSV DATA 2 OPENCART</title>
</head>
<body>
<center>
	<h1>Upload CSV FILE</h1>
	<table>
		<tr>
			<td>
				<form action="upload.php" method="post" enctype="multipart/form-data">
					<label for="file">Filename:</label>
					<input type="file" name="file" id="file"><br>
					<input type="submit" name="submit" value="Submit">
				</form>
			</td>
		</tr>

	</table>
</center>
<h1>Click files To Import</h1>

<?php
if ($handle = opendir('upload')) {

	while (false !== ($entry = readdir($handle))) {

		if ($entry != "." && $entry != "..") {

			echo "<a href='options.php?file=$entry' target='_blank'>$entry</a> | <a href='index.php?rf=$entry'>Remove</a><br/>";
		}
	}

	closedir($handle);
}
?>


</body>
</html>