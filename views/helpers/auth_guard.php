<?php

<<<<<<< HEAD
<<<<<<< HEAD
require_once __DIR__ . '/../../config/constants.php';

=======
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
require_once __DIR__ . '/../../config/constants.php';

>>>>>>> 4beb1fe (Octavo commit)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['admin_user'])) {
<<<<<<< HEAD
<<<<<<< HEAD
    header('Location: ' . BASE_URL . 'index.php?page=login');
=======
    header('Location: index.php?page=login');
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
=======
    header('Location: ' . BASE_URL . 'index.php?page=login');
>>>>>>> 4beb1fe (Octavo commit)
    exit;
}
