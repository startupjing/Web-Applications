<?php
	session_start();
?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>File Sharing</title>
	<link rel="stylesheet" type="text/css" href="mainstyle.css"/>
</head>

<body>
<div id="content">

<?php
   printf("<p> Hello %s</p>", htmlentities($_SESSION['username']));
?>


<p>
<form action="file.php" method="POST">
	<p><input type="submit" value = "files"/></p>
</form>
</p>


<p>
<form action="validate.php" method="POST">
	<p><input type="submit" value = "logout"/></p>
</form>
</p>

<p><strong> Do you want to change your username?</strong></p>

<?php
	printf("<p> Your current username is %s</p>",htmlentities($_SESSION['username']));
?>


<p>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
	<p>
		<label for="altername">Your new username:</label>
		<input type="text" name="altername" id="altername" />
		<input type="submit" value="update" />
	</p>

</form>
</p>
 
<?php
if(isset($_POST['altername'])){
    if( !preg_match('/^[\w_\-]+$/', $_POST['altername']) ){
        printf("<p><strong>Invalid username</strong></p>");
    }else{
	    $altername = $_POST['altername'];
	    update_userlist($altername);
	    update_userdir($altername);
	    printf("<p><strong>Now your username is changed to %s</strong></p>\n",
		       htmlentities($_POST['altername']));
   }
}

//update username in user.txt
function update_userlist($altername){
	$userlist = file_get_contents("/home/jinglu/userinfo/user.txt");
	$updated_userlist = str_replace($_SESSION['username'], $altername, $userlist);
    file_put_contents("/home/jinglu/userinfo/user.txt",$updated_userlist);
}

//make new upload folder for new user
function update_userdir($altername){
	$dirPath = sprintf("/home/jinglu/uploads/%s", $_SESSION['username']);
	$newDir = sprintf("/home/jinglu/uploads/%s", $altername);
	rename($dirPath, $newDir);
    $_SESSION['username'] = $altername;
}
?>

</div>
</body>
</html>
