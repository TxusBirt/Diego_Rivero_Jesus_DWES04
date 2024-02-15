-- Active: 1707754906047@@127.0.0.1@3306
-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS diego_rivero_jesus_DwesBd04;

-- Seleccionar la base de datos
USE diego_rivero_jesus_DwesBd04;
-- Eliminar las tablas si existen
DROP TABLE IF EXISTS todoterrenos;
DROP TABLE IF EXISTS turismos;
DROP TABLE IF EXISTS furgonetas;
DROP TABLE IF EXISTS vehiculos;
DROP TABLE IF EXISTS usuarios;
-- Crear la tabla de usuarios
CREATE TABLE usuarios (
    usuario_id INT PRIMARY KEY,
    nombre VARCHAR(100),
    departamento VARCHAR(100)
);

-- Crear la tabla de vehiculos
CREATE TABLE vehiculos (
    id INT PRIMARY KEY,
    marca VARCHAR(100),
    modelo VARCHAR(100),
    kilometros INT,
    year INT,
    clase VARCHAR(30),
    disponible VARCHAR(3),
    prestado VARCHAR(3),
    fecha_inicio DATE,
    fecha_fin DATE,
    revision VARCHAR(3),
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id)
);

-- Crear la tabla de furgonetas
CREATE TABLE furgonetas (
    vehiculo_id INT PRIMARY KEY,
    capacidad VARCHAR(10),
    FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id)
);

-- Crear la tabla de turismos
CREATE TABLE turismos (
    vehiculo_id INT PRIMARY KEY,
    electrico VARCHAR(3),
    FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id)
);

-- Crear la tabla de todoterrenos
CREATE TABLE todoterrenos (
    vehiculo_id INT PRIMARY KEY,
    cuatro_por_cuatro VARCHAR(3),
    FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id)
);

-- Insertar datos en la tabla de usuarios
INSERT INTO usuarios (usuario_id, nombre, departamento) VALUES
(101, 'Laura', 'Topografia'),
(102, 'Rodrigo', 'Topografia'),
(103, 'Lucas', 'Gerente'),
(110, 'Laila', 'Administracion'),
(105, 'Marta', 'Geologia'),
(107, 'Pedro', 'Administracion');

-- Insertar datos en la tabla de vehiculos
INSERT INTO vehiculos (id, marca, modelo, kilometros, year, clase, disponible, prestado, fecha_inicio, fecha_fin,revision, usuario_id) VALUES
(1, 'suzuki', 'jinmy', 2000, 2023, 'todoterreno', 'si', 'si', '2023-01-22', '2023-04-01','si', 101),
(2, 'toyota', 'land_cruiser', 95000, 2020, 'todoterreno', 'si', 'si', '2023-01-26', '2023-03-01','si', 102),
(3, 'suzuki', 'vitara', 6000, 2021, 'turismo', 'si', 'si', '2023-02-01', '2023-02-13','si', 103),
(4, 'Honda', 'civic', 20000, 2020, 'turismo', 'si', 'si', '2023-01-25', '2023-02-05','si', 110),
(5, 'dacia', 'duster', 10000, 2020, 'todoterreno', 'si', 'si', '2023-01-26', '2023-03-01','si', 102),
(6, 'seat', 'ibiza', 8000, 2023, 'turismo', 'no', 'no', NULL, NULL, 'no', NULL ),
(7, 'renault', 'kangoo', 6000, 2022, 'furgoneta', 'si', 'no', NULL, NULL, 'no', NULL),
(8, 'ford', 'transit', 30000, 2021, 'furgoneta', 'no', 'no', NULL, NULL, 'no', NULL),
(9, 'opel', 'vivaro', 21000, 2022, 'furgoneta', 'si', 'no', '2023-02-04', '2023-04-04','si', 105),
(10, 'opel', 'astra', 100000, 2018, 'turismo', 'no', 'si', '2023-01-22', '2023-01-25','si', 107);

-- Insertar datos en la tabla de furgonetas
INSERT INTO furgonetas (vehiculo_id, capacidad) VALUES
(7, 'baja'),
(8, 'alta'),
(9, 'media');

-- Insertar datos en la tabla de turismos
INSERT INTO turismos (vehiculo_id, electrico) VALUES
(3, 'si'),
(4, 'si'),
(6, 'si'),
(10, 'no');

-- Insertar datos en la tabla de todoterrenos
INSERT INTO todoterrenos (vehiculo_id, cuatro_por_cuatro) VALUES
(1, 'si'),
(2, 'si'),
(5, 'si');
