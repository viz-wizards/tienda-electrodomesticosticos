<aside class="admin-sidebar">
    <a class="admin-brand" href="admin.php">
        <span>EH</span>
        <strong><?= e(APP_NAME) ?></strong>
    </a>

    <nav class="admin-nav">
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4beb1fe (Octavo commit)
=======
>>>>>>> d42ad1c (Noveno commit)
        <a class="<?= ($section ?? 'dashboard') === 'dashboard' ? 'active' : '' ?>" href="admin.php">Dashboard</a>
        <a class="<?= ($section ?? '') === 'productos' ? 'active' : '' ?>" href="admin.php?section=productos">Productos</a>
        <a class="<?= ($section ?? '') === 'categorias' ? 'active' : '' ?>" href="admin.php?section=categorias">Categorias</a>
        <a class="<?= ($section ?? '') === 'clientes' ? 'active' : '' ?>" href="admin.php?section=clientes">Clientes</a>
        <a class="<?= ($section ?? '') === 'proveedores' ? 'active' : '' ?>" href="admin.php?section=proveedores">Proveedores</a>
        <a class="<?= ($section ?? '') === 'ventas' ? 'active' : '' ?>" href="admin.php?section=ventas">Ventas</a>
        <a class="<?= ($section ?? '') === 'pagos' ? 'active' : '' ?>" href="admin.php?section=pagos">Pagos</a>
        <a class="<?= ($section ?? '') === 'usuarios' ? 'active' : '' ?>" href="admin.php?section=usuarios">Usuarios</a>
<<<<<<< HEAD
<<<<<<< HEAD
=======
        <a class="<?= $adminPage === 'dashboard' ? 'active' : '' ?>" href="admin.php">Dashboard</a>
        <a class="<?= $adminPage === 'productos' ? 'active' : '' ?>" href="admin.php?page=productos">Productos</a>
        <a class="<?= $adminPage === 'ventas' ? 'active' : '' ?>" href="admin.php?page=ventas">Ventas</a>
        <a class="<?= $adminPage === 'clientes' ? 'active' : '' ?>" href="admin.php?page=clientes">Clientes</a>
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
>>>>>>> 4beb1fe (Octavo commit)
=======
>>>>>>> d42ad1c (Noveno commit)
        <a href="index.php">Ver tienda</a>
    </nav>

    <div class="admin-user">
        <p><?= e($_SESSION['admin_user']['name'] ?? 'Administrador') ?></p>
        <span><?= e($_SESSION['admin_user']['role'] ?? 'Admin') ?></span>
        <a href="process/logout.php">Cerrar sesion</a>
    </div>
</aside>
