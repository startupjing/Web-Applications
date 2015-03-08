<%@ page language="java" import="java.util.*" pageEncoding="ISO-8859-1"%>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Home</title>

	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	
  </head>
  
  <body style="background-color: rgba(153,204,0,0.4)">
    
    <form name="f1" id="f1" method="post" action="UserController.html?method=insert">
       <p> <p>Userename:<input required type="text"  id="username" name="username" class="{required:true,minlength:3}"/> <br><br>
       <p> <p>Password:<input type="password" id="password" name="password" class="{required:true,minlength:3}" /><br><br>
       <p> <p>Confirm Password:<input type="password" id="confirm_password" name="confirm_password" class="{required:true,minlength:3,equalTo:'#password'}" /><br><br>
       <p> <p>Name:<input type="text" id="name" name="name" class="required" /><br><br>
       <p> <p>City:<input type="text" name="city" /><br><br>
       <p> <p>Phone:<input type="text" name="phone" /><br><br>
       <p> <p>DeptNum:<input type="text" id="deptNum" name="deptNum" class="required"/><br><br>
       <p> <p>isAdmin:<input type="text" id="isAdmin" name="isAdmin" class="required"/><br><br>   
       <input class="submit" type="submit"  value="submit"><br><br>
       <input type="reset" value="reset" name="reset" ><br><br>
    </form>
    
    <script src="jquery.js" type="text/javascript"></script>  
    <script src="jquery.validate.js" type="text/javascript"></script>  
    <script src="jquery.metadata.js" type="text/javascript"></script>  
    
    <script>
       $().ready(function(){  
       $("#f1").validate({  
            submitHandler: function(form){  
            alert("submitted");  
            form.submit();  
        }  
       });  
     }); 
    </script>
    
    <a href="index.jsp">return</a>
 
    
    　　
  </body>
</html>
