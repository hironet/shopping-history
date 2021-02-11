<?php
require_once('/var/www/config/shopping_history/db_info.php');
require_once(dirname(__DIR__) . '/models/categories.php');
require_once(dirname(__DIR__) . '/models/shops.php');
require_once(dirname(__DIR__) . '/models/orders.php');
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

$categories = new Categories($db);
$categories->createTable();

$shops = new Shops($db);
$shops->createTable();

$orders = new Orders($db);
$orders->createTable();

$sh = new ShoppingHistories($db);
$sh->createView();
?>
