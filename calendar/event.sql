create table event(
	event_id MEDIUMINT UNSIGNED NOT NULL auto_increment,
	event_title VARCHAR(30) NOT NULL,
	event_note TEXT NOT NULL,
 	event_username VARCHAR(50) NOT NULL,
 	event_tag ENUM('entertainment','meeting','business','sports','other') NOT NULL,
 	event_date VARCHAR(50) NOT NULL,
 	primary key(event_id),
 	foreign key(event_username) references user(username)
)engine = INNODB DEFAULT character SET = utf8 COLLATE = utf8_general_ci;