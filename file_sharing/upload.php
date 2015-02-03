<?php
require('filepath.php');

//upload file
if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
	header("Location: file.php");
	exit;
}else{
    echo sprintf("%s", htmlentities($full_path));
	exit;
}
?>
