<?php

require_once __DIR__ . '/../views/helpers/auth_guard.php';
require_once __DIR__ . '/../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin.php?page=clientes');
    exit;
}

$db = (new Database())->connect();

if (!$db) {
    header('Location: ../admin.php?page=clientes&error=db');
    exit;
}

$stmt = $db->prepare("INSERT INTO clientes (nombres, apellidos, telefono, correo, direccion, estado)
    VALUES (:nombres, :apellidos, :telefono, :correo, :direccion, :estado)");

$stmt->execute([
    'nombres' => trim($_POST['nombres'] ?? ''),
    'apellidos' => trim($_POST['apellidos'] ?? ''),
    'telefono' => trim($_POST['telefono'] ?? ''),
    'correo' => trim($_POST['correo'] ?? ''),
    'direccion' => trim($_POST['direccion'] ?? ''),
    'estado' => $_POST['estado'] ?? 'Activo',
]);

header('Location: ../admin.php?page=clientes&ok=created');
exit;
