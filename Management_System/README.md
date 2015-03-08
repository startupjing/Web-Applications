## Versions
+ Two versions of this system:
  - version without Bootstrap
  - version with Bootstrap--in progress


## Overview:
+ Java Web application using SpringMVC + Hibernate + SQL + Bootstrap

## Features:
+ user login and registration, all user and department information are stored in Orable database
+ employee personal page containing contact information
+ employee can upload and download files from file center
+ department page showing department information and all employees in the department
+ contact list containing all employee contacts which can be exported as PDF
+ JFree chart showing employee ratio on admin page
+ adminstration and management: admin can update/delete department and employee

## Procedure:
+ create java web application project using Maven template
+ update xml and add dependencies to support Spring and Hibernate framework
   - example: spring support, SQL support(Oracle), JDBC, Hibernate,etc
+ modify web.xml
   - create servlet and specify location of configuration file
   - servlet mapping to map servlet that should be invoked when client specifies url pattern
   - loader to integrate spring with web application
+ create spring configuration file
   - enable some namespaces 
   - create java beans and properties(databse)
     example: viewResolver(jsp), methodNameResolver(controller.html),sessionFactory(dao)
+ create JSP files for sign-up and login
   - first just simple html and css, later bootstrap
   - use jsp: mixture of html and java code
   - structure: login/signup/logout page, personal page, department page, update page, message page
   - some simple test: empty input(javascript window to alert), remain user session
   - use jQuery to validate information
+ create package for Controller, Model, Service
   - Model: User, Department, File
   - Dao: 
     + support database operations(insert,remove,search), extend Hibernate, FileDao,UserDao,DeptDao
     + need to configuration file to match properties consistent with database
     + create Hinerate template and pass query as string, set results display
     + fuzzy search
   - Service: where application logic goes, such as save information into database, verify user login information, check whether admin
   - Controller: where routing logic of application goes(whether signup or login action is called)
   - Utility: file upload time
+ create database schema in Oracle and update configuration
+ deploy application on Tomcat server


## Later work:
+ JFree chart
+ file export, upload, download
+ Bootstrap