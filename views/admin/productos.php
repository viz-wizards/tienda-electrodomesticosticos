<<<<<<< HEAD
<?php
$crudTitle = 'Productos';
$primaryKey = 'id_producto';
$categoriaOptions = ['' => 'Sin categoria'];
foreach (($categorias ?? []) as $categoria) {
    $categoriaOptions[$categoria['id_categoria']] = $categoria['nombre'];
}
$proveedorOptions = ['' => 'Sin proveedor'];
foreach (($proveedores ?? []) as $proveedor) {
    $proveedorOptions[$proveedor['id_proveedor']] = $proveedor['razon_social'];
}
$formFields = [
    ['name' => 'nombre', 'label' => 'Nombre'],
    ['name' => 'id_categoria', 'label' => 'Categoria', 'type' => 'select', 'options' => $categoriaOptions],
    ['name' => 'id_proveedor', 'label' => 'Proveedor', 'type' => 'select', 'options' => $proveedorOptions],
    ['name' => 'descripcion', 'label' => 'Descripcion', 'type' => 'textarea'],
    ['name' => 'precio', 'label' => 'Precio', 'type' => 'number', 'step' => '0.01', 'min' => '0'],
    ['name' => 'stock', 'label' => 'Stock', 'type' => 'number', 'min' => '0'],
    ['name' => 'imagen', 'label' => 'Imagen'],
    ['name' => 'estado', 'label' => 'Estado', 'type' => 'select', 'options' => ['Disponible' => 'Disponible', 'Agotado' => 'Agotado', 'Inactivo' => 'Inactivo'], 'default' => 'Disponible'],
];
$columns = [
    ['key' => 'id_producto', 'label' => 'ID'],
    ['key' => 'nombre', 'label' => 'Producto'],
    ['key' => 'categoria', 'label' => 'Categoria'],
    ['key' => 'precio', 'label' => 'Precio', 'format' => 'money'],
    ['key' => 'stock', 'label' => 'Stock'],
    ['key' => 'estado', 'label' => 'Estado', 'format' => 'status'],
];
include __DIR__ . '/_crud.php';
=======
<main class="admin-main">
    <header class="admin-topbar">
        <div>
            <p class="eyebrow">Inventario</p>
            <h1>Productos</h1>
        </div>
        <a class="topbar-button" href="admin.php?page=productos&action=nuevo">Nuevo producto</a>
    </header>

    <?php if (isset($_GET['ok'])): ?>
        <p class="admin-alert success">Operacion realizada correctamente.</p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p class="admin-alert error">No hay conexion a la base de datos. Importa `Tienda.sql` en phpMyAdmin.</p>
    <?php endif; ?>

    <?php if (($_GET['action'] ?? '') === 'nuevo'): ?>
        <section class="admin-card form-card">
            <h2>Nuevo producto</h2>
            <form class="admin-form" method="post" action="process/producto_save.php">
                <label>Nombre<input name="nombre" required placeholder="Ej: Smart TV 55 4K"></label>
                <label>Precio<input name="precio" type="number" min="0" step="0.01" required></label>
                <label>Stock<input name="stock" type="number" min="0" required></label>
                <label>Categoria
                    <select name="id_categoria">
                        <option value="">Sin categoria</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= (int) $category['id_categoria'] ?>"><?= e($category['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Proveedor
                    <select name="id_proveedor">
                        <option value="">Sin proveedor</option>
                        <?php foreach ($providers as $provider): ?>
                            <option value="<?= (int) $provider['id_proveedor'] ?>"><?= e($provider['razon_social']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Estado
                    <select name="estado">
                        <option>Disponible</option>
                        <option>Agotado</option>
                        <option>Inactivo</option>
                    </select>
                </label>
                <label class="full">Imagen<input name="imagen" placeholder="producto.jpg"></label>
                <label class="full">Descripcion<textarea name="descripcion" rows="4"></textarea></label>
                <div class="form-actions full">
                    <button type="submit">Guardar producto</button>
                    <a href="admin.php?page=productos">Cancelar</a>
                </div>
            </form>
        </section>
    <?php endif; ?>

    <section class="admin-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Categoria</th>
                        <th>Proveedor</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>#<?= (int) $product['id_producto'] ?></td>
                                <td><?= e($product['nombre']) ?></td>
                                <td><?= e($product['categoria'] ?? 'Sin categoria') ?></td>
                                <td><?= e($product['proveedor'] ?? 'Sin proveedor') ?></td>
                                <td><?= money($product['precio']) ?></td>
                                <td><?= (int) $product['stock'] ?></td>
                                <td><span class="status"><?= e($product['estado']) ?></span></td>
                                <td>
                                    <form method="post" action="process/producto_delete.php" onsubmit="return confirm('Deseas desactivar este producto?')">
                                        <input type="hidden" name="id" value="<?= (int) $product['id_producto'] ?>">
                                        <button class="link-danger" type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8">No hay productos para mostrar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
