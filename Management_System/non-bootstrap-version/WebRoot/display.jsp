<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>
<%@taglib  prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>My JSP 'shows.jsp' starting page</title>

	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
  </head>
  
  <body style="background-color: rgba(153,204,0,0.4)">
    
    <form method="post" action="UserController.html?method=search">
       <p align="right"><input type="text" name="keyword"/><input type="submit" value="search">
    </form>
    
    
    <h2 align="center">Department Employee</h2>
    <table border="1" align="center" >
       <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;ID</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;Name</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;Department</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;isAdmin</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;Operation</td>
        </tr>
        
        <c:forEach items="${list}" var="item" varStatus="row">
           <tr>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;${item.id}</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="UserController.html?method=goPersonal&id=${item.id}">${item.name}</a></td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="DeptController.html?method=showDept&id=${item.deptNum}">${item.deptNum}</a></td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;${item.isAdmin}</td>
              <c:if test ="${sessionScope.user.id == item.id}">
                <td>&nbsp;&nbsp;<a href="UserController.html?method=findById&id=${item.id}">update</a>
                <a href="UserController.html?method=delete&id=${item.id}">delete</a></td>
              </c:if>
            </tr>
        </c:forEach>
    </table>
  

    <c:if test="${not empty dept}">
    <h2 align="center">Department Information</h2>
    <table border="1" align="center">
       <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;Department Number</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;Department Name</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;Department Information</td>
       </tr>
       <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;${dept.deptNum}</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;${dept.deptName}</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;${dept.deptInfo}</td>
       </tr>
    </table>
    </c:if>
    
    
    <p><p><a href="UserController.html?method=goPersonal&id=${sessionScope.user.id}">personal page</a>
    <p><p><a href="UserController.html?method=findByAll&page=1&pageSize=4">see all employee</a><br>
    <p><p><a href="UserController.html?method=findByDept&deptNum=${sessionScope.user.deptNum}">return to your department</a><br>
    <p><p><a href=logout.jsp>logout</a><br>
  </body>
</html>
