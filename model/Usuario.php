<?php

require_once __DIR__ . '/CrudModel.php';

class Usuario extends CrudModel
{
    protected string $table = 'usuarios';
    protected string $primaryKey = 'id_usuario';
    protected array $fillable = ['nombre', 'email', 'password', 'rol', 'estado'];

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
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
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

            $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, email, password, rol, estado)
                VALUES (:nombre, :email, :password, 'Cliente', 'Activo')");
            $stmt->execute([
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
    }
}
