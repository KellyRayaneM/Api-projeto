CREATE DATABASE IF NOT EXISTS dbtransacao;

USE dbtransacao;

CREATE TABLE IF NOT EXISTS user (
  id_user  int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(150),
  email varchar (150),
  password varchar(8),
  type_document enum ('cpf','cnpj'),
  document varchar(15),
  PRIMARY KEY (`id_user`)
);

INSERT INTO user VALUE(0, "Kelly Lima", "kelly@email.com", "4787878", "cpf", "0555887878" );
INSERT INTO user VALUE(0, "Rayane Mendonça", "rayane@email.com", "9898989", "cpf", "045327878" );

