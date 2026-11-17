-- =====================================================
-- schema.sql - PixelPro🎮
-- Ejecutar en phpMyAdmin / Laragon / XAMPP (MySQL 5.7+ / MariaDB)
-- =====================================================

CREATE DATABASE IF NOT EXISTS pixelpro_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pixelpro_db;

-- -----------------------------------------------------
-- Tablas maestras / secundarias
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS roles (
  id_rol INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS generos_usuario (
  id_genero INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categorias_juego (
  id_categoria INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tipos_publicacion (
  id_tipo INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS idiomas (
  id_idioma INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Usuarios (autenticación + datos personales + rol)
-- Campos tomados de formulario.php
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre_completo VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,            -- hash generado con password_hash() en PHP
  fecha_nacimiento DATE NULL,
  id_genero INT NULL,
  acepto_terminos TINYINT(1) NOT NULL DEFAULT 0,
  id_rol INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_rol) REFERENCES roles(id_rol),
  FOREIGN KEY (id_genero) REFERENCES generos_usuario(id_genero)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Juegos
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS juegos (
  id_juego INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  descripcion TEXT NULL,
  id_categoria INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_categoria) REFERENCES categorias_juego(id_categoria)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Tabla principal de negocio: publicaciones (blog y noticias)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS publicaciones (
  id_publicacion INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(200) NOT NULL,
  contenido TEXT NOT NULL,
  imagen VARCHAR(255) NULL,
  id_autor INT NOT NULL,
  id_tipo INT NOT NULL,
  id_juego INT NULL,                         -- una noticia puede no estar ligada a un juego propio
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_autor) REFERENCES usuarios(id_usuario),
  FOREIGN KEY (id_tipo) REFERENCES tipos_publicacion(id_tipo),
  FOREIGN KEY (id_juego) REFERENCES juegos(id_juego) ON DELETE SET NULL
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Comentarios de la comunidad
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS comentarios (
  id_comentario INT AUTO_INCREMENT PRIMARY KEY,
  id_publicacion INT NOT NULL,
  id_usuario INT NOT NULL,
  texto TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_publicacion) REFERENCES publicaciones(id_publicacion) ON DELETE CASCADE,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Formulario "Deseas unirte" + relación N:M con idiomas
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS solicitudes_union (
  id_solicitud INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  descripcion_personal TEXT NOT NULL,
  experiencia TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS solicitud_idioma (
  id_solicitud_idioma INT AUTO_INCREMENT PRIMARY KEY,
  id_solicitud INT NOT NULL,
  id_idioma INT NOT NULL,
  UNIQUE (id_solicitud, id_idioma),
  FOREIGN KEY (id_solicitud) REFERENCES solicitudes_union(id_solicitud) ON DELETE CASCADE,
  FOREIGN KEY (id_idioma) REFERENCES idiomas(id_idioma)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Índices explícitos (campos de filtrado / ordenamiento frecuente)
-- -----------------------------------------------------



-- Datos maestros necesarios para el registro y el CRUD.
INSERT IGNORE INTO roles (id_rol, nombre) VALUES (1,'admin'),(2,'usuario');
INSERT IGNORE INTO categorias_juego (id_categoria,nombre) VALUES (1,'Acción'),(2,'Estrategia'),(3,'Aventura'),(4,'Supervivencia');
INSERT IGNORE INTO tipos_publicacion (id_tipo,nombre) VALUES (1,'Noticia'),(2,'Blog');
INSERT IGNORE INTO generos_usuario (id_genero,nombre) VALUES (1,'Femenino'),(2,'Masculino'),(3,'Prefiero no decirlo');
INSERT IGNORE INTO idiomas (id_idioma,nombre) VALUES (1,'Español'),(2,'Inglés');
CREATE TABLE IF NOT EXISTS mensajes_contacto (
 id_mensaje INT AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(120) NOT NULL,
 email VARCHAR(150) NOT NULL,
 mensaje TEXT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_contacto_fecha (created_at)
) ENGINE=InnoDB;
