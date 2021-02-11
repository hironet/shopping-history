<?php
require_once('/var/www/config/shopping_history/db_info.php');
require_once(__DIR__ . '/models/shopping_histories.php');

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

$keyword = $sh->makeData(['%', '%', '%', '%', '%']);

if (isset($_POST['operation'])) {
  $oper = explode(',', $_POST['operation']);
  switch ($oper[0]) {
    case 'reset':
      break;
    case 'search':
      $keyword = $sh->makeData($_POST['input_data']);
      foreach ($keyword as &$k) {
        if (!$k) $k = '%';  // 検索キーワードが空であれば%に置き換える
      }
      break;
    case 'insert':
      $data = $sh->makeData($_POST['input_data']);
      $sh->insertData($data);
      break;
    case 'update':
      $order_id = $oper[1];
      $data = $sh->makeData($_POST['input_data']);
      $sh->updateData($order_id, $data);
      break;
    case 'delete':
      $order_id = $oper[1];
      $data = $sh->getDataByOrderID($order_id);
      $sh->deleteData($order_id, $data);
      break;
  }
}

$categories = $sh->getAllCategories();
$shops = $sh->getAllShops();
$shopping_histories = $sh->getData($keyword);
$sum_price = $sh->getSumPrice($keyword);
include_once(__DIR__ . '/views/list.php');
?>
