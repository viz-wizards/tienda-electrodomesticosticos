<section class="auth-page">
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4beb1fe (Octavo commit)
=======
>>>>>>> d42ad1c (Noveno commit)
    <form class="auth-card" method="post" action="<?= url('process/register.php') ?>" data-auth-form>
        <h1>Crear cuenta</h1>
        <?php if (isset($_GET['error'])): ?>
            <p class="form-alert error">
                <?= ($_GET['error'] ?? '') === 'password' ? 'Las contrasenas no coinciden.' : 'No se pudo crear la cuenta. Revisa los datos o usa otro correo.' ?>
            </p>
        <?php endif; ?>
        <label>Nombre completo<input type="text" name="nombre" placeholder="Nombre completo" required></label>
        <label>Correo<input type="email" name="email" placeholder="correo@ejemplo.com" required></label>
        <label>Telefono<input type="tel" name="telefono" placeholder="3001234567"></label>
        <label>Direccion<input type="text" name="direccion" placeholder="Ciudad, barrio, direccion"></label>
        <label>Contrasena<input type="password" name="password" minlength="6" required data-password></label>
        <label>Confirmar contrasena<input type="password" name="password_confirm" minlength="6" required data-password-confirm></label>
        <p class="password-hint" data-password-hint>Usa minimo 6 caracteres.</p>
        <button type="submit">Registrarme</button>
        <div class="auth-links">
            <a href="<?= url('?page=login') ?>">Ya tengo cuenta</a>
        </div>
<<<<<<< HEAD
<<<<<<< HEAD
=======
    <form class="auth-card">
        <h1>Crear cuenta</h1>
        <label>Nombre<input type="text" placeholder="Nombre completo"></label>
        <label>Correo<input type="email" placeholder="correo@ejemplo.com"></label>
        <label>Contrasena<input type="password"></label>
        <button type="button">Registrarme</button>
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
>>>>>>> 4beb1fe (Octavo commit)
=======
>>>>>>> d42ad1c (Noveno commit)
    </form>
</section>
