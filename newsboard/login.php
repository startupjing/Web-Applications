<!DOCTYPE html>
<html lang="en">

  <head>
     <title>Login</title>
     <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
     <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
  </head>
  
  <!-- login form -->
  
  <body>
  	<div class="container">
      <form class="form-signin" action="user.php" method="POST">
          <h2 class="form-signin-heading">Please sign in</h2>
        
          <input type="hidden" name="form_type" value="login"/>

          <label for="inputUsername" class="sr-only">Username</label>
          <input type="text" name="inputUsername" id="inputUsername" class="form-control" placeholder="Username" required autofocus>

          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
          <br />
          <button class="btn btn-primary" type="submit">Sign in</button>
      </form>

      <a href="signup.php">New user?</a>
      <br />
      <a href="index.html">Back to home page</a>

    </div> 
 </body>