<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>
<%@taglib  prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>My JSP 'download.jsp' starting page</title>

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
    <table width="850" border="1" align="center">
       <tr>
          <td width="100">Status</td>
          <td width="350">FileName</td>
          <td width="150">Upload Person</td>
          <td width="100">Download</td>
          <td width="150">Upload Time</td>
       </tr>
       
       <c:forEach items="${list}" var="item" varStatus="row">
           <tr>
              <td>Ready</td>
              <td>${item.fileName}</td>
              <td>${item.uploadName}</td>
              <td><a href=FileController.html?method=download&fileName=${item.fileName}>download</a></td>
              <td>${item.uploadTime}</td>
           </tr>
       </c:forEach>
    </table>
    
    <p><a href="personal.jsp">return to personal page</a></p>
    
    
  </body>
</html>
