DROP DATABASE IF EXISTS emlaze_native_db;
CREATE DATABASE emlaze_native_db;
USE emlaze_native_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE productos(
    id INT PRIMARY KEY AUTO_INCREMENT,
    sku INT NOT NULL UNIQUE,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    cantidad FLOAT,
    precio FLOAT,
    total FLOAT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO productos (sku, nombre, descripcion, cantidad, precio, total) VALUES
(1001, 'Crema Hidratante',           'Crema Hidratante',           10, 100.00, 1000.00),
(1002, 'Aceite Corporal',            'Aceite Corporal',            5,  200.00, 1000.00),
(1003, 'Mascarilla Revitalizante',   'Mascarilla Revitalizante',   15, 50.00,  750.00),
(1004, 'Gel Limpiador Facial',       'Gel Limpiador Facial',       15, 70.00,  1050.00),
(1005, 'Sérum Antiarrugas',          'Sérum Antiarrugas',          8,  200.00, 1600.00),
(1006, 'Tónico Facial Refrescante',  'Tónico Facial Refrescante',  16, 83.33,  1333.28),
(1007, 'Bálsamo Reparador',          'Bálsamo Reparador',          25, 20.00,  500.00),
(1008, 'Crema Exfoliante Suave',     'Crema Exfoliante Suave',     40, 33.33,  1333.20),
(1009, 'Loción Corporal Nutritiva',  'Loción Corporal Nutritiva',  30, 55.56,  1666.80),
(1010, 'Crema Solar Protectora',     'Crema Solar Protectora',     22, 90.00,  1980.00);


INSERT INTO users (username, password, email) VALUES
('admin', 'd63a86150844363b8bbca85e5872a80d306ff958a063e19efdfe15df762ea8e3', 'admin@test.com');