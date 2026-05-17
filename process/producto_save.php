<?php

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
$_POST['entity'] = 'productos';
require __DIR__ . '/admin_save.php';
=======
require_once __DIR__ . '/../views/helpers/auth_guard.php';
require_once __DIR__ . '/../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin.php?page=productos');
    exit;
}

$db = (new Database())->connect();

if (!$db) {
    header('Location: ../admin.php?page=productos&error=db');
    exit;
}

$stmt = $db->prepare("INSERT INTO productos (id_categoria, id_proveedor, nombre, descripcion, precio, stock, imagen, estado)
    VALUES (:categoria, :proveedor, :nombre, :descripcion, :precio, :stock, :imagen, :estado)");

$stmt->execute([
    'categoria' => $_POST['id_categoria'] ?: null,
    'proveedor' => $_POST['id_proveedor'] ?: null,
    'nombre' => trim($_POST['nombre'] ?? ''),
    'descripcion' => trim($_POST['descripcion'] ?? ''),
    'precio' => (float) ($_POST['precio'] ?? 0),
    'stock' => (int) ($_POST['stock'] ?? 0),
    'imagen' => trim($_POST['imagen'] ?? ''),
    'estado' => $_POST['estado'] ?? 'Disponible',
]);

header('Location: ../admin.php?page=productos&ok=created');
exit;
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
$_POST['entity'] = 'productos';
require __DIR__ . '/admin_save.php';
>>>>>>> 4beb1fe (Octavo commit)
=======
$_POST['entity'] = 'productos';
require __DIR__ . '/admin_save.php';
>>>>>>> d42ad1c (Noveno commit)
