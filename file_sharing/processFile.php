<?php
session_start();

$full_path = sprintf("/home/jinglu/uploads/%s/%s", $_SESSION['username'], $_POST['info']);

//open file
if(isset($_POST['open'])){
  	$finfo = new finfo(FILEINFO_MIME_TYPE);
  	$mime = $finfo->file($full_path);
  	header("Content-Type: ".$mime);
  	readfile($full_path);
//delete file
}else if(isset($_POST['delete'])){
    unlink($full_path);
    echo sprintf('File %s deleted successfully', $_POST['info']);
    echo sprintf('<br /> <a href="file.php">Back</a>');
//share file to other user
}else if(isset($_POST['share']) && isset($_POST['shareto']) && !empty($_POST['shareto'])){
    $target =  sprintf("/home/jinglu/uploads/%s/%s", $_POST['shareto'], $_POST['info']);
    copy($full_path, $target);
    echo sprintf('File %s shared successfully', $_POST['info']);
    echo sprintf('<br /> <a href="file.php">Back</a>');   
}else{
	  header("Location: file.php");
}

?>
