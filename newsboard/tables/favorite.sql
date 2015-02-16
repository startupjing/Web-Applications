create table favorite(
	favorite_id MEDIUMINT UNSIGNED NOT NULL auto_increment,
	story_id MEDIUMINT UNSIGNED,
	username VARCHAR(10),
	cat_name VARCHAR(50),
	primary key(favorite_id),
	foreign key(story_id) references story(story_id),
	foreign key(username) references user(username),
	foreign key(cat_name) references category(cat_name)
)engine = INNODB DEFAULT character SET = utf8 COLLATE = utf8_general_ci;