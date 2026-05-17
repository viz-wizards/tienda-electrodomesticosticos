<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/views/helpers/helpers.php';
require_once __DIR__ . '/model/Producto.php';

<<<<<<< HEAD
<<<<<<< HEAD
$productoModel = new Producto();
$page = $_GET['page'] ?? 'home';
<<<<<<< HEAD
$allowedPages = ['home', 'producto', 'categoria', 'contacto', 'nosotros', 'terminos', 'login', 'registro', 'recuperar'];
=======
$allowedPages = ['home', 'producto', 'categoria', 'contacto', 'nosotros', 'terminos', 'login', 'registro'];
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf

if (!in_array($page, $allowedPages, true)) {
    http_response_code(404);
    $page = 'home';
}

$categories = $productoModel->categorias();
$query = trim($_GET['q'] ?? '');
$products = $query !== '' ? $productoModel->buscar($query) : $productoModel->destacados();
$currentProduct = null;

if ($page === 'producto') {
    $currentProduct = $productoModel->encontrar((int) ($_GET['id'] ?? 0));
}

if ($page === 'categoria') {
    $categoryId = (int) ($_GET['id'] ?? 0);
    $products = $productoModel->porCategoria($categoryId);
=======
=======
>>>>>>> d42ad1c (Noveno commit)
$allowedPages = ['home', 'categoria', 'producto', 'nosotros', 'contacto', 'login', 'registro', 'recuperar', 'terminos'];
$page = $_GET['page'] ?? 'home';

if (!in_array($page, $allowedPages, true)) {
    $page = 'home';
}

$productoModel = new Producto();
$categories = $productoModel->categorias();
$products = [];
$currentProduct = null;
$query = trim($_GET['q'] ?? '');

if ($page === 'categoria') {
    $products = $productoModel->porCategoria((int) ($_GET['id'] ?? 0));
} elseif ($page === 'producto') {
    $currentProduct = $productoModel->encontrar((int) ($_GET['id'] ?? 0));
} elseif ($page === 'home') {
    $products = $query !== '' ? $productoModel->buscar($query) : $productoModel->destacados();
<<<<<<< HEAD
>>>>>>> 4beb1fe (Octavo commit)
=======
>>>>>>> d42ad1c (Noveno commit)
}

include __DIR__ . '/views/public/layout.php';
