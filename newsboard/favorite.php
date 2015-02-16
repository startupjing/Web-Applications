<!DOCTYPE html>
<?php
  session_start();
  require 'database.php';
  

  //print navigation bar based on if use is logged in
  printf(' 
  	<head>
     <title>My Favorite</title>
     <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
     <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="mainstyle.css"/>
     <script src="http://code.jquery.com/jquery-latest.js"></script>
     <script src="assets/js/bootstrap.min.js"></script>
     <script src="assets/js/app.js"></script>
   </head>');
  if(isset($_SESSION['username'])){
	printf('<div class="navbar navbar-inverse">
    <div class="navbar-inner">
       <a class="brand" href="person.php">Personal Page</a>
       <ul class="nav nav-pills">
          <li role="presentation"><a href="person.php?option=profile">Profile</a></li>
           <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">Category<b class="caret"></b></a>  
             <ul class="dropdown-menu">
                <li><a href="story.php?cat=education">education</a></li>
                <li><a href="story.php?cat=entertainment">entertainment</a></li>
                <li><a href="story.php?cat=life">life</a></li>
                <li><a href="story.php?cat=politics">politics</a></li>
                <li><a href="story.php?cat=society">society</a></li>
                <li><a href="story.php?cat=sports">sports</a></li>
                <li><a href="story.php?cat=technology">technology</a></li>
                <li><a href="story.php?cat=travel">travel</a></li>
             </ul>
        </li>
          <li role="presentation"><a href="person.php?option=story">My Stories</a></li>
          <li role="presentation"><a href="person.php?option=comment">My Comments</a></li>

          
        <li><a href="favorite.php?show=story">Favorite Story</a></li>
        <li><a href="favorite.php?show=category">Favorite Category</a></li>
        <li><a href="favorite.php?show=user">Favorite User</a></li>
            
       </ul>
       
       <form action="search.php" class="navbar-search offset1" method="post">
             <input type="text" name ="target" class="search-query" placeholder="Search">
             <input type="hidden" name="token" value=%s>
              <select name="searchRange">
              <option value="user">User</option>
              <option value="story">Story</option>
              <option value="comment">Comment</option>
              </select>
              <button type="submit" class="btn btn-default">Search</button>
       </form>
       
       <div class="btn-group pull-right">
          <form action="storyEdit.php" method="POST">
                   <input type="hidden" name="form_type" value="post" />
                   <button type="submit" class="btn btn-primary">Post story</button>
          </form>
          <a href="logout.php" class="btn btn-success">Logout</a>
       </div>
    
      </div>
    </div>', $_SESSION['token']);


}else{
	printf('<div class="navbar navbar-inverse">
    <div class="navbar-inner">
       <a class="brand" href="index.html">NewsBoard</a>
       <ul class="nav nav-pills">
          <li role="presentation" class="active"><a href="story.php?cat=education">education</a></li>
          <li role="presentation"><a href="story.php?cat=entertainment">entertainment</a></li>
          <li role="presentation"><a href="story.php?cat=life">life</a></li>
          <li role="presentation"><a href="story.php?cat=technology">technology</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">More<b class="caret"></b></a>  
             <ul class="dropdown-menu">
                <li><a href="story.php?cat=politics">politics</a></li>
                <li><a href="story.php?cat=society">society</a></li>
                <li><a href="story.php?cat=sports">sports</a></li>
                <li><a href="story.php?cat=travel">travel</a></li>
             </ul>
        </li>
       </ul>
       
       <form action="search.php" class="navbar-search offset1" method="post">
             <input type="text" name ="target" class="search-query" placeholder="Search">
              <select name="searchRange">
              <option value="user">User</option>
              <option value="story">Story</option>
              <option value="comment">Comment</option>
              </select>
              <button type="submit" class="btn btn-default">Search</button>
       </form>
       
       <div class="btn-group pull-right">
          <a href="signup.php" class="btn btn-primary">Sign Up</a>
          <a href="login.php" class="btn btn-success">Login</a>
       </div>
      
      </div>
    </div>');
    
}

 

  
  if(isset($_POST['form_type'])){
  	    $currentUser = $_SESSION['username'];
        
        //add liked category to favorite collections
		if($_POST['form_type'] == 'likeCategory'){
			$likeCatName = $_POST['likeCatName'];
			$stmt = $mysqli->prepare("insert into favorite (follower, cat_name) values (?, ?)");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			 
			$stmt->bind_param('ss', $currentUser, $likeCatName);
			$stmt->execute();
	        $stmt->close();
	        
	        printf("<h3>Category added to favorite succesfully</h3><a href='person.php'>Go back</a>");
        
        //add liked story to favorite collections
		}else if($_POST['form_type'] == 'likeStory'){
			$likeStoryId = $_POST['likeStoryId'];
			$stmt = $mysqli->prepare("insert into favorite (follower, story_id) values (?, ?)");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			 
			$stmt->bind_param('ss', $currentUser, $likeStoryId);
			$stmt->execute();
	        $stmt->close();

	        printf("<h3>Story added to favorite succesfully</h3><a href='person.php'>Go back</a>");
        
        //add followed users to favorite collections
		}else if($_POST['form_type'] == 'likeUser'){
			$likeUsername = $_POST['likeUsername'];
			$stmt = $mysqli->prepare("insert into favorite (follower, username) values (?, ?)");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			 
			$stmt->bind_param('ss', $currentUser, $likeUsername);
			$stmt->execute();
	        $stmt->close();

	        printf("<h3>User added to favorite succesfully</h3><a href='person.php'>Go back</a>");

		}
  }

  //show favorite collections
  if(isset($_GET['show'])){
  	      printf("<div id='content'>");

  	      //show favorite stories in collection
	  	if($_GET['show'] == 'story'){
	  	  	$stmt = $mysqli->prepare("select favorite.story_id, title, story.username, post_time
	  	  		     from favorite join story on (favorite.story_id=story.story_id)
	  	  		     where follower=?");

		    if(!$stmt){
		      printf("Query Prep Failed: %s\n", $mysqli->error);
		      exit;
		    }

		    $stmt->bind_param('s', $_SESSION['username']);            
		    $stmt->execute();     
		    $stmt->bind_result($favoriteStoryId, $favoriteStoryTitle, $storyAuthor, $storyTime);
		    
		    
		    while($stmt->fetch()){
		      printf("<ul class='list-group'>\n
		      	        \t
		      	        <li class='list-group-item'>Title: %s</li>
		                <li class='list-group-item'>Author: %s</li>
		                <li class='list-group-item'>Time: %s</li>
		                <form action='storyComment.php' method='POST'>
		                   <input type='hidden' name='storyId' value=%s />
		                   <input type='hidden' name='token' value=%s />
		                   <button type='submit' class='btn btn-primary'>Read more</button>
		                </form>\n
		                </ul>\n\n",
		         htmlspecialchars($favoriteStoryTitle),
		         htmlspecialchars($storyAuthor),
		         htmlspecialchars($storyTime),
		         htmlspecialchars($favoriteStoryId),
		         $_SESSION['token']
		      );
	        }
	        	   
	        $stmt->close();

       //show favorite categories in collection
  	  }else if($_GET['show'] == 'category'){
	  	  	$stmt = $mysqli->prepare("select favorite.cat_name, description
	  	  		     from favorite join category on (favorite.cat_name=category.cat_name)
	  	  		     where follower=?");

		    if(!$stmt){
		      printf("Query Prep Failed: %s\n", $mysqli->error);
		      exit;
		    }

		    $stmt->bind_param('s', $_SESSION['username']);            
		    $stmt->execute();     
		    $stmt->bind_result($favoriteCatname, $catDescription);
		    
		    
		    while($stmt->fetch()){
		      printf("<ul class='list-group'>\n
		      	        \t
		      	        <li class='list-group-item'>Category: <a href='story.php?cat=%s'>%s</a></li>
		                <li class='list-group-item'>Description: %s</li>\n
		                </ul>\n\n",
		         htmlspecialchars($favoriteCatname),
		         htmlspecialchars($favoriteCatname),
		         htmlspecialchars($catDescription)
		      );
	        }
	        
	   
	        $stmt->close();
      
      //show followed users in collection
  	  }else if($_GET['show'] == 'user'){
	  	  	$stmt = $mysqli->prepare("select favorite.username
	  	  		     from favorite join user on (favorite.username=user.username)
	  	  		     where follower=?");

		    if(!$stmt){
		      printf("Query Prep Failed: %s\n", $mysqli->error);
		      exit;
		    }

		    $stmt->bind_param('s', $_SESSION['username']);            
		    $stmt->execute();     
		    $stmt->bind_result($favoriteUser);
		    
		    
		    while($stmt->fetch()){
		      printf("<ul class='list-group'>\n
		      	        \t
		      	        <li class='list-group-item'>User: %s</li>\n
		                </ul>\n\n",
		         htmlspecialchars($favoriteUser));
	        }
	        
	   
	        $stmt->close();    

	  }
	  printf('<a href="person.php">Go back to personal page</a>');
	  printf('</div>');

  }

?>


