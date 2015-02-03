<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title>User File Directory</title>
   <link rel="stylesheet" type="text/css" href="mainstyle.css"/>
</head>
<body>

<div id="filecontent">
<?php

   $doSearch = isset($_POST['searchkey']) && !empty($_POST['searchkey']);

   //determine if a search is performed
   if($doSearch){
       printf("<p>Search results: </p>");
   }else{
       printf("<p> Hello %s, here are your files</p>", htmlentities($_SESSION['username']));
   }

    //scanning the name of file in a given dir path
   $filenames = scandir(sprintf("/home/jinglu/uploads/%s", $_SESSION['username']));   

   $filenum = count($filenames);
   $searchFound = 0;
   printf("<ul>");  

   //scan each file in the upload directory
   for($i=0; $i<$filenum; $i++){
       //skip unuseful directory
       if($filenames[$i]!="." && $filenames[$i]!=".."){   
           //display differs when a search is performed
           if(($doSearch  && strpos($filenames[$i],$_POST['searchkey'])!==false) 
                                                  || !$doSearch){
              $currFile = $filenames[$i];
             
              //count search results
              if($doSearch){
                  $searchFound ++;
              }
           }else{
              continue;
           }


           $userFile = fopen("/home/jinglu/userinfo/user.txt","r"); 

           //print open, delete, share options for each file      
           echo sprintf('<form action="processFile.php" id="fileform" method="POST"> 
                         <input type="hidden" value= %s name="info" />
                         <li><label for="file"> %s </label>
                         <input type="submit" name="open" id="file" value="open" />
                         <input type="submit" name="delete" id="file" value="delete" />
                         <select name="shareto" id="shareto"">',
                         htmlentities($currFile), htmlentities($currFile));
           
           //display users to share to 
           while(!feof($userFile)){
               $currUser = trim(fgets($userFile));
               if($currUser != ''){
                  echo sprintf('<option value=%s> %s </option>',
                     htmlentities($currUser),htmlentities($currUser));
               }
           }

 
          echo sprintf('<input type="submit" name="share" id="share" value="share" />
                       </li></form>');

        }
   }
   printf("</ul>");
   

   if($doSearch){
       if($searchFound==0){
          printf("<p>Sorry, no results found</p>");
       }else{
          printf("<p>Total of %d results found</p>", $searchFound);
       }
   }
   
   //search function
   echo sprintf('<h3>Search File</h3><br />
                 <form action="file.php" method="POST">
	               <p>
		                 <label for="searchkey">Search:</label>
		                 <input type="text" name="searchkey" id="searchkey" />
                 </p>
                 <p>
		                <input type="submit" value="search" />
	              </p>
                </form>
                <p><a href="file.php">See all files</a></p>');
  
   //upload function
   echo sprintf('<h3>File Upload</h3><br />
           Select a file to upload: <br />
           <form enctype="multipart/form-data" action="upload.php" method="POST">
	         <p>
		         <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		         <label for="upload">Choose a file to upload:</label> 
		         <input name="uploadedfile" type="file" id="upload" />
	        </p>
	        <p>
		       <input type="submit" value="Upload" />
	        </p>
          </form>');
   
   //back to personal page
   echo sprintf('<a href="person.php">Back</a>
                 <br />
                 <form action="validate.php" method="POST">
					       <p>
						       <input type="submit" value = "logout"/>
					       </p>
                </form>
                <br />'); 

?>
</div>
</body>
</html>
