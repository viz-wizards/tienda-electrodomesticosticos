<?php

require_once __DIR__ . '/../views/helpers/auth_guard.php';
require_once __DIR__ . '/../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin.php?page=ventas');
    exit;
}

$db = (new Database())->connect();

if (!$db) {
    header('Location: ../admin.php?page=ventas&error=db');
    exit;
}

$idProducto = (int) ($_POST['id_producto'] ?? 0);
$cantidad = max(1, (int) ($_POST['cantidad'] ?? 1));
$productoStmt = $db->prepare("SELECT precio FROM productos WHERE id_producto = :id LIMIT 1");
$productoStmt->execute(['id' => $idProducto]);
$precioUnitario = (float) $productoStmt->fetchColumn();
$total = $precioUnitario * $cantidad;

$stmt = $db->prepare("INSERT INTO ventas (id_cliente, id_producto, cantidad, precio_unitario, total, fecha_venta, estado)
    VALUES (:cliente, :producto, :cantidad, :precio, :total, :fecha, :estado)");

$stmt->execute([
    'cliente' => (int) ($_POST['id_cliente'] ?? 0),
    'producto' => $idProducto,
    'cantidad' => $cantidad,
    'precio' => $precioUnitario,
    'total' => $total,
    'fecha' => $_POST['fecha_venta'] ?: date('Y-m-d'),
    'estado' => $_POST['estado'] ?? 'Pendiente',
]);

header('Location: ../admin.php?page=ventas&ok=created');
exit;
