DROP DATABASE IF EXISTS AgendaContactos;

CREATE DATABASE AgendaContactos;

USE AgendaContactos;

CREATE TABLE contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    phone_number VARCHAR(255)
);

INSERT INTO contactos (name, phone_number) VALUES ("Pepe", "123456789");
