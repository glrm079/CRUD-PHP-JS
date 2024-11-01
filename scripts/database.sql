create database CRUD;

use CRUD;

CREATE TABLE usuario (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(120) NOT NULL,
    Idade INT NOT NULL,
    Email VARCHAR(80) NOT NULL,
    Telefone VARCHAR(15) NOT NULL
);

select * from usuario;

truncate table usuario;