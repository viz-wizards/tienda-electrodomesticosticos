<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(APP_NAME) ?> | Tienda de electrodomesticos</title>
    <link rel="icon" href="<?= asset('img/icono.ico') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <header class="site-header">
        <a class="brand" href="<?= url() ?>" aria-label="<?= e(APP_NAME) ?>">
            <img src="<?= asset('img/Logo.png') ?>" alt="" onerror="this.style.display='none'">
            <span><?= e(APP_NAME) ?></span>
        </a>

        <nav class="nav">
            <a href="<?= url() ?>">Inicio</a>
            <a href="<?= url('?page=nosotros') ?>">Nosotros</a>
            <a href="<?= url('?page=contacto') ?>">Contacto</a>
        </nav>

        <button class="cart-button" type="button" data-cart-open>
            Carrito <span data-cart-count>0</span>
        </button>
    </header>

    <main>
        <?php include __DIR__ . '/' . $page . '.php'; ?>
    </main>

    <aside class="cart-drawer" data-cart-drawer aria-hidden="true">
        <div class="cart-panel">
            <div class="cart-head">
                <h2>Tu carrito</h2>
                <button type="button" data-cart-close aria-label="Cerrar carrito">x</button>
            </div>
            <div data-cart-items class="cart-items"></div>
            <div class="cart-total">
                <span>Total</span>
                <strong data-cart-total>$0</strong>
            </div>
            <a class="checkout-button" href="<?= url('?page=contacto') ?>">Solicitar compra</a>
        </div>
    </aside>

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    <?php include __DIR__ . '/partials/footer.php'; ?>
=======
    <footer class="site-footer">
        <p>&copy; <?= date('Y') ?> <?= e(APP_NAME) ?>. Electrodomesticos para un hogar mas simple.</p>
        <div>
            <a href="<?= url('?page=terminos') ?>">Terminos</a>
            <a href="<?= url('?page=login') ?>">Admin</a>
        </div>
    </footer>
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
    <?php include __DIR__ . '/partials/footer.php'; ?>
>>>>>>> 4beb1fe (Octavo commit)
=======
    <?php include __DIR__ . '/partials/footer.php'; ?>
>>>>>>> d42ad1c (Noveno commit)

    <script src="<?= asset('js/carrito.js') ?>"></script>
    <script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
