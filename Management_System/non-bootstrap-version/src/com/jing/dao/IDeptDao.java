package com.jing.dao;

import java.util.List;
import com.jing.domain.*;

public interface IDeptDao {
	public void insert(Dept dept);
    public void update(Dept dept);
    public void delete(Integer deptNum);
    public List<Object> findByAll();
    public Dept findById(Integer id);
    public Dept findByDeptNum(Integer deptNum);
    public Dept updateSynn(Dept deptNow, Dept dept, String[] arr);
}
