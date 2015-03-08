package com.jing.dao;
import java.util.List;

import com.jing.domain.*;

public interface IFileDao {
   public void insert(UploadFile file);
   public List<Object> findByAll();
   public UploadFile findById(Integer id);
   public List<Object> findByName(String fileName);
}
