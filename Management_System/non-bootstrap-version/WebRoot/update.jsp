<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>
<%@taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
  <head>
    <title>My JSP 'update.jsp' starting page</title>

	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<!--
	<link rel="stylesheet" type="text/css" href="styles.css">
	-->

  </head>
  
  <body style="background-color: rgba(153,204,0,0.4)">
    <form name="f2" method="post" action="UserController.html?method=update&id=${user.id}">
       <p><p>ID: ${user.id}<br><br>
       <p><p>Username: ${user.username}<br><br>
       <p><p>old name: ${user.name}<br><br>
       <p><p>old password: ${user.password}<br><br>
       <p><p>old city: ${user.city}<br><br>
       <p><p>old phone: ${user.phone}<br><br>
       <p><p>old deptNum: ${user.deptNum}<br><br>
       <p> <p>Update Name:<input type="text" name="name" /><br><br>
       <p> <p>Update Password:<input type="password" name="password" /><br><br>
       <p> <p>Update City:<input type="text" name="city" /><br><br>
       <p> <p>Update Phone:<input type="text" name="phone" /><br><br> 
       <p> <p>Update deptNum:<input type="text" name="deptNum" /><br><br> 
      
       <input type="submit" value="confirm" name="submit"/><br><br>
       <input type="reset" value="reset" name="reset" /><br><br>
    </form>
  </body>
</html>
