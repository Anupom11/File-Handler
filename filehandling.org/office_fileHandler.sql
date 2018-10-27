
create database office_file_handling;

use office_file_handling;

create table user_account
(
	user_name varchar(50) not null,
	password varchar(100) not null,
	user_id varchar(50) primary key
);

create table document_details
(
	file_index varchar(100),
	date_val date,
	matters varchar(500),
	note_sheet varchar(200),
	corr_note_sheet varchar(200),
	nst_file_address varchar(200),
	cnst_file_address varchar(200),
	sl_no int auto_increment primary key
);

create table admin_account
(
	admin_name varchar(100) not null,
	password varchar(100) not null,
	admin_id varchar(50) primary key
);
