create database crud;
use crud;

create table cliente(
  id int(5) not null auto_increment,
  nombre varchar(50) not null,
  apellido varchar(50) not null,
  telefono int(9) not null,
  email varchar(100) not null,
  primary key (id)
);