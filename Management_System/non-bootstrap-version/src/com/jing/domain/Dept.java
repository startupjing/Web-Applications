package com.jing.domain;


public class Dept {
   private Integer id;
   private Integer deptNum;
   private String deptName;
   private String deptInfo;
   private Integer empNum;
   
   public Integer getid(){
	   return this.id;
   }
   
   public void setid(Integer id){
	   this.id = id;
   }
   
   public Integer getdeptNum() {
	  return deptNum;
   }
   
   
   public void setdeptNum(Integer deptNum) {
	  this.deptNum = deptNum;
    }
   
   
   public String getdeptName() {
	  return deptName;
   }
   
   
   public void setdeptName(String deptName) {
	  this.deptName = deptName;
   }
   
   
   public String getdeptInfo() {
	  return deptInfo;
   }
   
   
   
   public void setdeptInfo(String deptInfo) {
	  this.deptInfo = deptInfo;
  }
   
   public Integer getempNum(){
	   return this.empNum;
   }
   
   public void setempNum(Integer empNum){
	   this.empNum = empNum;
   }
  
   
}
