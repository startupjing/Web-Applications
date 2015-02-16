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
          </div>');


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
   

    printf('<div id="content">');  

    

    $stmt = $mysqli->prepare("select title, story_content, username, post_time from story where story_id=?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }


    $stmt->bind_param('s', $_POST['storyId']);            
    $stmt->execute();     
    $stmt->bind_result($showTitle, $showContent, $showUsername, $showTime);
   

    while($stmt->fetch()){
      printf("\t<h2>Title: %s</h2>\n
                <p>Content: %s</p>\n
                <ul class='list-group'>\n
                   <li class='list-group-item'>Author: %s</li>
                   <li class='list-group-item'>Time: %s</li>
                </ul>\n\n",
         htmlspecialchars($showTitle),
         htmlspecialchars($showContent),
         htmlspecialchars($showUsername),
         htmlspecialchars($showTime)
      );
    }
    $stmt->close();

    //print like button
    if(isset($_SESSION['username'])){
       
      printf("<form action='favorite.php' method='POST'>
              <input type='hidden' name='form_type' value='likeStory' />
              <input type='hidden' name='likeStoryId' value=%s />
              <input type='hidden' name='token' value=%s />
              <button type='submit' class='btn btn-info'>Like story</button>
            </form>", htmlentities($_POST['storyId']), $_SESSION['token']);

      printf("<form action='favorite.php' method='POST'>
              <input type='hidden' name='form_type' value='likeUser' />
              <input type='hidden' name='likeUsername' value=%s />
              <input type='hidden' name='token' value=%s />
              <button type='submit' class='btn btn-info'>Follow author</button>
            </form>", htmlentities($showUsername), $_SESSION['token']);
    }

    $stmt = $mysqli->prepare("select comment_content, username, comment_time from comment where story_id=?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('s', $_POST['storyId']);            
    $stmt->execute();     
    $stmt->bind_result($showComment, $showCommentUser, $showCommentTime);
   
    //display comments associated with the story
    while($stmt->fetch()){
      printf("\t<p>Comment on this article: </p>
                <ul class='list-group'>\n
                   <li class='list-group-item'>Content: %s</li>
                   <li class='list-group-item'>Author: %s</li>
                   <li class='list-group-item'>Time: %s</li>
                </ul>\n\n",
         htmlspecialchars($showComment),
         htmlspecialchars($showCommentUser),
         htmlspecialchars($showCommentTime)
      );
    }
    $stmt->close();
    

    //print a text area to post comment on the story
    if(isset($_SESSION['username'])){
       
       printf('
        <form class="form-postComment" action="comment.php" method="POST">
             <h2 class="form-postComment-heading">Type your comment:</h2>
             <input type="hidden" name="form_type" value="postComment"/>
             <input type="hidden" name="commentStoryId" value=%s />
             <input type="hidden" name="token" value=%s />

              <textarea class="form-control" rows="5" name="comment" value="comment"></textarea>
            
              <p>
                  <button type="submit" class="btn btn-default">Post Comment</button>
              </p>
        </form>', $_POST['storyId'], $_SESSION['token']);
    
        printf('<a href="person.php">Go to personal page</a>');
    }else{
       printf('<a href="index.html">Go to main page</a>');
    }

    printf('</div>');
?>