<?php

//build connection to databse

$mysqli = new mysqli('localhost', 'jinglu', 'Zheng1109', 'newsboard');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>