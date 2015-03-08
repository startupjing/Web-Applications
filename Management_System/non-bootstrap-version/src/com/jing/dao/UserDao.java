package com.jing.dao;

import java.util.List;
import java.util.Map;

import org.hibernate.Query;
import org.hibernate.Session;
import org.springframework.jdbc.core.support.JdbcDaoSupport;
import org.springframework.orm.hibernate3.support.HibernateDaoSupport;
import org.springframework.transaction.annotation.Propagation;
import org.springframework.transaction.annotation.Transactional;

import com.jing.domain.User;

public class UserDao extends HibernateDaoSupport implements IUserDao{

	@Override
	@Transactional(propagation=Propagation.REQUIRED)
	public void insert(User u) {
	   getHibernateTemplate().save(u);
		
	}

	@Override
	@Transactional(propagation=Propagation.REQUIRED)
	public void update(User u) {
	   getHibernateTemplate().update(u);
	}

	@Override
	@Transactional(propagation=Propagation.REQUIRED)
	public void delete(Integer id) {
		User u =(User)getHibernateTemplate().load(User.class, id);
		getHibernateTemplate().delete(u);
	}

	@Override
	@Transactional(propagation=Propagation.REQUIRED)
	public List<Object> findByAll(int page, int pageSize) {
		Session session2 = getHibernateTemplate().getSessionFactory().getCurrentSession();
		Query q = session2.createQuery("from User order by id asc");
		q.setFirstResult((page-1)*pageSize);
		q.setMaxResults(pageSize);
		List<Object> list = q.list();
		return list;
	}
	
	@Override
	@Transactional(propagation=Propagation.REQUIRED)
	public List<Object> findAll() {
		return getHibernateTemplate().find("from User u order by id asc");
	}
    
	
	@Override
	@Transactional(propagation=Propagation.REQUIRED, readOnly=true)
	public User findById(Integer id) {
		return (User)getHibernateTemplate().get(User.class, id);
	}
	
	@Override
	@Transactional(propagation=Propagation.REQUIRED, readOnly=true)
	public List<Object> findByDept(Integer deptNum){
		return getHibernateTemplate().find("from User u where u.deptNum="+deptNum);
	}
	
	@Override
	@Transactional(propagation=Propagation.REQUIRED, readOnly=true)
	public List<Object> fuzzySearch(String keyword){
		return getHibernateTemplate().find("from User u where u.name like ?", "%"+keyword+"%");
	}
	
	@Override
	public List<Object> findByUsernamePassword(String username, String password){
		return (List<Object>)getHibernateTemplate().find("from User u where u.username='"+username+"' and u.password='"+password+"'");	
	}
	
	@Override
	public int findNum(String cmd){
		if(cmd.equals("all")){
			return getHibernateTemplate().find("from User").size();
		}else{
			return -1;
		}
	}
	
	@Override
	 public User updateSynn(User u1, User u2, String[] arr){
         u2.setusername(u1.getusername());
         u2.setid(u1.getid());
         
      	if(!arr[0].equals("")){
             u2.setpassword(arr[0]);
   	    }else{
   		     u2.setpassword(u1.getpassword());
   	    }
      	
      	
   	    if(!arr[1].equals("")){
            u2.setcity(arr[1]);
    	}else{
    		u2.setcity(u1.getcity());
    	}
   	    
   	    
     	if(!arr[2].equals("")){
           u2.setphone(arr[2]);
    	}else{
    		u2.setphone(u1.getphone());
    	}
     	
     	
     	if(!arr[3].equals("")){
            u2.setdeptNum(Integer.valueOf(arr[3]));
     	}else{
     		u2.setdeptNum(u1.getdeptNum());
     	}
     	
     	if(!arr[4].equals("")){
            u2.setname(arr[4]);
  	    }else{
  		     u2.setname(u1.getname());
  	    }
     	
     	u2.setisAdmin(u1.getisAdmin());
   
     	return u2;
   }

}
