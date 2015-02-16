<!DOCTYPE html>

<?php
session_start();

printf('<html lang="en">

  <head>
     <title>Story Page</title>
     <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
     <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="mainstyle.css"/>
  </head>');

  if(isset($_POST['form_type'])){

  	//build form to submit a new story
    if($_POST['form_type'] == 'post'){
	  	printf('<body>
	  		<div id="content"/>
	  		<div class="container">

		  	<form class="form-post-story" action="story.php" method="POST">
			  	<h2 class="form-post-story-heading">Please type in the following field: </h2>
				<input type="hidden" name="form_type" value="postStory"/>
				<input type="hidden" name="token" value=%s />
			
			
				<div class="form-group">
				  <label for="storyTitle">Story Title</label>
				  <input type="text" class="form-control" name="storyTitle" id="storyTitle" placeholder="title">
				</div> 
		
		
				<label for="storyContent">Story Content</label> 	
				<textarea class="form-control" rows="5" placeholder="tell us your story" name="textArea" value="textArea"></textarea>
		  		<p>
		  		<label>Story Category</label>
		  		<select name="storyCategory">
					  <option value="technology">Technology</option>
					  <option value="entertainment">Entertainment</option>
					  <option value="life">Life</option>
					  <option value="sports">Sports</option>
					  <option value="politics">Politics</option>
					  <option value="education">Education</option>
					  <option value="travel">Travel</option>
					  <option value="society">Society</option>
				</select>
		  		</p>
		  		
		  		<p>
		  		<button type="submit" class="btn btn-default">Post it!</button>
		  		</p>
		  	</form>
			<p> <a href="person.php">Back to your personal home page</a></p>
	    </div>
	    </div>
	    </body>', $_SESSION['token']);

    //build a form to edit story
    }else if($_POST['form_type'] == 'update'){
    	$target = $_POST['targetStoryId'];
    	require 'database.php';

    	$stmt = $mysqli->prepare("select title, story_content from story where story_id=?");
	    if(!$stmt){
	      printf("Query Prep Failed: %s\n", $mysqli->error);
	      exit;
	    }
	    
	    $stmt->bind_param('s', $target);            
	    $stmt->execute();     
	    $stmt->bind_result($showTitle, $showContent);
	   

	    while($stmt->fetch()){
	      printf("\t<h2>Title: %s</h2>\n",
	         htmlspecialchars($showTitle)
	      );
	    }
	    $stmt->close();

	    printf('<body>
	    	<div id="content">
	    	<div class="container">

		  	<form class="form-edit-story" action="story.php" method="POST">
			  	<h2 class="form-edit-story-heading">Please edit your story: </h2>
				<input type="hidden" name="form_type" value="editStory"/>
				<input type="hidden" name="editStoryId" value=%s />
				<inpyt type="hidden" name="token" value=%s />
				
				<label for="storyContent">Edit Story Content</label> 	
				<textarea class="form-control" rows="5" name="textArea" value="textArea">%s</textarea>
		  		
		  		<p>
		  		<label>Edit Story Category</label>

		  		<select name="editStoryCategory">
					  <option value="technology">Technology</option>
					  <option value="entertainment">Entertainment</option>
					  <option value="life">Life</option>
					  <option value="sports">Sports</option>
					  <option value="politics">Politics</option>
					  <option value="education">Education</option>
					  <option value="travel">Travel</option>
					  <option value="society">Society</option>
				</select>
		  		</p>
		  		
		  		<p>
		  		<button type="submit" class="btn btn-default">Submit</button>
		  		</p>
		  	</form>
			<p> <a href="person.php">Back to your personal home page</a></p>
	    </div>
	    </div>
	    </body>', htmlspecialchars($target),$_SESSION['token'], htmlspecialchars($showContent));

    }
  }
?>