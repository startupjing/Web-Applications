<?php
	require 'database.php';

	//http-only session cookie
	ini_set("session.cookie_httponly", 1);
	session_start();
	header("Content-Type: application/json");
   
    //user login
	if($_POST['option'] == "login"){

		$loginUsername = $_POST['username'];
		$loginPwd = $_POST['password'];

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
			  $_SESSION['username'] = $loginUsername;

			  //create session token
			  $_SESSION['token'] = substr(md5(rand()), 0, 10);
			  echo json_encode(array("success" => true));
		      exit;
		}else{
		      echo json_encode(array("success" => false, "message" => "incorrect password or username"));
		      exit;
		}

	//check user login status
    }else if($_POST['option'] == "check_login"){
    	if(isset($_SESSION['username'])){
    		echo json_encode(array("success" => true,
    			                   "user" => $_SESSION['username'],
    			                   "token" => $_SESSION['token']));
    	}else{
    		echo json_encode(array("success" => false));
    	}
    
    //register a new user
    }else if($_POST['option'] == "register"){

    	//filter input
    	if(!isset($_POST['username']) || !isset($_POST['pwd']) || !isset($_POST['name'])
    		|| strlen(trim($_POST['username']))==0 || strlen(trim($_POST['pwd']))==0 || strlen(trim($_POST['name']))==0){
    		echo json_encode(array("success"=>false, "message"=>"Required fields are empty"));
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

	    	//check duplicate username
	    	if($stmt->fetch()){
	    		echo json_encode(array("success"=>false, "message"=>"Duplicate username exists"));
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

	    	echo json_encode(array("success" => true));

	    }

	//user logout
    }else if($_POST['option'] == "logout"){
    	//destroy sessions
        unset($_SESSION['username']);
        unset($_SESSION['token']);
        echo json_encode(array("success" => true));

    //find users
    }else if($_POST['option'] == "find_user"){
    	$result = "";
    	$self = $_SESSION['username'];
    	$stmt = $mysqli->prepare("select username from user where username != ?");
    	if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				echo json_encode(array(
					"success" => false,
					"message" => "database error"
					));
				exit;
			}

			$stmt->bind_param('s', $self);            
			$stmt->execute();     
			$stmt->bind_result($user_result);


			while($stmt->fetch()){
				$result .= sprintf("<option value='%s'> %s </option>",
											htmlspecialchars($user_result),
											htmlspecialchars($user_result));
			}

			echo json_encode(array(
					"success" => true,
			        "users" => $result
			));
			$stmt->close();
			exit;

     //get session token
    }else if($_POST['option'] == 'get_token'){
    	if(isset($_SESSION['username']) && isset($_SESSION['token'])){
    		echo json_encode(array(
    			"success" => true,
    			"token" => $_SESSION['token']
    		));
    	}else{
    		echo json_encode(array("success"=>false));
    	}
    }

?>