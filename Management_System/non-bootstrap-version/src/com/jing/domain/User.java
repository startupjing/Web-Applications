package com.jing.domain;

public class User {
	
	private Integer id;
    private String username;
    private String password;
    private String name;
    private String phone;
    private String city;
    private Integer deptNum;
    private String isAdmin;
 
    
    public Integer getid(){
    	return this.id;
    }
    
    public String getusername(){
    	return this.username;
    }
    
    public String getpassword(){
    	return this.password;
    }
    
    public String getname(){
    	return this.name;
    }
    
    public String getphone(){
    	return this.phone;
    }
    
    public String getcity(){
    	return this.city;
    }
    
    public Integer getdeptNum(){
    	return this.deptNum;
    }
    
    public String getisAdmin(){
    	return this.isAdmin;
    }
    
   
    public void setid(Integer id){
    	this.id = id;
    }
    public void setusername(String username){
    	this.username = username;
    }
    
    public void setpassword(String password){
    	this.password = password;
    }
    
    public void setname(String name){
    	this.name = name;
    }
    
    public void setphone(String phone){
    	this.phone = phone;
    }
    
    public void setcity(String city){
    	this.city = city;
    }
    
    public void setdeptNum(Integer deptNum){
    	this.deptNum = deptNum;
    }
    
    public void setisAdmin(String isAdmin){
    	this.isAdmin = isAdmin;
    }
    
    
   
}
