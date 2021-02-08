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

$keys = ['purchase_date', 'category_name', 'product_name', 'shop_name', 'price'];
$keyword = array_combine($keys, ['%', '%', '%', '%', '%']);

if (isset($_POST['operation'])) {
  $oper = explode(',', $_POST['operation']);
  switch ($oper[0]) {
    case 'search':
      $keyword = array_combine($keys, $_POST['keyword']);
      foreach ($keyword as &$k) {
        if (!$k) {
          $k = '%';
        }
      }
      break;
    case 'insert':
      $insert_data = array_combine($keys, $_POST['insert_data']);
      $sh->insertData($insert_data);
      break;
    case 'update':
      echo $type . '<br>';
      echo $oper[1] . '<br>';
      break;
    case 'delete':
      $order_id = $oper[1];
      $sh->deleteData($order_id);
      break;
  }
}

$categories = $sh->selectAllCategories();
$shops = $sh->selectAllShops();
$shopping_histories = $sh->selectData($keyword);
include_once(__DIR__ . '/views/list.php');
?>
