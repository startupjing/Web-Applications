<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>
<%@taglib  prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ page import="
org.jfree.chart.ChartFactory,
org.jfree.chart.JFreeChart,
org.jfree.chart.StandardChartTheme,
org.jfree.data.general.DefaultPieDataset,
org.jfree.chart.servlet.ServletUtilities"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>My JSP 'displayAdmin.jsp' starting page</title>

	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	
	

  </head>
  
  <body style="background-color: rgba(153,204,0,0.4)">
    <h2 align="center">Department Information</h2>
    <table border="1" align="center">
     
       <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;ID</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;deptNum</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;deptName</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;deptInfo</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;Operation</td>
        </tr>
        
        <% DefaultPieDataset ds = new DefaultPieDataset();%>
        <c:forEach items="${list}" var="item" varStatus="row">
           <c:set var="name" value="${item.deptName}" scope="request"></c:set>
           <c:set var="number" value="${item.empNum}" scope="request"></c:set>
           <% ds.setValue(request.getAttribute("name").toString(), Integer.parseInt(request.getAttribute("number").toString())); %>
           <tr>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;${item.id}</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;${item.deptNum}</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;${item.deptName}</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;${item.deptInfo}</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="DeptController.html?method=findById&id=${item.id}">update</a>
             <a href="DeptController.html?method=delete&id=${item.id}">delete</a>
            </tr>
        </c:forEach>  
    </table>
    
    <h3 align="center">Employee Ratio Chart</h3>
    
    <%
      JFreeChart chart = ChartFactory.createPieChart3D("Department-Employee Ratio", ds, true, true, false);
      String fileName = ServletUtilities.saveChartAsPNG(chart,450,300,null,session);
      String graphURL = request.getContextPath() + "/DisplayChart?filename=" + fileName;
     %>
    
     <p align="center"><img src="<%=graphURL%>"></p>
         
    <!-- <p><p><a href="insertDept.jsp">insert new department</a><br><br> -->
    <p><p><a href="logout.jsp">logout</a><br><br>
  </body>
</html>
