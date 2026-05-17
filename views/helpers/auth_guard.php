<?php

<<<<<<< HEAD
require_once __DIR__ . '/../../config/constants.php';

=======
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['admin_user'])) {
<<<<<<< HEAD
    header('Location: ' . BASE_URL . 'index.php?page=login');
=======
    header('Location: index.php?page=login');
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
    exit;
}
