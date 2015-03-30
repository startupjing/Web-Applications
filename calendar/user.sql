create table user(
	name VARCHAR(50) NOT NULL,
 	username VARCHAR(50) NOT NULL,
 	password VARCHAR(200) NOT NULL,
 	email VARCHAR(50),  
 	primary key(username)
)engine = INNODB DEFAULT character SET = utf8 COLLATE = utf8_general_ci;