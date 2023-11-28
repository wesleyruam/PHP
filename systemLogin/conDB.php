<?php
require 'config.php';

$dsn = "mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME;charset=UTF8";
$pdo = new PDO($dsn, $DATABASE_USER, $DATABASE_PASS);

?>
