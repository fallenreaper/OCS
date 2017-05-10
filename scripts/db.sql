create table users(
	u_id int not null auto_increment,
	f_name varchar(30) not null,
	l_name varchar(30) not null,
	email  varchar(60) not null,
	dropped boolean not null,
	constraint users_pk primary key (u_id)
);

create table gear(
	g_id int not null auto_increment,
	name varchar(30) not null,
	itemCount int not null,
	showItem boolean not null,
	constraint gear_pk primary key (g_id)
);

create table gearAccountability(
	g_id int not null,
	u_id int not null,
	itemCount int not null,
	constraint acc_pk primary key (g_id, u_id)
);

create table gearType (
	id int not null auto_increment,
	name varchar(30) not null,
	constraint gearType_pk primary key ( id )
);

create table pt(
	dotw enum ("SUNDAY","MONDAY","TUESDAY","WEDNESDAY","THURSDAY","FRIDAY","SATURDAY") not null, 
	count double(6,2),
	workout varchar(30) not null,
	u_id int not null, 
	week datetime not null,
	constraint pt_pk primary key(u_id, dotw, workout, week)
	);

 create table coc( 
	position varchar(10) not null, 
	u_id int not null, 
	child int not null, 
	constraint coc_pk primary key (position)
	);
	
 create table cocChildMap ( 
	c_id int not null, 
	position varchar(10) not null 
	);