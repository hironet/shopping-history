<?php
$db_host='';
$db_name='';
$db_user='';
$db_pass='';

require_once('/var/www/config/shopping-history/db_info.php');
require_once(dirname(__DIR__) . '/models/categories.php');
require_once(dirname(__DIR__) . '/models/shops.php');
require_once(dirname(__DIR__) . '/models/orders.php');
require_once(dirname(__DIR__) . '/models/shopping_histories.php');

define('DB_HOST', $db_host);
define('DB_NAME', $db_name);
define('DB_USER', $db_user);
define('DB_PASS', $db_pass);

try {
  /* データベース作成 */

  $dsn = 'mysql:host=' . DB_HOST . ';charset=utf8mb4';
  $db = new PDO($dsn, DB_USER, DB_PASS);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = 'CREATE DATABASE IF NOT EXISTS shopping_history DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin';
  $db->exec($sql);

  /* テーブル作成 */

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
