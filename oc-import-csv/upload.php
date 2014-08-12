<?php
if (!file_exists('upload')) {
	if (!mkdir('upload', 0777, true)) {
		die("ERROR CREATING UPLOAD FOLDER");
	}
}

$mimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
if (in_array($_FILES['file']['type'], $mimes)) {
	if ($_FILES["file"]["error"] > 0) {
		die("Return Code: ".$_FILES["file"]["error"]."<br>");
	} else {
		//		echo "Upload: ".$_FILES["file"]["name"]."<br>";
		//		echo "Type: ".$_FILES["file"]["type"]."<br>";
		//		echo "Size: ".($_FILES["file"]["size"]/1024)." kB<br>";
		if (file_exists("upload/".$_FILES["file"]["name"])) {
			echo "exi";
			unlink("upload/".$_FILES["file"]["name"]);
		}
		if (!move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$_FILES["file"]["name"])) {
			die('cannot upload file');
		}

		//		echo "Stored in: "."upload/".$_FILES["file"]["name"];

	}

} else {
	die("Sorry, mime type not allowed");
}
header("location: index.php");
?>