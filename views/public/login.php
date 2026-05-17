<section class="auth-page">
    <form class="auth-card" method="post" action="<?= url('process/login.php') ?>">
        <h1>Ingreso administrativo</h1>
        <?php if (isset($_GET['error'])): ?>
            <p class="form-alert error">Correo o contrasena incorrectos.</p>
        <?php endif; ?>
        <?php if (isset($_GET['logout'])): ?>
            <p class="form-alert success">Sesion cerrada correctamente.</p>
        <?php endif; ?>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4beb1fe (Octavo commit)
=======
>>>>>>> d42ad1c (Noveno commit)
        <?php if (isset($_GET['registered'])): ?>
            <p class="form-alert success">Cuenta creada correctamente. Ahora puedes iniciar sesion.</p>
        <?php endif; ?>
        <?php if (isset($_GET['reset'])): ?>
            <p class="form-alert success">Contrasena actualizada correctamente.</p>
        <?php endif; ?>
        <label>Correo<input type="email" name="email" value="admin@electrohogar.com" required></label>
        <label>Contrasena<input type="password" name="password" value="password123" required data-password></label>
        <button type="submit">Entrar</button>
        <div class="auth-links">
            <a href="<?= url('?page=registro') ?>">Crear cuenta</a>
            <a href="<?= url('?page=recuperar') ?>">Olvide mi contrasena</a>
        </div>
        <p class="auth-note">Demo: admin@electrohogar.com / password123</p>
<<<<<<< HEAD
<<<<<<< HEAD
=======
        <label>Correo<input type="email" name="email" value="admin@electrohogar.com" required></label>
        <label>Contrasena<input type="password" name="password" value="password123" required></label>
        <button type="submit">Entrar</button>
        <p>Demo: admin@electrohogar.com / password123</p>
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
>>>>>>> 4beb1fe (Octavo commit)
=======
>>>>>>> d42ad1c (Noveno commit)
    </form>
</section>
