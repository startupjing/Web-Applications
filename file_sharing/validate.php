<?php
    //check login information
	if(isset($_POST['username']) && $_POST['username']!=''){
	   $username = $_POST['username'];
       if(validate($username)){
           header("Location: person.php");
       }else{
           header("Location: index.html");
       }
    //logout and destroy session
	}else if(isset($_SESSION['username'])){
	    session_destroy();
        header('Location: index.html');
        exit();
    }else{
	    header("Location: index.html");
	}

	//validate username
	function validate($username){
	    $userFile = fopen("/home/jinglu/userinfo/user.txt","r");
	    while(!feof($userFile)){
	       if(trim(fgets($userFile)) == $username){
	            session_start();
                $_SESSION['username'] = $username;
                fclose($userFile);
                return true;
	       }
	    }
	    return false;
	}	
?>
