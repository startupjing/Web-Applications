package com.jing.dao;

import java.util.List;
import org.springframework.orm.hibernate3.support.HibernateDaoSupport;
import com.jing.domain.UploadFile;
import com.jing.domain.User;

public class FileDao extends HibernateDaoSupport implements IFileDao{

	@Override
	public void insert(UploadFile file) {
		getHibernateTemplate().save(file);
		
	}

	@Override
	public List<Object> findByAll() {
		return getHibernateTemplate().find("from UploadFile file order by id asc");
	}

	@Override
	public UploadFile findById(Integer id) {
		return (UploadFile)getHibernateTemplate().get(UploadFile.class, id);
	}

	@Override
	public List<Object> findByName(String fileName) {
		return getHibernateTemplate().find("from UploadFile file where file.fileName='"+fileName+"'");
	}

}
