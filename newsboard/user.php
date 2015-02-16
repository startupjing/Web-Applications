<!DOCTYPE html>
<?php
session_start();
require 'database.php';
 

if(isset($_POST['form_type'])){

	//register a new user into databse
	if($_POST['form_type'] == 'signup'){
        
        //validate sign up information
		if(!isset($_POST['username']) || !isset($_POST['pwd']) || !isset($_POST['name'])
			|| strlen(trim($_POST['username']))==0 || strlen(trim($_POST['pwd']))==0 || strlen(trim($_POST['name']))==0){
	
		    printf("<h3>Required fields are empty</h3><a href='signup.php'>Go back</a>");

		}else{
			$signupUsername = $_POST['username'];

			$stmt = $mysqli->prepare("select username from user where username=?");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('s', $signupUsername);
			$stmt->execute();
			$stmt->bind_result($userexist);

			if($stmt->fetch()){
				printf("<h3>Duplicate username</h3><a href='signup.php'>Go back</a>");
			}
	        
            //encrypt password
			$signupPwd = crypt($_POST['pwd']);
			$signupName = $_POST['name'];
			$signupEmail = $_POST['email']; 
			 
			$stmt = $mysqli->prepare("insert into user (username, password, name, email) values (?, ?, ?, ?)");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			 
			$stmt->bind_param('ssss', $signupUsername, $signupPwd, $signupName, $signupEmail);
			$stmt->execute();
	        $stmt->close();
	       
	        printf("<h3>Sign up successfully</h3><a href='index.html'>Go back</a>");
	    }

	//handle user login
	}else if($_POST['form_type'] == 'login'){
		$loginUsername = $_POST['inputUsername'];

		$loginPwd = $_POST['inputPassword'];

		$stmt = $mysqli->prepare("select password from user where username=?");

		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}

		$stmt->bind_param('s', $loginUsername);
		$stmt->execute();
		$stmt->bind_result($hashedPassword);

        $stmt->fetch();

        //compare input password to hashed password
	   if(crypt($loginPwd, $hashedPassword) == $hashedPassword){
	   	  session_start();
	   	  $_SESSION['username'] = $loginUsername;
	   	  $_SESSION['token'] = substr(md5(rand()), 0, 10);
	   	  header("Location: person.php");
	   }else{
	
	   	  printf("<h3>Invalid login information</h3><a href='login.php'>Go back</a>");
	   }
		
    //update user profile
	}else if($_POST['form_type'] == 'updateUser'){
		if($_SESSION['token'] != $_POST['token']){
	       die("Request forgery detected");
        }
		
		$newPassword = crypt($_POST['updatePwd']);

		$stmt = $mysqli->prepare("update user set password=? where username=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt->bind_param('ss', $newPassword, $_SESSION['username']);
		$stmt->execute();
        $stmt->close();

       
        printf("<h3>Update successfully</h3><a href='person.php'>Go back</a>");
	}
}

 

 
?>