<!DOCTYPE html>
<?php
session_start();

require 'database.php';

printf('<head>
         <title>Story Page</title>
	     <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
	     <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	     <link rel="stylesheet" type="text/css" href="mainstyle.css"/>
	     <script src="http://code.jquery.com/jquery-latest.js"></script>
         <script src="assets/js/bootstrap.min.js"></script>
         <script src="assets/js/app.js"></script>
       </head>');


//print navigation bar based on if user logged in

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

  if($_SESSION['token'] != $_POST['token']){
      die("Request forgery detected");
  }
  
  //post a new story
	if($_POST['form_type'] == 'postStory'){
		$username = $_SESSION['username'];
		
		$storyTitle = $_POST['storyTitle'];
		$storyContent = $_POST['textArea'];
		$storyCategory = $_POST['storyCategory'];

		$stmt = $mysqli->prepare("insert into story (username, title, story_content, cat_name, post_time) values (?, ?, ?, ?, NOW())");
		if(!$stmt){
			 printf("Query Prep Failed: %s\n", $mysqli->error);
			 exit;
		}
		 
		$stmt->bind_param('ssss', $username, $storyTitle, $storyContent, $storyCategory);
		$stmt->execute();
    $stmt->close();

    printf("<h3>Post successfully</h3><a href='person.php'>Go back</a>");

  //delete a story
	}else if($_POST['form_type'] == 'deleteStory'){
		$deleteStoryId = $_POST['deleteStoryId'];

    $stmt = $mysqli->prepare("delete from comment where story_id=?");

    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
     
    $stmt->bind_param('s', $deleteStoryId);
    $stmt->execute();
    $stmt->close();


    $stmt = $mysqli->prepare("delete from favorite where story_id=?");

    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
     
    $stmt->bind_param('s', $deleteStoryId);
    $stmt->execute();
    $stmt->close();

		$stmt = $mysqli->prepare("delete from story where story_id=?");

		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt->bind_param('s', $deleteStoryId);
		$stmt->execute();
    $stmt->close();

    printf("<h3>Delete successfully</h3><a href='person.php'>Go back</a>");
  

  //edit a story

	}else if($_POST['form_type'] == 'editStory'){
		$editStoryId = $_POST['editStoryId'];
		$editContent = $_POST['textArea'];
		$editCategory = $_POST['editStoryCategory'];

		$stmt = $mysqli->prepare("update story set story_content=?, cat_name=?, post_Time=NOW() where story_id=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt->bind_param('sss', $editContent, $editCategory, $editStoryId);
		$stmt->execute();
        $stmt->close();

        printf("<h3>Edit successfully</h3><a href='person.php'>Go back</a>");
	}
}



if(isset($_GET['cat'])){
  $test = $_GET['cat'];
  if($test!='education' && $test!='entertainment' && $test!='life' && $test!='politics'
     && $test!='society' && $test!='sports' && $test!='technology' && $test!='travel'){
      header("Location: person.php");
  }


	printf("<div id='content'>");
	printf("<h4>Posts in %s</h4>\n", htmlentities($_GET['cat']));
  
  //print like button based on if user logged in
	if(isset($_SESSION['username'])){
		printf("<form action='favorite.php' method='POST'>
			      <input type='hidden' name='form_type' value='likeCategory'>
			      <input type='hidden' name='likeCatName' value=%s>
			      <button type='submit' class='btn btn-primary'>Save category to favorite</button>
			    </form>", htmlentities($_GET['cat']));
	}


    $stmt = $mysqli->prepare("select story_id, title, story_content, username, post_time from story where cat_name=?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('s', $_GET['cat']);            
    $stmt->execute();     
    $stmt->bind_result($showId, $showTitle, $showContent, $showUsername, $showTime);
    
    //display stories in category
    while($stmt->fetch()){
      printf("<ul class='list-group'>\n
      	        \t<li class='list-group-item'>Title: %s</li>
                <li class='list-group-item'>Content: %s</li>
                <li class='list-group-item'>Author: %s</li>
                <li class='list-group-item'>Time: %s</li>
                <li><form action='storyComment.php' method='POST'>
                       <input type='hidden' name='storyId' value=%s>
                       <button type='submit' class='btn btn-info'>Read more</button>
                    </form></li>\n
                </ul>\n\n",
         htmlspecialchars($showTitle),
         htmlspecialchars($showContent),
         htmlspecialchars($showUsername),
         htmlspecialchars($showTime),
         $showId
      );
    }
   
    $stmt->close();
    
    if(!isset($_SESSION['username'])){
       printf('<a href="index.html">Go to main page</a>');
    }else{
       printf('<a href="person.php">Go to personal page</a>');
    }

    printf("</div>");

}

?>