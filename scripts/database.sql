create database CRUD;

use CRUD;

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    idade INT NOT NULL,
    email VARCHAR(80) NOT NULL,
    telefone VARCHAR(15) NOT NULL
);