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

INSERT INTO usuarios (name, apellidos, DNI, phone_number, fecha_de_nacimiento, email, password)
VALUES ('John', 'Doe', '123456789', '555-1234', '1990-01-01', 'john.doe@example.com', 'mypassword');
