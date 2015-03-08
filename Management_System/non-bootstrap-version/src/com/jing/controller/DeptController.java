package com.jing.controller;
import java.util.ArrayList;

import java.util.List;
import java.util.Set;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import com.jing.dao.*;
import com.jing.domain.*;

import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.mvc.multiaction.MultiActionController;

public class DeptController extends MultiActionController{
    private IDeptDao deptDao;
    private IUserDao userDao;
    
    public IDeptDao getdeptDao(){
    	return this.deptDao;
    }
    
    public void setdeptDao(IDeptDao deptDao){
    	this.deptDao = deptDao;
    }
    
    public IUserDao getuserDao(){
    	return this.userDao;
    }
    
    public void setuserDao(IUserDao userDao){
    	this.userDao = userDao;
    }
    
    public ModelAndView insert(HttpServletRequest req, HttpServletResponse res){
    	Dept dept = new Dept();
    	dept.setdeptNum(Integer.valueOf(req.getParameter("deptNum")));
    	dept.setdeptName(req.getParameter("deptName"));
    	dept.setdeptInfo(req.getParameter("deptInfo"));
    	this.deptDao.insert(dept);
    	return new ModelAndView("index","message","Successfully inserted");
    }
    
    public ModelAndView update(HttpServletRequest req, HttpServletResponse res){
    	Integer id = Integer.valueOf(req.getParameter("id"));
    	Dept deptNow = this.deptDao.findById(id);
    	Dept dept = new Dept();
    	String[] arr = {req.getParameter("deptName"), req.getParameter("deptInfo")};
    	this.deptDao.update(this.deptDao.updateSynn(deptNow, dept,arr));
    	
    	ModelAndView mv = new ModelAndView("index");
        mv.addObject("message", "Successfully updated");
    	return mv;
    }
    
    public ModelAndView delete(HttpServletRequest req, HttpServletResponse res){
    	Integer id = Integer.valueOf(req.getParameter("id"));
    	Dept dept = this.deptDao.findById(id);
    	boolean isEmpty = this.userDao.findByDept(dept.getdeptNum()).isEmpty();
    	String message;
    	if(isEmpty){
    	   this.deptDao.delete(id);
    	   message = "Successfully deleted";
    	}else{
    		message = "Department is not empty";
    	}
    	ModelAndView mv = new ModelAndView("index");
        mv.addObject("message", message);
    	return mv;
    }
    
    public ModelAndView findByAll(HttpServletRequest req, HttpServletResponse res){
    	List<Object> list = this.deptDao.findByAll();
    	return new ModelAndView("displayAdmin","list", list);
    }

    public ModelAndView findById(HttpServletRequest req, HttpServletResponse res){
    	Integer id = Integer.valueOf(req.getParameter("id"));
    	Dept dept = this.deptDao.findById(id);
    	return new ModelAndView("updateDept", "dept", dept);
    }
    
    public ModelAndView showDept(HttpServletRequest req, HttpServletResponse res){
    	Integer id = Integer.valueOf(req.getParameter("id"));
    	Dept dept = this.deptDao.findById(id);
    	return new ModelAndView("deptEmp","dept",dept);
    }
    
    
  
}
