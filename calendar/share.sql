create table share(
	share_id MEDIUMINT UNSIGNED NOT NULL auto_increment,
	event_id MEDIUMINT UNSIGNED NOT NULL,
	share_username VARCHAR(50) NOT NULL,
	primary key(share_id),
	foreign key(event_id) references event(event_id),
	foreign key(share_username) references user(username)
)engine = INNODB DEFAULT character SET = utf8 COLLATE = utf8_general_ci;