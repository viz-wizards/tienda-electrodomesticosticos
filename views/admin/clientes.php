<<<<<<< HEAD
<?php
$crudTitle = 'Clientes';
$primaryKey = 'id_cliente';
$formFields = [
    ['name' => 'nombres', 'label' => 'Nombres'],
    ['name' => 'apellidos', 'label' => 'Apellidos'],
    ['name' => 'telefono', 'label' => 'Telefono'],
    ['name' => 'correo', 'label' => 'Correo', 'type' => 'email'],
    ['name' => 'direccion', 'label' => 'Direccion', 'type' => 'textarea'],
    ['name' => 'estado', 'label' => 'Estado', 'type' => 'select', 'options' => ['Activo' => 'Activo', 'Inactivo' => 'Inactivo'], 'default' => 'Activo'],
];
$columns = [
    ['key' => 'id_cliente', 'label' => 'ID'],
    ['key' => 'nombres', 'label' => 'Nombres'],
    ['key' => 'apellidos', 'label' => 'Apellidos'],
    ['key' => 'telefono', 'label' => 'Telefono'],
    ['key' => 'correo', 'label' => 'Correo'],
    ['key' => 'estado', 'label' => 'Estado', 'format' => 'status'],
];
include __DIR__ . '/_crud.php';
=======
<main class="admin-main">
    <header class="admin-topbar">
        <div>
            <p class="eyebrow">Base de clientes</p>
            <h1>Clientes</h1>
        </div>
        <a class="topbar-button" href="admin.php?page=clientes&action=nuevo">Nuevo cliente</a>
    </header>

    <?php if (isset($_GET['ok'])): ?>
        <p class="admin-alert success">Cliente guardado correctamente.</p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p class="admin-alert error">No hay conexion a la base de datos. Importa `Tienda.sql` en phpMyAdmin.</p>
    <?php endif; ?>

    <?php if (($_GET['action'] ?? '') === 'nuevo'): ?>
        <section class="admin-card form-card">
            <h2>Nuevo cliente</h2>
            <form class="admin-form" method="post" action="process/cliente_save.php">
                <label>Nombres<input name="nombres" required></label>
                <label>Apellidos<input name="apellidos" required></label>
                <label>Telefono<input name="telefono"></label>
                <label>Correo<input name="correo" type="email"></label>
                <label>Estado
                    <select name="estado">
                        <option>Activo</option>
                        <option>Inactivo</option>
                    </select>
                </label>
                <label class="full">Direccion<input name="direccion"></label>
                <div class="form-actions full">
                    <button type="submit">Guardar cliente</button>
                    <a href="admin.php?page=clientes">Cancelar</a>
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
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Direccion</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clients)): ?>
                        <?php foreach ($clients as $client): ?>
                            <tr>
                                <td>#<?= (int) $client['id_cliente'] ?></td>
                                <td><?= e($client['nombres'] . ' ' . $client['apellidos']) ?></td>
                                <td><?= e($client['telefono']) ?></td>
                                <td><?= e($client['correo']) ?></td>
                                <td><?= e($client['direccion']) ?></td>
                                <td><span class="status"><?= e($client['estado']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No hay clientes para mostrar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
