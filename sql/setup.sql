CREATE DATABASE IF NOT EXISTS agendacontactos;

USE agendacontactos;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    apellidos VARCHAR(255),
    DNI VARCHAR(255),
    phone_number VARCHAR(255),
    fecha_de_nacimiento VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);


CREATE TABLE IF NOT EXISTS contactos (
    id INT,
    email VARCHAR(255),
    name VARCHAR(255),
    apellidos VARCHAR(255),
    phone_number VARCHAR(255),
    id_usuario INT NOT NULL,
    primaria INT AUTO_INCREMENT PRIMARY KEY,
    FOREIGN KEY (id) REFERENCES usuarios(id),
    FOREIGN KEY (email) REFERENCES usuarios(email),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_emisor INT NOT NULL,
    id_receptor INT NOT NULL,
    mensaje TEXT,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_emisor) REFERENCES usuarios(id),
    FOREIGN KEY (id_receptor) REFERENCES usuarios(id)
);
