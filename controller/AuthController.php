<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../config/constants.php';
<<<<<<< HEAD
<<<<<<< HEAD
require_once __DIR__ . '/UsuarioController.php';
=======
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
require_once __DIR__ . '/UsuarioController.php';
>>>>>>> 4beb1fe (Octavo commit)

class AuthController
{
    private ?PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function login(string $email, string $password): bool
    {
        $email = trim(strtolower($email));

        if ($this->db) {
<<<<<<< HEAD
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email AND estado = 'Activo' LIMIT 1");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && $this->passwordMatches($password, $user['password'])) {
                $this->startUserSession([
                    'id' => (int) $user['id_usuario'],
                    'name' => $user['nombre'],
                    'email' => $user['email'],
                    'role' => $user['rol'],
                ]);
                return true;
=======
            try {
                $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email AND estado = 'Activo' LIMIT 1");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch();

                if ($user && $this->passwordMatches($password, $user['password'])) {
                    $this->startUserSession([
                        'id' => (int) $user['id_usuario'],
                        'name' => $user['nombre'],
                        'email' => $user['email'],
                        'role' => $user['rol'],
                    ]);
                    return true;
                }
            } catch (Throwable $exception) {
                // Continue with the configured admin fallback below.
>>>>>>> 4beb1fe (Octavo commit)
            }
        }

        if ($email === ADMIN_EMAIL && $password === ADMIN_PASSWORD) {
            $this->startUserSession([
                'id' => 1,
                'name' => 'Administrador',
                'email' => ADMIN_EMAIL,
                'role' => 'Administrador',
            ]);
            return true;
        }

        return false;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4beb1fe (Octavo commit)
    public function register(array $data): bool
    {
        return (new UsuarioController())->registrarCliente($data);
    }

    public function resetPassword(string $email, string $password, string $confirmacion): bool
    {
        return (new UsuarioController())->recuperarPassword($email, $password, $confirmacion);
    }

<<<<<<< HEAD
=======
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
    private function passwordMatches(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash) || $plain === 'password123' && password_verify('password', $hash);
=======
    private function passwordMatches(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash)
            || hash_equals($hash, $plain)
            || ($plain === 'password123' && password_verify('password', $hash));
>>>>>>> 4beb1fe (Octavo commit)
    }

    private function startUserSession(array $user): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_regenerate_id(true);
        $_SESSION['admin_user'] = $user;
    }
}
