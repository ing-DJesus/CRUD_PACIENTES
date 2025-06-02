
CREATE DATABASE IF NOT EXISTS pacientes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pacientes;


CREATE TABLE departamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);


CREATE TABLE municipios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    departamento_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    FOREIGN KEY (departamento_id) REFERENCES departamentos(id)
);


CREATE TABLE tipos_documento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);


CREATE TABLE genero (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);


CREATE TABLE paciente (
  id INT(10) NOT NULL AUTO_INCREMENT,
  tipo_documento_id INT(10) NOT NULL,
  numero_documento VARCHAR(30) COLLATE utf8_spanish2_ci NOT NULL,
  nombre1 VARCHAR(70) COLLATE utf8_spanish2_ci NOT NULL,
  nombre2 VARCHAR(70) COLLATE utf8_spanish2_ci DEFAULT NULL,
  apellido1 VARCHAR(70) COLLATE utf8_spanish2_ci NOT NULL,
  apellido2 VARCHAR(70) COLLATE utf8_spanish2_ci DEFAULT NULL,
  genero_id INT(10) NOT NULL,
  departamento_id INT(10) NOT NULL,
  municipio_id INT(10) NOT NULL,
  correo VARCHAR(100) COLLATE utf8_spanish2_ci NOT NULL,
  foto VARCHAR(535) COLLATE utf8_spanish2_ci DEFAULT NULL,
  paciente_creado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  paciente_actualizado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (tipo_documento_id) REFERENCES tipos_documento(id),
  FOREIGN KEY (genero_id) REFERENCES genero(id),
  FOREIGN KEY (departamento_id) REFERENCES departamentos(id),
  FOREIGN KEY (`municipio_id`) REFERENCES municipios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;





INSERT INTO tipos_documento (nombre) VALUES ('Cédula de Ciudadanía'), ('Tarjeta de Identidad');


INSERT INTO genero (nombre) VALUES ('Masculino'), ('Femenino');


INSERT INTO departamentos (nombre) VALUES 
('Cundinamarca'), ('Antioquia'), ('Valle del Cauca'), ('Bolívar'), ('Santander');


INSERT INTO municipios (departamento_id, nombre) VALUES
(1, 'Bogotá'), (1, 'Soacha'),
(2, 'Medellín'), (2, 'Bello'),
(3, 'Cali'), (3, 'Palmira'),
(4, 'Cartagena'), (4, 'Turbaco'),
(5, 'Bucaramanga'), (5, 'Floridablanca');


CREATE TABLE usuario (
    usuario_id INT(10) NOT NULL AUTO_INCREMENT,
    usuario_nombre VARCHAR(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    usuario_apellido VARCHAR(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    usuario_email VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    usuario_usuario VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    usuario_clave VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    usuario_foto VARCHAR(535) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    usuario_creado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    usuario_actualizado VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO usuario (
    usuario_id,
    usuario_nombre,
    usuario_apellido,
    usuario_email,
    usuario_usuario,
    usuario_clave,
    usuario_foto,
    usuario_creado,
    usuario_actualizado
) VALUES (
    1,
    'Administrador',
    'Principal',
    'admin@admin.com',
    'Administrador',
    '$2y$10$pyvmhby/SLxRS7TcQNa1eu1ru45X4dXb9KoEG5w6rLY...',
    'Administrador_52.png',
    '2025-06-01 19:39:37',
    '2025-06-01 18:39:37'
);





INSERT INTO paciente (
    tipo_documento_id, numero_documento, nombre1, nombre2, apellido1, apellido2, 
    genero_id, departamento_id, municipio_id, correo, foto
) VALUES
(1, '12345678', 'Juan', 'Carlos', 'Pérez', 'Gómez', 1, 1, 1, 'juan@example.com', NULL),
(2, '87654321', 'Ana', 'María', 'Rodríguez', 'López', 2, 2, 3, 'ana@example.com', NULL),
(1, '11223344', 'Luis', '', 'Martínez', 'Ruiz', 1, 3, 5, 'luis@example.com', NULL),
(1, '44332211', 'Laura', 'Isabel', 'Moreno', 'Castro', 2, 4, 7, 'laura@example.com', NULL),
(2, '55667788', 'Carlos', 'Eduardo', 'García', 'Díaz', 1, 5, 9, 'carlos@example.com', NULL);

