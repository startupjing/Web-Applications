<!DOCTYPE html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title>Sign Up</title>
   <link rel="stylesheet" type="text/css" href="mainstyle.css"/>
</head>

<body>
<div id="content">
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
	 <p>
		  <label for="newname">username:</label>
		  <input type="text" name="newname" id="newname" />
	 </p>
	 <p>
		 <input type="submit" value="register" />
	</p>
</form>

 
<?php
if(isset($_POST['newname']) && $_POST['newname']!=''){
    include 'validate.php';
    //check if a user already exists
    if(!preg_match('/^[\w_\.\-]+$/', $_POST['newname']) || validate($_POST['newname'])){
	    header("Location: signup.php");
    //register a new user
    }else{
        $userFile = fopen("/home/jinglu/userinfo/user.txt","a+");
        fwrite($userFile,$_POST['newname']);
        fwrite($userFile,"\n");
        fclose($userFile);
        $userDir = sprintf("/home/jinglu/uploads/%s", $_POST['newname']);
        mkdir($userDir);
        chmod($userDir,0777);
   }
}
?>

</div>
</body>
</html>

