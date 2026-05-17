CREATE DATABASE IF NOT EXISTS Tienda_de_electrodomesticos
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE Tienda_de_electrodomesticos;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS notificaciones;
DROP TABLE IF EXISTS movimientos_stock;
DROP TABLE IF EXISTS pagos;
DROP TABLE IF EXISTS ventas;
DROP TABLE IF EXISTS cotizaciones;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS proveedores;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS roles;

SET FOREIGN_KEY_CHECKS = 1;

-- =========================
-- ROLES
-- =========================
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB;

-- =========================
-- USUARIOS
-- =========================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_rol INT NULL,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('Administrador','Empleado','Cliente') DEFAULT 'Cliente',
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
) ENGINE=InnoDB;

-- =========================
-- NOTIFICACIONES
-- =========================
CREATE TABLE notificaciones (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    mensaje TEXT NOT NULL,
    tipo ENUM('info','alerta','exito','error') DEFAULT 'info',
    leido BOOLEAN DEFAULT FALSE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- =========================
-- CLIENTES
-- =========================
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NULL,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono VARCHAR(30),
    correo VARCHAR(120),
    direccion VARCHAR(180),
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- =========================
-- CATEGORIAS
-- =========================
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================
-- PROVEEDORES
-- =========================
CREATE TABLE proveedores (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    razon_social VARCHAR(120) NOT NULL,
    ruc VARCHAR(20),
    telefono VARCHAR(30),
    correo VARCHAR(120),
    direccion VARCHAR(180),
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================
-- PRODUCTOS
-- =========================
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT NULL,
    id_proveedor INT NULL,
    nombre VARCHAR(120) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock INT NOT NULL DEFAULT 0,
    imagen VARCHAR(255),
    estado ENUM('Disponible','Agotado','Inactivo') DEFAULT 'Disponible',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor)
) ENGINE=InnoDB;

-- =========================
-- COTIZACIONES
-- =========================
CREATE TABLE cotizaciones (
    id_cotizacion INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT DEFAULT 1,
    observacion TEXT,
    estado ENUM('Pendiente','Respondido','Aprobado','Rechazado') DEFAULT 'Pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
) ENGINE=InnoDB;

-- =========================
-- VENTAS
-- =========================
CREATE TABLE ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    fecha_venta DATE NOT NULL,
    estado ENUM('Pendiente','Pagado','Anulado','Entregado') DEFAULT 'Pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
) ENGINE=InnoDB;

-- =========================
-- PAGOS
-- =========================
CREATE TABLE pagos (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    metodo_pago ENUM('Efectivo','Tarjeta','Yape','Plin','Transferencia') DEFAULT 'Efectivo',
    fecha_pago DATE NOT NULL,
    estado ENUM('Pagado','Pendiente','Anulado') DEFAULT 'Pagado',
    observacion TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_venta) REFERENCES ventas(id_venta)
) ENGINE=InnoDB;

-- =========================
-- MOVIMIENTOS DE STOCK
-- =========================
CREATE TABLE movimientos_stock (
    id_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    tipo ENUM('entrada','salida') NOT NULL,
    cantidad INT NOT NULL,
    motivo VARCHAR(150),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
) ENGINE=InnoDB;

-- =========================
-- DATOS INICIALES
-- =========================

INSERT INTO roles (nombre, descripcion) VALUES
('Administrador','Control total del sistema'),
('Vendedor','Gestiona ventas y clientes'),
('Cliente','Cuenta de comprador');

INSERT INTO usuarios (id_rol, nombre, email, password, rol, estado) VALUES
(1, 'Admin Principal', 'admin@electrohogar.com', 'password123', 'Administrador', 'Activo'),
(1, 'Admin SENATI', '1590173@senati.pe', '123456', 'Administrador', 'Activo');

INSERT INTO categorias (nombre, descripcion) VALUES
('Laptops','Computadoras portátiles'),
('Celulares','Smartphones modernos'),
('Televisores','Smart TV y LED'),
('Electrodomésticos','Refrigeradoras, lavadoras, etc.');

INSERT INTO proveedores (razon_social, ruc, telefono, correo, direccion) VALUES
('Tech Import SAC','20547896321','999888777','ventas@tech.com','Av. Industrial 123'),
('Global Electro','20457896325','988777666','contacto@global.com','Jr. Comercio 456');

INSERT INTO clientes (nombres, apellidos, telefono, correo, direccion) VALUES
('Juan','Perez','987654321','juan@gmail.com','Av Lima 123'),
('Maria','Torres','955444333','maria@gmail.com','Jr Central 456');

INSERT INTO productos (id_categoria,id_proveedor,nombre,descripcion,precio,stock,imagen,estado) VALUES
(1,1,'Laptop Lenovo','Ryzen 5 8GB RAM SSD 512GB',2500,10,'laptop.jpg','Disponible'),
(2,2,'Samsung Galaxy A54','128GB cámara HD',1400,15,'celular.jpg','Disponible'),
(3,1,'Smart TV LG 50','4K Ultra HD',1800,8,'tv.jpg','Disponible');

INSERT INTO ventas (id_cliente,id_producto,cantidad,precio_unitario,total,fecha_venta,estado) VALUES
(1,1,1,2500,2500,CURDATE(),'Pagado');

INSERT INTO pagos (id_venta,monto,metodo_pago,fecha_pago,estado,observacion) VALUES
(1,2500,'Transferencia',CURDATE(),'Pagado','Pago completo');

INSERT INTO notificaciones (id_usuario,titulo,mensaje,tipo) VALUES
(1,'Bienvenido','Sistema iniciado correctamente','exito');

INSERT INTO movimientos_stock (id_producto,tipo,cantidad,motivo) VALUES
(1,'entrada',10,'Stock inicial');
