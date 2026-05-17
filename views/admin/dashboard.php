<main class="admin-main">
    <header class="admin-topbar">
        <div>
            <p class="eyebrow">Panel administrativo</p>
            <h1>Dashboard</h1>
        </div>
        <a class="topbar-button" href="index.php">Abrir tienda</a>
    </header>

    <section class="stats-grid">
        <article>
            <span>Productos</span>
            <strong><?= (int) $stats['productos'] ?></strong>
            <p>Items registrados</p>
        </article>
        <article>
            <span>Clientes</span>
            <strong><?= (int) $stats['clientes'] ?></strong>
            <p>Compradores activos</p>
        </article>
        <article>
            <span>Ventas</span>
            <strong><?= (int) $stats['ventas'] ?></strong>
            <p>Ordenes creadas</p>
        </article>
        <article>
            <span>Ingresos</span>
            <strong><?= money($stats['ingresos']) ?></strong>
            <p>Sin ventas anuladas</p>
        </article>
    </section>

    <section class="dashboard-grid">
        <article class="admin-card" id="ventas">
            <div class="card-head">
                <div>
                    <p class="eyebrow">Actividad</p>
                    <h2>Ventas recientes</h2>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentSales)): ?>
                            <?php foreach ($recentSales as $sale): ?>
                                <tr>
                                    <td>#<?= (int) $sale['id_venta'] ?></td>
                                    <td><?= e($sale['nombres'] . ' ' . $sale['apellidos']) ?></td>
                                    <td><?= e($sale['producto']) ?></td>
                                    <td><?= e($sale['fecha_venta']) ?></td>
                                    <td><?= money($sale['total']) ?></td>
                                    <td><span class="status"><?= e($sale['estado']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td>#1</td>
                                <td>Cliente Demo</td>
                                <td>Smart TV 55 4K UHD</td>
                                <td><?= date('Y-m-d') ?></td>
                                <td><?= money(1899) ?></td>
                                <td><span class="status">Pagado</span></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </article>

        <aside class="admin-card" id="productos">
            <p class="eyebrow">Gestion rapida</p>
            <h2>Inventario</h2>
            <p>Desde aqui puedes revisar el resumen de productos y preparar las siguientes vistas CRUD.</p>
            <div class="quick-actions">
<<<<<<< HEAD
                <a href="admin.php#productos">Nuevo producto</a>
                <a href="admin.php#clientes">Nuevo cliente</a>
                <a href="admin.php#ventas">Registrar venta</a>
=======
                <a href="admin.php?page=productos&action=nuevo">Nuevo producto</a>
                <a href="admin.php?page=clientes&action=nuevo">Nuevo cliente</a>
                <a href="admin.php?page=ventas&action=nuevo">Registrar venta</a>
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
            </div>
        </aside>
    </section>
</main>
