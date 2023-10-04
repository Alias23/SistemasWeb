GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
DROP DATABASE IF EXISTS agendacontactos; --Cuando funcione, hay que quitar esto

CREATE DATABASE agendacontactos;

USE agendacontactos;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    apellidos VARCHAR(255),
    DNI VARCHAR(255),
    phone_number VARCHAR(255),
    fecha_de_nacimiento VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

--DROP TABLE usuarios;

CREATE TABLE contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    apellidos VARCHAR(255),
    empresa VARCHAR(255),
    phone_number VARCHAR(255),
    second_phone_number VARCHAR(255),
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

DROP TABLE contactos;


-- INSERT INTO contactos (name, phone_number) VALUES ("Pepe", "123456789");
