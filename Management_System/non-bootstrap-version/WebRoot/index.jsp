<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>
<%@taglib  prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">
    
    <title>My JSP 'index.jsp' starting page</title>
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
		
		.login{
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
    <div class="login">
    <c:choose>
    <c:when test="${empty sessionScope.user}">
     <h1 align="center">Welcome</h1>
     <c:if test="${!empty message}">${message}</c:if>
     <br><br>
    <form method="post" action="LoginController.html?method=login">
        <p align="center">Username:<input type="text" name="username" /></p>
        <p align="center">Password:<input type="password" name="password" /></p>
        <p align="center"><input type="submit" value="login"></p>
        <br><br><br><br>
        <p><a href="insert.jsp">New User? Click to Register</a> 
     </form>
     </c:when>
     
     <c:otherwise>
        <p><p align="center">Welcome! ${sessionScope.user.username}<br><br>
        <p><p align="center"><c:if test="${!empty message}">${message}</c:if><br><br>
        
        <c:choose>
           <c:when test="${sessionScope.user.isAdmin eq '0'}">
               <p><p><a href="DeptController.html?method=findByAll">return</a><br><br>
           </c:when>
           <c:otherwise>
              <p><p><a href="UserController.html?method=findByDept&deptNum=${sessionScope.user.deptNum}">return</a><br><br>
           </c:otherwise>
        </c:choose>
             
        <p><p><a href="logout.jsp">logout</a><br><br>
     </c:otherwise>
   </c:choose>
   </div>
    
  
</html>
