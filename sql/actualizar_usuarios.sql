USE Tienda_de_electrodomesticos;

CREATE TABLE IF NOT EXISTS roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO roles (id_rol, nombre, descripcion) VALUES
(1, 'Administrador', 'Control total del sistema'),
(2, 'Vendedor', 'Gestiona ventas y clientes'),
(3, 'Cliente', 'Cuenta de comprador');

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_rol INT NULL,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('Administrador','Empleado','Cliente') DEFAULT 'Cliente',
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE usuarios MODIFY id_rol INT NULL;

DROP PROCEDURE IF EXISTS migrar_usuario_antiguo;

DELIMITER //
CREATE PROCEDURE migrar_usuario_antiguo()
BEGIN
    IF EXISTS (
        SELECT 1
        FROM information_schema.tables
        WHERE table_schema = DATABASE()
          AND table_name = 'usuario'
    ) THEN
        INSERT IGNORE INTO usuarios (id_usuario, id_rol, nombre, email, password, rol, estado, creado_en)
        SELECT id_usuario, id_rol, nombre, correo, clave,
            CASE WHEN id_rol = 1 THEN 'Administrador' WHEN id_rol = 2 THEN 'Empleado' ELSE 'Cliente' END,
            estado, creado_en
        FROM usuario;
    END IF;
END//
DELIMITER ;

CALL migrar_usuario_antiguo();
DROP PROCEDURE migrar_usuario_antiguo;

INSERT IGNORE INTO usuarios (id_rol, nombre, email, password, rol, estado) VALUES
(1, 'Admin Principal', 'admin@electrohogar.com', 'password123', 'Administrador', 'Activo');

ALTER TABLE clientes ADD COLUMN IF NOT EXISTS id_usuario INT NULL AFTER id_cliente;
