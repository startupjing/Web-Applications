package com.jing.controller;

import java.io.File;

import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.UnsupportedEncodingException;
import java.text.DateFormat;
import java.util.Date;
import java.util.Iterator;
import java.util.List;
import com.jing.util.*;
import com.jing.domain.*;
import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.mvc.multiaction.MultiActionController;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.fileupload.FileItem;
import org.apache.commons.fileupload.FileUploadException;
import org.apache.commons.fileupload.disk.DiskFileItemFactory;
import org.apache.commons.fileupload.servlet.ServletFileUpload;


import com.jing.dao.*;
import com.lowagie.text.*;
import com.lowagie.text.pdf.BaseFont;
import com.lowagie.text.pdf.PdfPCell;
import com.lowagie.text.pdf.PdfPTable;
import com.lowagie.text.pdf.PdfWriter;
public class FileController extends MultiActionController{
    private IFileDao fileDao;
    private IUserDao userDao;
    
    public IFileDao getfileDao(){
    	return this.fileDao;
    }
    
    public void setfileDao(IFileDao fileDao){
    	this.fileDao = fileDao;
    }
    
    public IUserDao getuserDao(){
    	return this.userDao;
    }
    
    public void setuserDao(IUserDao userDao){
    	this.userDao = userDao;
    }
    
    public ModelAndView upload(HttpServletRequest req, HttpServletResponse res) throws UnsupportedEncodingException{
    	String adjunctname;
    	@SuppressWarnings("deprecation")
		String fileDir = req.getRealPath("file/");
    	String message = "succesfully upload";
    	String addr = "";
    	String fileName = "";
    	String uploadName = "";
    	String downloadName = "";
    	
    	if(ServletFileUpload.isMultipartContent(req)){
    		DiskFileItemFactory factory = new DiskFileItemFactory();
    		factory.setSizeThreshold(20*1024);
    		factory.setRepository(factory.getRepository());
    		ServletFileUpload upload = new ServletFileUpload(factory);
    		upload.setHeaderEncoding("gbk");
    		int size = 2*1024*1024;
    		List formlists = null;
    		try{
    			formlists = upload.parseRequest(req);
    		}catch(FileUploadException e){
    			e.printStackTrace();
    		}
    		Iterator iter = formlists.iterator();
    		
    		
    		while(iter.hasNext()){
    			FileItem formitem = (FileItem)iter.next();
    			if(!formitem.isFormField()){
    				String name = formitem.getName();
    		
    			  if(formitem.getSize()>size){
    				  message = "file should be no large than 2MB";
    				  return new ModelAndView("index","message",message);
    			  }else{
    				  String adjunctsize = new Long(formitem.getSize()).toString();
    				  if((name==null) || (name.equals(""))&&(adjunctsize.equals("0"))) continue;
    				  adjunctname = name.substring(name.lastIndexOf("/")+1,name.length());
    				  addr = fileDir + "/" + adjunctname;
    				  addr = "/Users/jinglu/Documents/Workspace_MyEclip/LoginSystem/WebRoot/WEB-INF/file/"+adjunctname;
    				  
    				  File f = new File(adjunctname);
    				  try{
    					  formitem.write(f);
    				  }catch(Exception e){
    					  e.printStackTrace();
    				  }
    			  }
    		   }else{
    			   String formname = formitem.getFieldName();
    			   String con = formitem.getString("gbk");
    			   
    			   if(formname.equals("fileName")){
    				   fileName = con;
    			   }else if(formname.equals("restrict")){
    				   downloadName = con;
    			   }else if(formname.equals("uploadName")){
    				   uploadName = con;
    			   }
    		   }
    	    }
    		
    		UploadFile file = new UploadFile();
    		file.setAddr(addr);
    		file.setFileName(fileName);
    		file.setUploadName(uploadName);
    		file.setDownloadName(downloadName);
    		Date date = new Date();
        	DateFormat dateFormat = DateFormat.getDateInstance(DateFormat.FULL);
        	String time = dateFormat.format(date);	
    		file.setUploadTime(time);
    		this.fileDao.insert(file);
    	}
    	return new ModelAndView("index", "message", message);
      
    }
    
    public ModelAndView download(HttpServletRequest req, HttpServletResponse res) throws ServletException, IOException{
    	String fileName = req.getParameter("fileName");
    	String path = "/Applications/MyEclipse/Common/plugins/com.genuitec.eclipse.easie.tomcat.myeclipse_9.0.0.me201109141806/tomcat/bin/"+fileName;
    	path = new String(path.getBytes("iso-8859-1"));
    	File file = new File(path);
    	InputStream is = new FileInputStream(file);
    	OutputStream os = res.getOutputStream();
    	res.addHeader("Content-Length", file.length()+"");
    	res.setCharacterEncoding("gbk");
    	res.setContentType("application/octet-stream");
    	int data = 0;
    	while((data = is.read()) != -1){
    		os.write(data);
    	}
    	os.close();
    	is.close();
    	return null;
    }
    
    public ModelAndView showFile(HttpServletRequest req, HttpServletResponse res){
    	List<Object> list = this.fileDao.findByAll();
    	return new ModelAndView("download","list",list);
    }
    
    public ModelAndView export(HttpServletRequest req, HttpServletResponse res) throws Exception{
    	
//    	out.clear();
//    	out = pageContext.pushBody();
    	
    	res.setHeader("Content-Disposition","attachment;filename=stuInfo.pdf");
    	res.setContentType("application/x-download; charset=utf-8");
    	
    	
    	List<Object> list = this.userDao.findAll();
    	
    	BaseFont bf = BaseFont.createFont(BaseFont.HELVETICA,
    			BaseFont.WINANSI, BaseFont.NOT_EMBEDDED);
    	
    	Font font = new Font(bf, 12, Font.BOLD); 
    	Document document = new Document(PageSize.A4);			
    	PdfWriter.getInstance(document, res.getOutputStream());	
    	document.open();										
    	String title = "Employee Contacts"; 						
    	Paragraph paragraph = new Paragraph(title, font); 				
    	paragraph.setAlignment(Paragraph.ALIGN_CENTER);			
    	document.add(paragraph);								
    	PdfPTable table = new PdfPTable(3);						
    	table.setSpacingBefore(30f);								
    	String[] tableTitle = { "name", "phone", "city"};	
    	
    	
    	
    	for (int i = 0; i < tableTitle.length; i++) {						
    		paragraph = new Paragraph(tableTitle[i], new Font(bf, 10,Font.BOLD));
    		PdfPCell cell = new PdfPCell(paragraph);					
    		cell.setHorizontalAlignment(Element.ALIGN_CENTER);		
    		cell.setVerticalAlignment(Element.ALIGN_MIDDLE);			
    		table.addCell(cell);									
    	}
    	
    	for(int i=0;i<list.size();i++){
    	    User u = (User)list.get(i);
    	    PdfPCell cell1 = new PdfPCell(new Paragraph(u.getname(),
       					new Font(bf, 10)));
       	    cell1.setHorizontalAlignment(Element.ALIGN_CENTER);	
       	    cell1.setVerticalAlignment(Element.ALIGN_MIDDLE);		
       		table.addCell(cell1);	
       		
       		
       		
       		PdfPCell cell2 = new PdfPCell(new Paragraph(u.getphone(),
       					new Font(bf, 10)));	
       		cell2.setHorizontalAlignment(Element.ALIGN_CENTER);	
       	    cell2.setVerticalAlignment(Element.ALIGN_MIDDLE);		
       		table.addCell(cell2);
       		
       		
       		
       		PdfPCell cell3 = new PdfPCell(new Paragraph(u.getcity(),
       					new Font(bf, 10)));	
       		cell3.setHorizontalAlignment(Element.ALIGN_CENTER);	
       	    cell3.setVerticalAlignment(Element.ALIGN_MIDDLE);		
       		table.addCell(cell3);
    	}
    	document.add(table);									
    	document.close();
    	return null;
    }
    
    
    
}
