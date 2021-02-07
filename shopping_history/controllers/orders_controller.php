<?php
require_once('/var/www/config/my-sys/shopping_history/db_info.php');
require_once(dirname(__DIR__) . '/models/shopping_history.php');

$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
$user = DB_USER;
$pass = DB_PASS;

try {
  $db = new PDO($dsn, $user, $pass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo $e->getMessage();
}

$sh = new ShoppingHistory($db);
$shopping_histories = $sh->getAll();

include_once(dirname(__DIR__) . '/views/list.php');
?>
