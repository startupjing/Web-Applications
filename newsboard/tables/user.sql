create table user(
	name VARCHAR(50) NOT NULL,
 	username VARCHAR(10) NOT NULL,
 	password VARCHAR(10) NOT NULL,
 	email VARCHAR(50),  
 	primary key(username)
)engine = INNODB DEFAULT character SET = utf8 COLLATE = utf8_general_ci;
