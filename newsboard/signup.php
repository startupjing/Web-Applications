<!DOCTYPE html>
<html lang="en">

  <head>
     <title>Signup</title>
     <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
     <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
  </head>

  <body>
  	<div class="container">
        

       <!--  sign-up form -->
	  	<form class="form-signup" action="user.php" method="POST">
	  		<h2 class="form-signup-heading">Please enter required information: </h2>

	  		<input type="hidden" name="form_type" value="signup"/>

	  		<div class="form-group">
	  			<label for="username">Username</label>
	  			<input type="text" class="form-control" name="username" id="username" placeholder="Username">
	  		</div>

	  		<div class="form-group">
	  			<label for="pwd">Password</label>
	  			<input type="password" class="form-control" name="pwd" id="pwd" placeholder="Password">
	  		</div>

	  		

	  		<div class="form-group">
	  			<label for="name">Name</label>
	  			<input type="text" class="form-control" name="name" id="name" placeholder="Name">
	  		</div>

	  		<div class="form-group">
	  			<label for="email">Email</label>
	  			<input type="text" class="form-control" name="email" id="email" placeholder="Email address">
	  		</div>

	  		<button type="submit" class="btn btn-default">Sign up</button>
	  		<button type="reset" class="btn btn-default">Reset</button>
	  	</form>
        
        <p>Register user? Log in <a href="login.php">here</a></p>
	  	<a href="index.html">Back to home page</a>
    </div>
  </body>

  