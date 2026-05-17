<?php

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
$_GET['entity'] = 'productos';
require __DIR__ . '/admin_delete.php';
=======
require_once __DIR__ . '/../views/helpers/auth_guard.php';
require_once __DIR__ . '/../config/Database.php';

$db = (new Database())->connect();
$id = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);

if ($db && $id > 0) {
    $stmt = $db->prepare("UPDATE productos SET estado = 'Inactivo' WHERE id_producto = :id");
    $stmt->execute(['id' => $id]);
}

header('Location: ../admin.php?page=productos&ok=deleted');
exit;
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
$_GET['entity'] = 'productos';
require __DIR__ . '/admin_delete.php';
>>>>>>> 4beb1fe (Octavo commit)
=======
$_GET['entity'] = 'productos';
require __DIR__ . '/admin_delete.php';
>>>>>>> d42ad1c (Noveno commit)
