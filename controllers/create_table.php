<?php
$db_host='';
$db_name='';
$db_user='';
$db_pass='';

require_once('/var/www/config/shopping_history/db_info.php');
require_once(dirname(__DIR__) . '/models/categories.php');
require_once(dirname(__DIR__) . '/models/shops.php');
require_once(dirname(__DIR__) . '/models/orders.php');
require_once(dirname(__DIR__) . '/models/shopping_histories.php');

define('DB_HOST', $db_host);
define('DB_NAME', $db_name);
define('DB_USER', $db_user);
define('DB_PASS', $db_pass);

try {
  $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
  $db = new PDO($dsn, DB_USER, DB_PASS);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $categories = new Categories($db);
  $categories->createTable();

  $shops = new Shops($db);
  $shops->createTable();

  $orders = new Orders($db);
  $orders->createTable();

  $sh = new ShoppingHistories($db);
  $sh->createView();
} catch (Exception $e) {
  echo $e->getMessage(), PHP_EOL;
}
?>
