<!DOCTYPE html>

<html lang="en">

  <head>
     <title>Personal Page</title>
     <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
     <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="mainstyle.css"/>
  </head>

  <body>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
    
    <?php
       session_start();

       //if no current session, redirect to main page 
       if(!isset($_SESSION['username'])){
          header("Location: index.html");
       }
    ?>
   

    <!-- navigation bar -->

    <div class="navbar navbar-inverse">
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
       
       <?php
         printf('<form action="search.php" class="navbar-search offset1" method="post">
              <input type="text" name ="target" class="search-query" placeholder="Search">
              <input type="hidden" name="token" value="%s"> 
              <select name="searchRange">
                 <option value="user">User</option>
                 <option value="story">Story</option>
                 <option value="comment">Comment</option>
              </select>
              <button type="submit" class="btn btn-default">Search</button>
           </form>', $_SESSION['token']);
        ?>
       
       <div class="btn-group pull-right">
          <?php
            printf("<form action='storyEdit.php' method='POST'>
                      <input type='hidden' name='form_type' value='post' />
                      <input type='hidden' name='token' value=%s />
                      <button type='submit' class='btn btn-primary'>Post story</button>
                    </form>", $_SESSION['token']);
          ?>
  
          <a href="logout.php" class="btn btn-success">Logout</a>
       </div>
    
      </div>
    </div>
    

    <div id="content">


    <?php
      printf("<h2> Hello %s</h2>\n", htmlentities($_SESSION['username']));
      require 'database.php';
      if(isset($_GET['option'])){
        printf("<div id='content'>");

         //show profile infirmation
         if($_GET['option'] == 'profile'){
                printf("<h4>Profile information</h4>\n");
                $stmt = $mysqli->prepare("select username, name, email from user where username=?");
                if(!$stmt){
                  printf("Query Prep Failed: %s\n", $mysqli->error);
                  exit;
                }
                $stmt->bind_param('s', $_SESSION['username']);            
                $stmt->execute();     
                $stmt->bind_result($profileUsername, $profileName, $profileEmail);
                 
                echo "<ul class='list-group'>\n";
                while($stmt->fetch()){
                  printf("\t<li class='list-group-item'>Your username: %s</li>
                            <li class='list-group-item'>Your name: %s</li>
                            <li class='list-group-item'>Your email: %s</li>\n",
                    htmlspecialchars($profileUsername),
                    htmlspecialchars($profileName),
                    htmlspecialchars($profileEmail)
                  );
                }
                echo "</ul>\n\n";
                $stmt->close();
                

                //form to update personal profile
                printf('<form class="form-update" action="user.php" method="POST">
                         <h4 class="form-update-heading">Update profile</h4>
                
                         <input type="hidden" name="form_type" value="updateUser"/>
                         <input type="hidden" name="token" value=%s />


                        <div class="form-group">
                           <label for="updatePwd">New Password</label>
                           <input type="password" class="form-control" name="updatePwd" id="updatePwd" placeholder="New Password">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                    </form>', $_SESSION['token']);
         
         //show my own stories
         }else if($_GET['option'] == 'story'){
              $username = $_SESSION['username']; 
              $stmt = $mysqli->prepare("select story_id, title, story_content, cat_name, post_time from story where username=? ");
              if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
              }

              $stmt->bind_param('s', $username);
              $stmt->execute();
              $stmt->bind_result($stoId, $stoTitle, $stoContent, $stoCat, $stoTime);

              //forms to edit and delete my story
              while($stmt->fetch()){
                printf('
                  <br></br>
                  <ul>
                     <li>Title: %s </li>
                     <li>Category: %s</li>   
                     <li>Post Time: %s</li>
                  </ul>
                  <p>Content: %s</p>

                  <form action="storyEdit.php" method="POST">
                      <input type="hidden" name="form_type" value="update" />
                      <input type="hidden" name="targetStoryId" value=%s />
                      <input type="hidden" name="token" valu=%s />
                      <button type="submit" class="btn btn-primary">Edit</button>
                  </form>


     
                  <form action="story.php" method="POST">
                        <input type="hidden" name="form_type" value="deleteStory"/>
                        <input type="hidden" name="deleteStoryId" value=%s />
                        <input type="hidden" name="token" value=%s />
                        <button type="submit" class="btn btn-danger">Delete</button>
                  </form>',
                  htmlspecialchars($stoTitle),
                  htmlspecialchars($stoCat),
                  htmlspecialchars($stoTime),
                  htmlspecialchars($stoContent),
                  $stoId,
                  $_SESSION['token'],
                  $stoId,
                  $stoId,
                  $_SESSION['token']
                  );
              }
              
              $stmt->close();

         //display my own comments
         }else if($_GET['option'] == 'comment'){
              $username = $_SESSION['username']; 
              $stmt = $mysqli->prepare("select comment_id, title, story.username, story_content, comment_content, comment_time from story, comment where comment.story_id = story.story_id and comment.username = ?");
              if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
              }

              $stmt->bind_param('s', $username);
              $stmt->execute();
              $stmt->bind_result($com_stoId, $com_stoTitle, $stoAuthor, $com_stoContent, $comContent, $comTime);
              
              echo "<ul>\n";

              //forms to edit and delete own comment
              while($stmt->fetch()){
                printf("\t
                  <li>You commented on the Story: %s <br/>
                  written by Author: %s <br/>
                  <p>Your Comment: %s</p></li>

                  <form action='comment.php' method='POST'>
                      <input type='hidden' name='form_type' value='editComment'/>
                      <input type='hidden' name='editCommentId' value=%s />
                      <input type='hidden' name='token' value=%s />
                      <textarea class='form-control' rows='3' placeholder='edit your comment' name='commentEdit' value='commentEdit'>%s</textarea>
                      <button type='submit' class='btn btn-primary'>Save</button>
                  </form>

                  <form action='comment.php' method='POST'>
                        <input type='hidden' name='form_type' value='deleteComment'/>
                        <input type='hidden' name='deleteCommentId' value=%s />
                        <input type='hidden' name='token' value=%s />
                        <button type='submit' class='btn btn-danger'>Delete</button>
                  </form>

                  \n",
                  htmlspecialchars($com_stoTitle),
                  htmlspecialchars($stoAuthor),
                  htmlspecialchars($comContent),
                  htmlspecialchars($com_stoId),
                  $_SESSION['token'],
                  htmlspecialchars($comContent),
                  htmlspecialchars($com_stoId),
                  $_SESSION['token']
                  );
              }
              echo "</ul>\n";
              $stmt->close();
         }
         printf('</div>');
      }
    ?>

  </div>

  </body>