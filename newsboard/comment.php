<!DOCTYPE html>
<?php
  session_start();
  
  //html headers
  printf('<head>
         <title>Comment Page</title>
             <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
             <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
             <link rel="stylesheet" type="text/css" href="mainstyle.css"/>
             <script src="http://code.jquery.com/jquery-latest.js"></script>
             <script src="assets/js/bootstrap.min.js"></script>
             <script src="assets/js/app.js"></script>
       </head>');
  require 'database.php';

  


  if(isset($_POST['form_type'])){
  	//detect request forgery
	  if($_SESSION['token'] != $_POST['token']){
		 die("Request forgery detected");
	   }

	   
  	//post comment
	if($_POST['form_type'] == 'postComment'){
		$username = $_SESSION['username'];	
		$storyId = $_POST['commentStoryId'];
		$commentContent = $_POST['comment'];

		$stmt = $mysqli->prepare("insert into comment (story_id, comment_content, username,comment_time) values (?, ?, ?, NOW())");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt->bind_param('sss', $storyId, $commentContent, $username);
		$stmt->execute();
        $stmt->close();
        
        //link to commented story
        printf("<form action='storyComment.php' method='POST'>
        	      <input type='hidden' name='token' value=%s />
        	      <input type='hidden' name='storyId' value=%s />
        	      <button type='submit' class='btn btn-primary'>Back to story</button>
        	     </form>", $_SESSION['token'], $_POST['commentStoryId']);
        
    //edit comment
	}else if($_POST['form_type'] == 'editComment'){
		$editCommentId = $_POST['editCommentId'];
		$editContent = $_POST['commentEdit'];

		$stmt = $mysqli->prepare("update comment set comment_content=?, comment_time=NOW() where comment_id=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt->bind_param('ss', $editContent, $editCommentId);
		$stmt->execute();
        $stmt->close();
  
        printf("<h3>Edit successfully</h3><a href='person.php'>Go back</a>");

    //delete comment
	}else if($_POST['form_type'] == 'deleteComment'){
		$deleteCommentId = $_POST['deleteCommentId'];
		$stmt = $mysqli->prepare("delete from comment where comment_id=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt->bind_param('s', $deleteCommentId);
		$stmt->execute();
        $stmt->close();

        printf("<h3>Delete successfully</h3><a href='person.php'>Go back</a>");

	}
}
?>