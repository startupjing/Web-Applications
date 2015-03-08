<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>
<%@taglib  prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>My JSP 'testPage.jsp' starting page</title>

	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<!--
	<link rel="stylesheet" type="text/css" href="styles.css">
	-->
    
    <style>
       body{
           background-color: rgba(153,204,0,0.7);
       }
    </style>
  </head>
  
  <body >
    <h2 align="center">Employee Contacts</h2>
    <h3 align="center"><a href="FileController.html?method=export">export to PDF</a></h3>
    <table border="1" align="center" >
       <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;ID</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;Name</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;City</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;Phone</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;Department</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;isAdmin</td>
        </tr>
        
        <c:forEach items="${list}" var="item" varStatus="row">
           <tr>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;${item.id}</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="UserController.html?method=goPersonal&id=${item.id}">${item.name}</a></td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;${item.city}</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;${item.phone}</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="DeptController.html?method=showEmp&id=${item.deptNum}">${item.deptNum}</a></td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;${item.isAdmin}</td>
            </tr>
        </c:forEach>
    </table>
    
    <p align="center">Present Page: ${page}       Total Page: ${totalPage}</p>
    <p align="center">
      <c:if test="${page>1}">       
         <a href="UserController.html?method=findByAll&page=1&pageSize=4">First Page</a>&nbsp;&nbsp;&nbsp;&nbsp;
      </c:if>
      <c:if test="${page<totalPage}">
          <a href="UserController.html?method=findByAll&page=${totalPage}&pageSize=4">Last Page</a>&nbsp;&nbsp;&nbsp;&nbsp;
     </c:if>
     <c:if test="${page!=1 }">
           <a href="UserController.html?method=findByAll&page=${page-1}&pageSize=4">Previous Page</a>&nbsp;&nbsp;&nbsp;&nbsp;
      </c:if>
      <c:if test="${page<totalPage}">
           <a href="UserController.html?method=findByAll&page=${page+1}&pageSize=4">Next Page</a>
      </c:if>
    </p>
    <p align="center"><a href="index.jsp">return</a></p>
  
  </body>
</html>
