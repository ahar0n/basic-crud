CREATE DATABASE crud;
USE crud;

CREATE TABLE cliente(
  id int(5) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  apellido varchar(50) NOT NULL,
  telefono int(9) NOT NULL,
  email varchar(100) NOT NULL,
  PRIMARY KEY (id)
);