package com.jing.dao;

import java.util.List;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;
import org.springframework.transaction.annotation.Propagation;
import org.springframework.transaction.annotation.Transactional;

import com.jing.domain.Dept;
import com.jing.domain.User;

public class DeptDao extends HibernateDaoSupport implements IDeptDao{

	@Override
	@Transactional(propagation=Propagation.REQUIRED)
	public void insert(Dept dept) {
		getHibernateTemplate().save(dept);	
	}

	@Override
	@Transactional(propagation=Propagation.REQUIRED)
	public void update(Dept dept) {
		getHibernateTemplate().update(dept);
	}

	@Override
	@Transactional(propagation=Propagation.REQUIRED)
	public void delete(Integer id) {
		Dept dept = (Dept)getHibernateTemplate().load(Dept.class, id);
		getHibernateTemplate().delete(dept);
	}

	@Override
	@Transactional(propagation=Propagation.REQUIRED, readOnly=true)
	public List<Object> findByAll() {
		return  getHibernateTemplate().find("from Dept dept order by id asc");
	}

	@Override
	@Transactional(propagation=Propagation.REQUIRED, readOnly=true)
	public Dept findById(Integer id) {
		return (Dept)getHibernateTemplate().get(Dept.class, id);
	}
	
	@Override
	@Transactional(propagation=Propagation.REQUIRED, readOnly=true)
	public Dept findByDeptNum(Integer deptNum) {
		return (Dept)getHibernateTemplate().get(Dept.class, deptNum);
	}
    
	
	
	
	@Override
	public Dept updateSynn(Dept deptNow, Dept dept, String[] arr){
		dept.setid(deptNow.getid());
    	dept.setdeptNum(deptNow.getdeptNum());
    	
    	if(!arr[0].equals("")){
            dept.setdeptName(arr[0]);
     	}else{
     	    dept.setdeptName(deptNow.getdeptName());
     	}
    	
    	if(!arr[1].equals("")){
            dept.setdeptInfo(arr[1]);
     	}else{
     		dept.setdeptInfo(deptNow.getdeptInfo());
     	}
    	return dept;
    	
	}
}
