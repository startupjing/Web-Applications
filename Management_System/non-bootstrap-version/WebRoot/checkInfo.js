
function checkEmp(f){
	if(f.username.value=="" || f.password.value==""){
		alert("Username or password cannot be empty");
		return;
	}else{
		f.submit();
	} 
}


function checkDept(f){
	if(f.deptNum.value=="" || f.deptName.value=="" || f.deptInfo.value==""){
		alert("Please enter all information");
		return;
	}else{
		f.submit();
	} 
}
