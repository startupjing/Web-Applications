package com.jing.service;
import com.jing.domain.*;

public interface ILoginService {
   public boolean checkLogin(User u);
   public boolean checkAdmin(User u);
}
