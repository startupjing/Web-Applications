package com.jing.dao;
import com.jing.domain.User;
import java.util.*;

public interface IUserDao {
    public void insert(User u);
    public void update(User u);
    public void delete(Integer id);
    public List<Object> findByAll(int page, int pageSize);
    public List<Object> findAll();
    public int findNum(String cmd);
    public List<Object> findByDept(Integer deptNum);
    public List<Object> fuzzySearch(String keyword);
    public User findById(Integer id);
	public User updateSynn(User userNow, User u, String[] arr);
	public List<Object> findByUsernamePassword(String username, String password);
	
}
