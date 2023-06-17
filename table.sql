CREATE DATABASE curso_sql;

USE curso_sql;

CREATE TABLE users (
	per_name VARCHAR (20),
	first_surname VARCHAR (20),
    second_surname VARCHAR (20),
    email VARCHAR (20) PRIMARY KEY,
    login VARCHAR (20),
    psswd VARCHAR (8)
)