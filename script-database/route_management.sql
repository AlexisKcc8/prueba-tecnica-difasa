-- Crear base de datos 
CREATE DATABASE IF NOT EXISTS route_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE route_management;

-- Tabla: choferes 
CREATE TABLE IF NOT EXISTS choferes ( 
  id INT AUTO_INCREMENT PRIMARY KEY, 
  nombre VARCHAR(100) NOT NULL, 
  telefono VARCHAR(30) NULL, 
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
) ENGINE=InnoDB; 

-- Tabla: rutas 
CREATE TABLE IF NOT EXISTS rutas ( 
  id INT AUTO_INCREMENT PRIMARY KEY, 
  nombre VARCHAR(100) NOT NULL, 
  fecha DATE NOT NULL, 
  id_chofer INT NULL, 
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  CONSTRAINT fk_routes_driver FOREIGN KEY (id_chofer) 
  REFERENCES choferes(id) 
  ON DELETE SET NULL 
  ON UPDATE CASCADE 
) ENGINE=InnoDB; 

-- Tabla: puntos_entrega 
CREATE TABLE IF NOT EXISTS puntos_entrega ( 
  id INT AUTO_INCREMENT PRIMARY KEY, 
  id_ruta INT NOT NULL, 
  direccion VARCHAR(255) NOT NULL, 
  orden INT NOT NULL, 
  entregado TINYINT(1) NOT NULL DEFAULT 0, 
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  CONSTRAINT fk_stops_route FOREIGN KEY (id_ruta) 
  REFERENCES rutas(id) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE, 
  INDEX idx_stops_route_orden (id_ruta, orden) 
) ENGINE=InnoDB;