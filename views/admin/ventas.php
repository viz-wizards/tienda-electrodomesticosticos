<<<<<<< HEAD
<?php
$crudTitle = 'Ventas';
$primaryKey = 'id_venta';
$clienteOptions = [];
foreach (($clientes ?? []) as $cliente) {
    $clienteOptions[$cliente['id_cliente']] = $cliente['nombres'] . ' ' . $cliente['apellidos'];
}
$productoOptions = [];
foreach (($productos ?? []) as $producto) {
    $productoOptions[$producto['id_producto']] = $producto['nombre'];
}
$formFields = [
    ['name' => 'id_cliente', 'label' => 'Cliente', 'type' => 'select', 'options' => $clienteOptions],
    ['name' => 'id_producto', 'label' => 'Producto', 'type' => 'select', 'options' => $productoOptions],
    ['name' => 'cantidad', 'label' => 'Cantidad', 'type' => 'number', 'min' => '1', 'default' => '1'],
    ['name' => 'precio_unitario', 'label' => 'Precio unitario', 'type' => 'number', 'step' => '0.01', 'min' => '0'],
    ['name' => 'total', 'label' => 'Total', 'type' => 'number', 'step' => '0.01', 'min' => '0'],
    ['name' => 'fecha_venta', 'label' => 'Fecha', 'type' => 'date', 'default' => date('Y-m-d')],
    ['name' => 'estado', 'label' => 'Estado', 'type' => 'select', 'options' => ['Pendiente' => 'Pendiente', 'Pagado' => 'Pagado', 'Anulado' => 'Anulado', 'Entregado' => 'Entregado'], 'default' => 'Pendiente'],
];
$columns = [
    ['key' => 'id_venta', 'label' => 'ID'],
    ['key' => 'nombres', 'label' => 'Cliente'],
    ['key' => 'producto', 'label' => 'Producto'],
    ['key' => 'cantidad', 'label' => 'Cant.'],
    ['key' => 'total', 'label' => 'Total', 'format' => 'money'],
    ['key' => 'fecha_venta', 'label' => 'Fecha'],
    ['key' => 'estado', 'label' => 'Estado', 'format' => 'status'],
];
include __DIR__ . '/_crud.php';
=======
<main class="admin-main">
    <header class="admin-topbar">
        <div>
            <p class="eyebrow">Comercial</p>
            <h1>Ventas</h1>
        </div>
        <a class="topbar-button" href="admin.php?page=ventas&action=nuevo">Registrar venta</a>
    </header>

    <?php if (isset($_GET['ok'])): ?>
        <p class="admin-alert success">Venta registrada correctamente.</p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p class="admin-alert error">No hay conexion a la base de datos. Importa `Tienda.sql` en phpMyAdmin.</p>
    <?php endif; ?>

    <?php if (($_GET['action'] ?? '') === 'nuevo'): ?>
        <section class="admin-card form-card">
            <h2>Registrar venta</h2>
            <form class="admin-form" method="post" action="process/venta_save.php">
                <label>Cliente
                    <select name="id_cliente" required>
                        <option value="">Seleccionar cliente</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= (int) $client['id_cliente'] ?>"><?= e($client['nombres'] . ' ' . $client['apellidos']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Producto
                    <select name="id_producto" required>
                        <option value="">Seleccionar producto</option>
                        <?php foreach ($products as $product): ?>
                            <?php if ($product['estado'] !== 'Inactivo'): ?>
                                <option value="<?= (int) $product['id_producto'] ?>"><?= e($product['nombre']) ?> - <?= money($product['precio']) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Cantidad<input name="cantidad" type="number" min="1" value="1" required></label>
                <label>Fecha<input name="fecha_venta" type="date" value="<?= date('Y-m-d') ?>" required></label>
                <label>Estado
                    <select name="estado">
                        <option>Pendiente</option>
                        <option>Pagado</option>
                        <option>Entregado</option>
                        <option>Anulado</option>
                    </select>
                </label>
                <div class="form-actions full">
                    <button type="submit">Guardar venta</button>
                    <a href="admin.php?page=ventas">Cancelar</a>
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
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sales)): ?>
                        <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td>#<?= (int) $sale['id_venta'] ?></td>
                                <td><?= e($sale['nombres'] . ' ' . $sale['apellidos']) ?></td>
                                <td><?= e($sale['producto']) ?></td>
                                <td><?= (int) $sale['cantidad'] ?></td>
                                <td><?= e($sale['fecha_venta']) ?></td>
                                <td><?= money($sale['total']) ?></td>
                                <td><span class="status"><?= e($sale['estado']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No hay ventas para mostrar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
