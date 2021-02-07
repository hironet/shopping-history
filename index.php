<?php
require_once('/var/www/config/shopping_history/db_info.php');
require_once(__DIR__ . '/models/shopping_history.php');

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

if (isset($_POST['operation'])) {
  $oper = explode(',', $_POST['operation']);
  $type = $oper[0];
  $order_id = $oper[1];
  if (strcmp($type, 'update') === 0) {
    echo $oper[0] . '<br>';
    echo $oper[1] . '<br>';
  } elseif (strcmp($type, 'delete') === 0) {
    $sh->deleteData($order_id);
  }
}

$shopping_histories = $sh->getAll();
include_once(__DIR__ . '/views/list.php');
?>
