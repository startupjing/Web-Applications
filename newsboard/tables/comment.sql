create table comment(
	comment_id MEDIUMINT UNSIGNED NOT NULL auto_increment,
	story_id MEDIUMINT UNSIGNED NOT NULL,
	comment_content TEXT NOT NULL,
	username VARCHAR(50) NOT NULL,
	comment_time DATETIME,
	
	primary key(comment_id),
	foreign key(username) references user(username),
	foreign key(story_id) references story(story_id)
)engine = INNODB DEFAULT character SET = utf8 COLLATE = utf8_general_ci;