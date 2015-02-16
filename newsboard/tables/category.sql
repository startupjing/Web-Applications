create table category(
	cat_name VARCHAR(50) NOT NULL,
	description VARCHAR(255),
	primary key(cat_name)
)engine = INNODB DEFAULT character SET = utf8 COLLATE = utf8_general_ci;