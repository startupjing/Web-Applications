create table story(
	story_id MEDIUMINT UNSIGNED NOT NULL auto_increment,
	username VARCHAR(10) NOT NULL,
	title varchar(50) not null,
	story_content TEXT NOT NULL,
	cat_name VARCHAR(50) NOT NULL,
	post_time DATETIME,
	
	primary key(story_id),
	foreign key(username) references user(username),
	foreign key(cat_name) references category(cat_name)
	
)engine = INNODB DEFAULT character SET = utf8 COLLATE = utf8_general_ci;