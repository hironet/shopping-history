<?php
require_once('/var/www/config/shopping_history/db_info.php');
require_once(dirname(__DIR__) . '/models/shopping_histories.php');

$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
$user = DB_USER;
$pass = DB_PASS;

try {
  $db = new PDO($dsn, $user, $pass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo $e->getMessage();
}

$sh = new ShoppingHistories($db);
$sh->importCsv('sample.csv');
?>
