<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>My JSP 'uploadFile.jsp' starting page</title>

	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<!--
	<link rel="stylesheet" type="text/css" href="styles.css">
	-->

  </head>
  
  <body>
  
  <form name="f1" method="post" action="FileController.html?method=upload" enctype="multipart/form-data">
     <h3>File Name: <input type="text" name="fileName"></h3>
     <input name="uploadName" type="hidden" value="${sessionScope.user.username}">
     <h3>Upload File: <input name="title" type="file" >
     <input name="account" type="hidden" value=""></h3>
     
     
     
     <h3>Restriction: <input name="restrict" type="radio" value="anyone" checked>AnyOne 
            <input type="radio" name="restrict" value="registered user">Registered User</h3>
     
     <h3><input type="submit" value="upload"></h3>    
     <h3><input type="reset" value="reset"></h3>
     <h3><input type="button" value="return" onClick="window.location.href='index.jsp'"></h3> 
  </form>
   
  </body>
</html>
