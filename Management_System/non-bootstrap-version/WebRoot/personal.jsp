<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>PersonalPage</title>

	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	
	<style>

		body{
			background-image: url("http://bgfons.com/upload/leaves_texture1243.jpg");
			background-size: cover;
		}
		
		.info{
			width:540px;
			margin:80 auto;
			padding: 40px;
			height:400px;
			background-color: rgba(153,204,0,0.7);
			border-radius: 70px;
			color: #4D4D00;
			margin-top:150px;
		}
  </style>

  </head>
  
  <body>
    <div class="info">
    <h2 align="center">Personal Information</h2>
    <h3 align="center">Username: ${user.username}</h3> 
    <h3 align="center">Name: ${user.name}</h3> 
    <h3 align="center">City: ${user.city}</h3>
    <h3 align="center">Phone: ${user.phone}</h3>
    <h3 align="center">Department: ${dept.deptName}</h3>
    <h3 align="center">Department Info: ${dept.deptInfo}</h3>
    
    <a href="uploadFile.jsp">Upload File</a>
    <a href="FileController.html?method=showFile">Download File</a>
    <p><a href="UserController.html?method=findByDept&deptNum=${sessionScope.user.deptNum}">return to department</a><br>
    <p><a href=logout.jsp>logout</a><br>
   </div>
  </body>
</html>
