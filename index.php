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
    case 'search':
      $keyword = $sh->makeData($_POST['keyword']);
      foreach ($keyword as &$k) {
        if (!$k) $k = '%';  // 検索キーワードが空であれば%に置き換える
      }
      break;
    case 'insert':
      $data = $sh->makeData($_POST['keyword']);
      $sh->insertData($data);
      break;
    case 'update':
      $order_id = $oper[1];
      $data = $sh->makeData($_POST['keyword']);
      $sh->updateData($order_id, $data);
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
