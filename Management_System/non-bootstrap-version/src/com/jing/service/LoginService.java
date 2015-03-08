package com.jing.service;
import com.jing.dao.*;

import com.jing.domain.*;
import java.util.*;


public class LoginService implements ILoginService{
	private IUserDao userDao;
	private IDeptDao deptDao;
	
    public IUserDao getuserDao(){
    	return this.userDao;
    }
    public void setuserDao(IUserDao userDao){
    	this.userDao = userDao;
    }
    
    public IDeptDao getdeptDao(){
    	return this.deptDao;
    }
    public void setdeptDao(IDeptDao deptDao){
    	this.deptDao = deptDao;
    }
     
    public boolean checkLogin(User u){
       List<Object> list = this.userDao.findByUsernamePassword(u.getusername(), u.getpassword());	
       return !list.isEmpty();
    }
    
    public boolean checkAdmin(User u){
    	List<Object> list = this.userDao.findByUsernamePassword(u.getusername(), u.getpassword());
    	if(!list.isEmpty()){
    		User user = (User)list.get(0);
    		return user.getisAdmin().equals("0");
    	}
    	return false;
    }
    
    public User findAdmin(User u){
    	List<Object> list = this.userDao.findByUsernamePassword(u.getusername(), u.getpassword());
    	return (User)list.get(0);
    }
    
    
   
     
}
