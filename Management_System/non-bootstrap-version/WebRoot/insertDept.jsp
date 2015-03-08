<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>My JSP 'insertDept.jsp' starting page</title>

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
    <script language="javascript" src="checkInfo.js"></script>
    <form name="f1" method="post" action="DeptController.html?method=insert">
       <p> <p>deptNum:<input type="text" name="deptNum" /><br><br>
       <p> <p>deptName:<input type="text" name="deptName" /><br><br>
       <p> <p>deptInfo:<input type="text" name="deptInfo" /><br><br>  
       <input name="Button" type="button"  value="submit" onclick="checkDept(f1)"><br><br>
       <input type="reset" value="reset" name="reset" ><br><br>
    </form>
  </body>
</html>
