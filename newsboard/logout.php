<!DOCTYPE html>
<?php
   
   //destroy the session and log out
   session_start();
   unset($_SESSION['username']);
   unset($_SESSION['token']);
   printf("<p>You have successfully logged out</p>\n\n");
   printf("<a href='index.html'>Go back to Main Page</a>");
?>