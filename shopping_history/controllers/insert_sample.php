<?php
require_once('/var/www/config/my-sys/shopping_history/db_info.php');
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

$sh = new ShoppingHistory($db);
$datas = array(
  array('purchase_date' => '2020-11-15',
        'category_name' => 'スマホ',
        'product_name' => 'iPhone 12 mini',
        'shop_name' => 'Apple Store',
        'price' => 80000),
  array('purchase_date' => '2020-12-01',
        'category_name' => 'PC',
        'product_name' => 'MacBook Air',
        'shop_name' => '楽天市場',
        'price' => 130000),
  array('purchase_date' => '2020-12-20',
        'category_name' => 'PCアクセサリ',
        'product_name' => 'MacBook Air用カバー',
        'shop_name' => 'Amazon',
        'price' => 2000),
  array('purchase_date' => '2021-01-10',
        'category_name' => '日用品',
        'product_name' => 'マスク',
        'shop_name' => 'Amazon',
        'price' => 1500),
  array('purchase_date' => '2021-01-15',
        'category_name' => '衣類',
        'product_name' => 'ヒートテック',
        'shop_name' => 'ユニクロ',
        'price' => 1000)
);
foreach ($datas as $data) {
  $sh->insert_data($data);
}
?>
