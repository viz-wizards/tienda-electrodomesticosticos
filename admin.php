<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/views/helpers/helpers.php';
require_once __DIR__ . '/views/helpers/auth_guard.php';
require_once __DIR__ . '/config/Database.php';

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4beb1fe (Octavo commit)
$section = $_GET['section'] ?? 'dashboard';
$allowedSections = ['dashboard', 'productos', 'categorias', 'clientes', 'proveedores', 'ventas', 'pagos', 'usuarios'];

if (!in_array($section, $allowedSections, true)) {
    $section = 'dashboard';
}

$db = (new Database())->connect();
<<<<<<< HEAD
=======
$db = (new Database())->connect();
$adminPage = $_GET['page'] ?? 'dashboard';
$allowedAdminPages = ['dashboard', 'productos', 'clientes', 'ventas'];

if (!in_array($adminPage, $allowedAdminPages, true)) {
    $adminPage = 'dashboard';
}

>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
$dbAvailable = $db !== null;
>>>>>>> 4beb1fe (Octavo commit)
$stats = [
    'productos' => 8,
    'clientes' => 3,
    'ventas' => 6,
    'ingresos' => 8492,
];
$recentSales = [];
<<<<<<< HEAD
<<<<<<< HEAD
=======
$products = [];
$clients = [];
$sales = [];
$categories = [];
$providers = [];
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf

if ($db) {
    $stats['productos'] = (int) $db->query("SELECT COUNT(*) FROM productos")->fetchColumn();
    $stats['clientes'] = (int) $db->query("SELECT COUNT(*) FROM clientes")->fetchColumn();
    $stats['ventas'] = (int) $db->query("SELECT COUNT(*) FROM ventas")->fetchColumn();
    $stats['ingresos'] = (float) $db->query("SELECT COALESCE(SUM(total), 0) FROM ventas WHERE estado <> 'Anulado'")->fetchColumn();

    $recentSales = $db->query("SELECT v.id_venta, v.fecha_venta, v.total, v.estado, c.nombres, c.apellidos, p.nombre AS producto
        FROM ventas v
        INNER JOIN clientes c ON c.id_cliente = v.id_cliente
        INNER JOIN productos p ON p.id_producto = v.id_producto
        ORDER BY v.creado_en DESC
        LIMIT 6")->fetchAll();
<<<<<<< HEAD
=======

if ($db) {
    try {
        $stats['productos'] = (int) $db->query("SELECT COUNT(*) FROM productos")->fetchColumn();
        $stats['clientes'] = (int) $db->query("SELECT COUNT(*) FROM clientes")->fetchColumn();
        $stats['ventas'] = (int) $db->query("SELECT COUNT(*) FROM ventas")->fetchColumn();
        $stats['ingresos'] = (float) $db->query("SELECT COALESCE(SUM(total), 0) FROM ventas WHERE estado <> 'Anulado'")->fetchColumn();

        $recentSales = $db->query("SELECT v.id_venta, v.fecha_venta, v.total, v.estado, c.nombres, c.apellidos, p.nombre AS producto
            FROM ventas v
            INNER JOIN clientes c ON c.id_cliente = v.id_cliente
            INNER JOIN productos p ON p.id_producto = v.id_producto
            ORDER BY v.creado_en DESC
            LIMIT 6")->fetchAll();
    } catch (Throwable $exception) {
        $dbAvailable = false;
    }
>>>>>>> 4beb1fe (Octavo commit)
}

if ($section !== 'dashboard') {
    $controllerFile = [
        'productos' => 'ProductoController.php',
        'categorias' => 'CategoriaController.php',
        'clientes' => 'ClienteController.php',
        'proveedores' => 'ProveedorController.php',
        'ventas' => 'VentaController.php',
        'pagos' => 'PagoController.php',
        'usuarios' => 'UsuarioController.php',
    ][$section];

    require_once __DIR__ . '/controller/' . $controllerFile;

    $controllerClass = [
        'productos' => 'ProductoController',
        'categorias' => 'CategoriaController',
        'clientes' => 'ClienteController',
        'proveedores' => 'ProveedorController',
        'ventas' => 'VentaController',
        'pagos' => 'PagoController',
        'usuarios' => 'UsuarioController',
    ][$section];

    $controller = new $controllerClass();
    $rows = $controller->listar();
    $edit = $controller->obtener((int) ($_GET['edit'] ?? 0)) ?? [];

    if ($section === 'productos') {
        $categorias = $controller->categorias();
        $proveedores = $controller->proveedores();
    }

    if (in_array($section, ['ventas', 'pagos'], true) && $db) {
<<<<<<< HEAD
        $clientes = $db->query("SELECT * FROM clientes WHERE estado = 'Activo' ORDER BY nombres")->fetchAll();
        $productos = $db->query("SELECT * FROM productos WHERE estado <> 'Inactivo' ORDER BY nombre")->fetchAll();
        $ventas = $db->query("SELECT v.*, c.nombres, c.apellidos FROM ventas v INNER JOIN clientes c ON c.id_cliente = v.id_cliente ORDER BY v.creado_en DESC")->fetchAll();
    }
=======

    $products = $db->query("SELECT p.*, c.nombre AS categoria, pr.razon_social AS proveedor
        FROM productos p
        LEFT JOIN categorias c ON c.id_categoria = p.id_categoria
        LEFT JOIN proveedores pr ON pr.id_proveedor = p.id_proveedor
        ORDER BY p.id_producto DESC")->fetchAll();

    $clients = $db->query("SELECT * FROM clientes ORDER BY id_cliente DESC")->fetchAll();

    $sales = $db->query("SELECT v.*, c.nombres, c.apellidos, p.nombre AS producto
        FROM ventas v
        INNER JOIN clientes c ON c.id_cliente = v.id_cliente
        INNER JOIN productos p ON p.id_producto = v.id_producto
        ORDER BY v.id_venta DESC")->fetchAll();

    $categories = $db->query("SELECT * FROM categorias WHERE estado = 'Activo' ORDER BY nombre")->fetchAll();
    $providers = $db->query("SELECT * FROM proveedores WHERE estado = 'Activo' ORDER BY razon_social")->fetchAll();
} else {
    $categories = [
        ['id_categoria' => 1, 'nombre' => 'Televisores'],
        ['id_categoria' => 2, 'nombre' => 'Linea Blanca'],
        ['id_categoria' => 3, 'nombre' => 'Cocina Pequena'],
    ];
    $providers = [
        ['id_proveedor' => 1, 'razon_social' => 'ElectroHogar Demo'],
    ];
    $products = [
        ['id_producto' => 1, 'nombre' => 'Smart TV 55 4K UHD', 'categoria' => 'Televisores', 'proveedor' => 'ElectroHogar Demo', 'precio' => 1899, 'stock' => 15, 'estado' => 'Disponible'],
        ['id_producto' => 2, 'nombre' => 'Refrigeradora Inverter 350L', 'categoria' => 'Linea Blanca', 'proveedor' => 'ElectroHogar Demo', 'precio' => 2499, 'stock' => 8, 'estado' => 'Disponible'],
        ['id_producto' => 3, 'nombre' => 'Lavadora Automatica 12kg', 'categoria' => 'Linea Blanca', 'proveedor' => 'ElectroHogar Demo', 'precio' => 1599, 'stock' => 12, 'estado' => 'Disponible'],
    ];
    $clients = [
        ['id_cliente' => 1, 'nombres' => 'Juan Carlos', 'apellidos' => 'Perez Lopez', 'telefono' => '987654321', 'correo' => 'juan@email.com', 'direccion' => 'Av. Principal 123', 'estado' => 'Activo'],
        ['id_cliente' => 2, 'nombres' => 'Maria Elena', 'apellidos' => 'Garcia Ruiz', 'telefono' => '912345678', 'correo' => 'maria@email.com', 'direccion' => 'Jr. Comercio 456', 'estado' => 'Activo'],
    ];
    $sales = [
        ['id_venta' => 1, 'nombres' => 'Juan Carlos', 'apellidos' => 'Perez Lopez', 'producto' => 'Smart TV 55 4K UHD', 'cantidad' => 1, 'fecha_venta' => date('Y-m-d'), 'total' => 1899, 'estado' => 'Pagado'],
    ];
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
        try {
            $clientes = $db->query("SELECT * FROM clientes WHERE estado = 'Activo' ORDER BY nombres")->fetchAll();
            $productos = $db->query("SELECT * FROM productos WHERE estado <> 'Inactivo' ORDER BY nombre")->fetchAll();
            $ventas = $db->query("SELECT v.*, c.nombres, c.apellidos FROM ventas v INNER JOIN clientes c ON c.id_cliente = v.id_cliente ORDER BY v.creado_en DESC")->fetchAll();
        } catch (Throwable $exception) {
            $clientes = [];
            $productos = [];
            $ventas = [];
            $dbAvailable = false;
        }
    }
>>>>>>> 4beb1fe (Octavo commit)
}

include __DIR__ . '/views/admin/header.php';
include __DIR__ . '/views/admin/sidebar.php';
<<<<<<< HEAD
<<<<<<< HEAD
include __DIR__ . '/views/admin/' . $section . '.php';
=======
include __DIR__ . '/views/admin/' . $adminPage . '.php';
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
include __DIR__ . '/views/admin/' . $section . '.php';
>>>>>>> 4beb1fe (Octavo commit)
include __DIR__ . '/views/admin/footer.php';
