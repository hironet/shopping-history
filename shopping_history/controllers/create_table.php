<?php
require_once('/var/www/config/my-sys/shopping_history/db_info.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/my-sys/shopping_history/models/categories.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/my-sys/shopping_history/models/shops.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/my-sys/shopping_history/models/orders.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/my-sys/shopping_history/models/shopping_history.php');

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

$sh = new ShoppingHistory($db);
$sh->createView();
?>
