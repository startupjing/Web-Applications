<!DOCTYPE html>
<?php
session_start();

require 'database.php';

//get target in search function
$target = "%".$_POST['target']."%";

printf(' 
  	<head>
         <title>Search Result</title>
         <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen" />
         <link href="assets/css/bootstrap-responsive.css" rel="stylesheet" />
         <link rel="stylesheet" type="text/css" href="mainstyle.css"/>
         <script src="http://code.jquery.com/jquery-latest.js"></script>
         <script src="assets/js/bootstrap.min.js"></script>
         <script src="assets/js/app.js"></script>
   </head>');


//search result based on if user logged in
if(isset($_SESSION['username'])){
    
	if($_SESSION['token'] != $_POST['token']){
		die("here");
	    die("Request forgery detected");
    }

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
              <select name="searchRange">
              <option value="user">User</option>
              <option value="story">Story</option>
              <option value="comment">Comment</option>
              </select>
              <button type="submit" class="btn btn-default">Search</button>
       </form>
       
       <div class="btn-group pull-right">
          <a href="storyEdit.php?edit=post" class="btn btn-primary">Post Story</a>
          <a href="logout.php" class="btn btn-success">Logout</a>
       </div>
    
      </div>
    </div>');


}else{
	printf('<div class="navbar navbar-inverse">
    <div class="navbar-inner">
       <a class="brand" href="index.html">NewsBoard</a>
       <ul class="nav nav-pills">
          <li role="presentation" class="active"><a href="story.php?category=all">All</a></li>
          <li role="presentation"><a href="story.php?cat=education">education</a></li>
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




printf('<div id="content">');

//search for users

if($_POST['searchRange'] == 'user'){

	$stmt = $mysqli->prepare("select username from user where username like ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $target);
	$stmt->execute();
	$stmt->bind_result($userResult);

	echo "Search result: \n";
	while($stmt->fetch()){
		printf("<ul class='list-group'>\n
			\t<li class='list-group-item'>%s</li>
		</ul>\n\n",$userResult);
	}

	$stmt->close();

	if(isset($_SESSION['username'])){
		printf('<a href="person.php">Go to personal page</a>');
	}else{
		printf('<a href="index.html">Go to main page</a>');
	}

//search for stories

}else if($_POST['searchRange'] == 'story'){

	$stmt = $mysqli->prepare("select title, story_content, username, post_time from story 
		where title like ? or story_content like ? or username like ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}


	$stmt->bind_param('sss', $target, $target, $target);            
	$stmt->execute();     
	$stmt->bind_result($showTitle, $showContent, $showUsername, $showTime);
	echo "Search result: \n";
	while($stmt->fetch()){
		printf("<ul class='list-group'>\n
			\t<li class='list-group-item'>Title: %s</li>
			<li class='list-group-item'>Content: %s</li>
			<li class='list-group-item'>Author: %s</li>
			<li class='list-group-item'>Time: %s</li>\n
		</ul>\n\n",
		htmlspecialchars($showTitle),
		htmlspecialchars($showContent),
		htmlspecialchars($showUsername),
		htmlspecialchars($showTime)
		);
	}

	$stmt->close();

	if(isset($_SESSION['username'])){
		printf('<a href="person.php">Go to personal page</a>');
	}else{
		printf('<a href="index.html">Go to main page</a>');
	}

//search for comments

}else{
	$stmt = $mysqli->prepare("select title, story_content, story.username, comment_content, comment.username, comment_time 
    from story join comment on (comment.story_id = story.story_id)
     where comment_content like ? or comment.username like ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('ss', $target, $target);
	$stmt->execute();
	$stmt->bind_result($stoTitle, $stoContent, $stoUsername, $comContent, $comUsername, $comTime);
	echo "Search result: \n";
	while($stmt->fetch()){
		printf("<ul class='list-group'>\n
			\t<li class='list-group-item'>Title: %s</li>
			<li class='list-group-item'>Content: %s</li>
			<li class='list-group-item'>Story Author: %s</li>
			<li class='list-group-item'>Comment: %s</li>
			<li class='list-group-item'>Comment Author: %s</li>
			<li class='list-group-item'>Comment Time: %s</li>\n
		</ul>\n\n",
		htmlspecialchars($stoTitle),
		htmlspecialchars($stoContent),
		htmlspecialchars($stoUsername),

		htmlspecialchars($comContent),
		htmlspecialchars($comUsername),
		htmlspecialchars($comTime)
		);
	}

	$stmt->close();

    //link to redirection
	if(isset($_SESSION['username'])){
		printf('<a href="person.php">Go to personal page</a>');
	}else{
		printf('<a href="index.html">Go to main page</a>');
	}

}

printf('</div>');