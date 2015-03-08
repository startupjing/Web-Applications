<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>
<%@taglib  prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>My JSP 'deptEmp.jsp' starting page</title>

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
		
		.nav{
	       text-decoration: none;
	       color: #4D4D00;
         }
         
        
  </style>

  </head>
  
  <body style="background-color: rgba(153,204,0,0.4)">
      <div class="info">
        <h2 align="center">Department Information</h2>
        <h3 align="center">No: ${dept.deptNum}</h3> 
        <h3 align="center">Department: ${dept.deptName}</h3> 
        <h3 align="center">Description: ${dept.deptInfo}</h3>
     
        <c:choose>
        <c:when test="${sessionScope.user.isAdmin eq '0'}">
           <p align="center"><a class="nav" href="DeptController.html?method=findByAll">&nbsp;&nbsp;&nbsp;&nbsp;return to admin</a>
        </c:when>
        <c:otherwise>
            <p align="center"><a class="nav" href="UserController.html?method=findByDept&deptNum=${sessionScope.user.deptNum}">return to your dept</a>
        </c:otherwise>
        </c:choose>
        <a class="nav" href=logout.jsp>&nbsp;&nbsp;&nbsp;&nbsp;logout</a><br>
   </div>
 
  </body>
</html>
