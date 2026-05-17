<?php

<<<<<<< HEAD
$id = (int) ($_GET['id'] ?? 0);
$url = '../admin.php?section=productos';

if ($id > 0) {
    $url .= '&edit=' . $id;
}

header('Location: ' . $url);
=======
header('Location: ../admin.php?page=productos&action=nuevo');
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
exit;
