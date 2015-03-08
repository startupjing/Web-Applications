<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>
<%@taglib  prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>My JSP 'logout.jsp' starting page</title>

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
		
		.logout{
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
    <div class="logout">
    
    <c:if test="${!empty message}">
       ${message}
    </c:if>
    <%session.invalidate();%>
    <p><p align="center">You have successfully log out<br><br>
    <p align="center"><a href="index.jsp">Click here to login</a>
    </div>
  </body>
</html>
