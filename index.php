<?php
$db_host='';
$db_name='';
$db_user='';
$db_pass='';

require_once('/var/www/config/shopping_history/db_info.php');
require_once(__DIR__ . '/models/shopping_histories.php');

define('DB_HOST', $db_host);
define('DB_NAME', $db_name);
define('DB_USER', $db_user);
define('DB_PASS', $db_pass);

try {
  $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
  $user = DB_USER;
  $pass = DB_PASS;
  $db = new PDO($dsn, $user, $pass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $isDemoMode = strcmp(DB_HOST, 'hironet-db') === 0 ? true : false;

  $sh = new ShoppingHistories($db);

  $keyword = isset($_POST['input']) ? $sh->makeData($_POST['input']) : $sh->makeData(['%', '%', '%', '%', '%']);
  foreach ($keyword as &$value) {
    if (!$value) $value = '%';  // 検索キーワードが空であれば%に置き換える
  }
  $order = isset($_POST['order']) ? $_POST['order'] : '2 asc';

  if (isset($_POST['operation'])) {
    $operation = explode(',', $_POST['operation']);
    switch ($operation[0]) {
      case 'reset':
        $keyword = $sh->makeData(['%', '%', '%', '%', '%']);
        $order = '2 asc';
        break;
      case 'search':
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
      case 'import':
        $sh->importCsv($_FILES['csv-file']);
        break;
    }
  }

  $categories = $sh->getAllCategories();
  $shops = $sh->getAllShops();
  $data = $sh->getDataByKeyword($keyword, $order);
  $number_of_data = count($data);  // データ件数
  $sum_price = $sh->getSumPrice($keyword);  // 合計金額

  include_once(__DIR__ . '/views/list.php');
} catch (Exception $e) {
  echo $e->getMessage(), PHP_EOL;
}
?>
