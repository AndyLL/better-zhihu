create table users{
	id int(10) unsigned not null auto_increment,
	username varchar(12) not null unique,
	password varchar(255) not null,

	primary key (id),
	unique key users_username_unique (username)
} engine=innodb;