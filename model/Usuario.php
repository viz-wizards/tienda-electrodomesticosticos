<?php

require_once __DIR__ . '/CrudModel.php';

class Usuario extends CrudModel
{
    protected string $table = 'usuarios';
    protected string $primaryKey = 'id_usuario';
    protected array $fillable = ['id_rol', 'nombre', 'email', 'password', 'rol', 'estado'];

    public function __construct()
    {
        parent::__construct();
        $this->ensureUserSchema();
    }

    public function listar(string $orderBy = 'creado_en DESC'): array
    {
        return parent::listar($orderBy);
    }

    public function guardar(array $data): bool
    {
        $id = (int) ($data['id_usuario'] ?? 0);

        if ($id <= 0 && trim($data['password'] ?? '') === '') {
            return false;
        }

        $data['email'] = trim(strtolower($data['email'] ?? ''));
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if ($id <= 0 && $this->buscarPorEmail($data['email'])) {
            return false;
        }

        $data['id_rol'] = $this->roleId($data['rol'] ?? 'Cliente');

        if (($data['password'] ?? '') === '') {
            unset($data['password']);
        }

        if (!empty($data['password']) && password_get_info($data['password'])['algo'] === 0) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return parent::guardar($data);
    }

    public function buscarPorEmail(string $email): ?array
    {
        if (!$this->db) {
            return null;
        }

        try {
<<<<<<< HEAD
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
=======
            $stmt = $this->db->prepare("SELECT id_usuario, nombre, email, password, rol, estado, creado_en FROM usuarios WHERE email = :email LIMIT 1");
>>>>>>> d42ad1c (Noveno commit)
            $stmt->execute(['email' => trim(strtolower($email))]);
            $user = $stmt->fetch();
        } catch (Throwable $exception) {
            return null;
        }

        return $user ?: null;
    }

    public function registrarCliente(array $data): bool
    {
        if (!$this->db) {
            return false;
        }

        $nombre = trim($data['nombre'] ?? '');
        $email = trim(strtolower($data['email'] ?? ''));
        $password = (string) ($data['password'] ?? '');

        if ($nombre === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
            return false;
        }

        if ($this->buscarPorEmail($email)) {
            return false;
        }

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO usuarios (id_rol, nombre, email, password, rol, estado)
                VALUES (:id_rol, :nombre, :email, :password, 'Cliente', 'Activo')");
            $stmt->execute([
                'id_rol' => $this->roleId('Cliente'),
                'nombre' => $nombre,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);

            $idUsuario = (int) $this->db->lastInsertId();
            $parts = preg_split('/\s+/', $nombre, 2);
            $nombres = $parts[0] ?? $nombre;
            $apellidos = $parts[1] ?? '';

            $stmt = $this->db->prepare("INSERT INTO clientes (id_usuario, nombres, apellidos, telefono, correo, direccion, estado)
                VALUES (:id_usuario, :nombres, :apellidos, :telefono, :correo, :direccion, 'Activo')");
            $stmt->execute([
                'id_usuario' => $idUsuario,
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'telefono' => trim($data['telefono'] ?? ''),
                'correo' => $email,
                'direccion' => trim($data['direccion'] ?? ''),
            ]);

            return $this->db->commit();
        } catch (Throwable $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }

    public function actualizarPassword(string $email, string $password): bool
    {
        if (!$this->db || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
            return false;
        }

        try {
            $stmt = $this->db->prepare("UPDATE usuarios SET password = :password WHERE email = :email AND estado = 'Activo'");
            $stmt->execute([
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'email' => trim(strtolower($email)),
            ]);

            return $stmt->rowCount() > 0;
        } catch (Throwable $exception) {
            return false;
        }
<<<<<<< HEAD
=======
    }

    private function ensureUserSchema(): void
    {
        if (!$this->db) {
            return;
        }

        try {
            $this->db->exec("CREATE TABLE IF NOT EXISTS usuarios (
                id_usuario INT AUTO_INCREMENT PRIMARY KEY,
                id_rol INT NULL,
                nombre VARCHAR(100) NOT NULL,
                email VARCHAR(120) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                rol ENUM('Administrador','Empleado','Cliente') DEFAULT 'Cliente',
                estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
                creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            $this->addColumnIfMissing('usuarios', 'id_rol', 'INT NULL AFTER id_usuario');
            $this->db->exec("ALTER TABLE usuarios MODIFY id_rol INT NULL");
            $this->addColumnIfMissing('usuarios', 'rol', "ENUM('Administrador','Empleado','Cliente') DEFAULT 'Cliente' AFTER password");
            $this->addColumnIfMissing('usuarios', 'estado', "ENUM('Activo','Inactivo') DEFAULT 'Activo' AFTER rol");
            $this->addColumnIfMissing('usuarios', 'creado_en', 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER estado');

            if ($this->tableExists('usuario')) {
                $this->db->exec("INSERT IGNORE INTO usuarios (id_usuario, id_rol, nombre, email, password, rol, estado, creado_en)
                    SELECT id_usuario, id_rol, nombre, correo, clave,
                        CASE WHEN id_rol = 1 THEN 'Administrador' WHEN id_rol = 2 THEN 'Empleado' ELSE 'Cliente' END,
                        estado, creado_en
                    FROM usuario");
            }

            if ($this->tableExists('clientes')) {
                $this->addColumnIfMissing('clientes', 'id_usuario', 'INT NULL AFTER id_cliente');
            }
        } catch (Throwable $exception) {
            // The app can still use the configured demo admin when schema repair is not allowed.
        }
    }

    private function tableExists(string $table): bool
    {
        try {
            $stmt = $this->db->prepare("SHOW TABLES LIKE :table");
            $stmt->execute(['table' => $table]);
            return (bool) $stmt->fetchColumn();
        } catch (Throwable $exception) {
            return false;
        }
    }

    private function columnExists(string $table, string $column): bool
    {
        try {
            $stmt = $this->db->prepare("SHOW COLUMNS FROM {$table} LIKE :column");
            $stmt->execute(['column' => $column]);
            return (bool) $stmt->fetchColumn();
        } catch (Throwable $exception) {
            return false;
        }
    }

    private function addColumnIfMissing(string $table, string $column, string $definition): void
    {
        if (!$this->columnExists($table, $column)) {
            $this->db->exec("ALTER TABLE {$table} ADD COLUMN {$column} {$definition}");
        }
    }

    private function roleId(string $role): ?int
    {
        if ($role === 'Administrador') {
            return 1;
        }

        if ($role === 'Empleado') {
            return 2;
        }

        return null;
>>>>>>> d42ad1c (Noveno commit)
    }
}
