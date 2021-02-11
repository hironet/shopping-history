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
  $operation = explode(',', $_POST['operation']);
  switch ($operation[0]) {
    case 'reset':
      break;
    case 'search':
      $keyword = $sh->makeData($_POST['input']);
      foreach ($keyword as &$value) {
        if (!$value) $value = '%';  // 検索キーワードが空であれば%に置き換える
      }
      break;
    case 'insert':
      $input = $sh->makeData($_POST['input']);
      $sh->insertData($input);
      break;
    case 'update':
      $order_id = $operation[1];
      $input = $sh->makeData($_POST['input']);
      $sh->updateData($order_id, $input);
      break;
    case 'delete':
      $order_id = $operation[1];
      $sh->deleteData($order_id);
      break;
  }
}

$categories = $sh->getAllCategories();
$shops = $sh->getAllShops();
$shopping_histories = $sh->getDataByKeyword($keyword);
$sum_price = $sh->getSumPrice($keyword);

include_once(__DIR__ . '/views/list.php');
?>
