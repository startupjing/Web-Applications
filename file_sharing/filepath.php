<?php 
session_start ();

// Get the filename and make sure it is valid
$filename = basename ($_FILES['uploadedfile']['name']);
if (!preg_match ('/^[\w_\.\-]+$/', $filename)){
    echo "Invalid filename";
    exit;
}

// Get the username and make sure it is valid
$username = $_SESSION['username'];
if (!preg_match ('/^[\w_\-]+$/', $username)){
    echo "Invalid username";
    exit;
}

$full_path = sprintf ("/home/jinglu/uploads/%s/%s", $username, $filename);

?>
