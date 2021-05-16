-- create database 

-- shop table
create table shop(
s_id int auto_increment,
s_name varchar(40),
s_address varchar(50),
s_phone bigint,
s_owner varchar(20),
s_password varchar(100),
primary key(s_id),
index(s_name)
)ENGINE=INNODB;

insert into shop (s_name,s_address,s_phone,s_owner,s_password)
values(
'Give A Try Tailors','Vijayapura','7022172325','Revanth','ffc153f0c6a6fdedbc0fd992e106cb17'
);
-- select * from shop; 

-- customer table
create table customer(
c_id int auto_increment,
c_name varchar(20),
c_address varchar(50),
c_phone bigint unique,
c_mail varchar(30),
primary key(c_id),
index(c_phone)
)Engine=INNODB ;

insert into customer(c_name,c_address,c_phone,c_mail) values
('Prajwal KV','Koppa','7022172325','kvp2000@gmail.com'),
('Shivu G','Ballari',6362413466,'shivu@gmail.com'),
('Prajwal V','Bangalore',9448189904,'pk@gmail.com');
select * from customer;

-- Pant meassurements
create table pant(
mes_date date,
length int,
waist int,
knee_length int,
hip int,
thigh int,
bottom int,
c_id int,
constraint foreign key (c_id) references customer(c_id)
on delete cascade on update cascade
)ENGINE=INNODB;

-- shirt meassurements
create table shirt(
mes_date date,
chest int,
arm_hole int,
sleeves_half int,
sleeves int,
shoulder int,
length int,
cuff int,
neck int,
hip int,
waist int,
c_id int,
constraint foreign key (c_id) references customer(c_id)
on delete cascade on update cascade
) ENGINE=INNODB;

-- order
create table c_order(
o_id int auto_increment,
primary key(o_id),
o_date date,
o_type varchar(20),
quantity int,
o_status varchar(10),
delivery_date date,
c_id int,
s_id int,
constraint foreign key (c_id) references customer (c_id)
on delete cascade on update cascade,
constraint foreign key (s_id) references shop (s_id)
on delete cascade on update cascade
)Engine=Innodb;

-- bill
create table bill(
bill_id int auto_increment,
total int,
paid int,
due int,
c_id int,
s_id int,
o_id int,
primary key(bill_id),
constraint foreign key (c_id) references customer(c_id)
on delete cascade on update cascade,
constraint foreign key (s_id) references shop(s_id)
on delete cascade on update cascade,
constraint foreign key (o_id) references c_order(o_id)
on delete cascade on update cascade
)engine=innodb;

-- log table
create table logs(
    id integer not null AUTO_INCREMENT,
    c_id integer,
    action varchar(20),
    cdate datetime,
    PRIMARY KEY(id),
    constraint foreign key (c_id) references customer(c_id)
	on delete cascade on update cascade
    )ENGINE=innodb;

