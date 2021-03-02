<?php
$db_host='';
$db_name='';
$db_user='';
$db_pass='';

require_once('/var/www/config/shopping-history/db_info.php');
require_once(__DIR__ . '/models/shopping_histories.php');

define('DB_HOST', $db_host);
define('DB_NAME', $db_name);
define('DB_USER', $db_user);
define('DB_PASS', $db_pass);

$isDemoMode = strcmp(DB_HOST, 'hironet-db') === 0 ? true : false;

try {
  $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
  $db = new PDO($dsn, DB_USER, DB_PASS);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  echo $e->getMessage(), PHP_EOL;
  exit(1);
}

$menu = isset($_GET['menu']) ? $_GET['menu'] : 'daily';
switch ($menu) {
  case 'monthly':  // 月毎一覧の処理
    try {
      $sh = new ShoppingHistories($db);

      $data = $sh->getMonthlyData();
      $number_of_data = count($data);  // データ件数
    } catch (Exception $e) {
      $error_message_1 = $e->getMessage();
    }

    include_once(__DIR__ . '/views/monthly_list.php');
    break;
  case 'yearly':  // 年毎一覧の処理
    try {
      $sh = new ShoppingHistories($db);

      $data = $sh->getYearlyData();
      $number_of_data = count($data);  // データ件数
    } catch (Exception $e) {
      $error_message_1 = $e->getMessage();
    }

    include_once(__DIR__ . '/views/yearly_list.php');
    break;
  case 'daily':  // 日毎一覧の処理
  default:
    try {
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
            $success_message = $sh->insertData($input);
            break;
          case 'update':
            $order_id = $operation[1];
            $input = $sh->makeData($_POST['input']);
            $success_message = $sh->updateData($order_id, $input);
            $keyword = $sh->makeData(['%', '%', '%', '%', '%']);
            break;
          case 'delete':
            $order_id = $operation[1];
            $success_message = $sh->deleteData($order_id);
            break;
          case 'import':
            $success_message = $sh->importCsv($_FILES['csv-file']);
            break;
        }
      }
    } catch (Exception $e) {
      $error_message_1 = $e->getMessage();
    }

    try {
      $categories = $sh->getAllCategories();
      $shops = $sh->getAllShops();
      $data = $sh->getDataByKeyword($keyword, $order);
      $number_of_data = count($data);  // データ件数
      $sum_price = $sh->getSumPrice($keyword);  // 合計金額
    } catch (Exception $e) {
      $error_message_2 = $e->getMessage();
    }

    include_once(__DIR__ . '/views/daily_list.php');
    break;
}
?>
