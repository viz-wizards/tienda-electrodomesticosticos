<?php
define('APP_NAME', 'ElectroHogar');
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/');
$basePath = rtrim(str_replace(['/process', '/views/public', '/views/admin'], '', dirname($scriptName)), '/');
define('BASE_URL', ($basePath === '' ? '' : $basePath) . '/');
define('ADMIN_EMAIL', 'admin@electrohogar.com');
define('ADMIN_PASSWORD', 'password123');
