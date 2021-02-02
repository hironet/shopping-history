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
$rows = $sh->getAll();
foreach ($rows as $r) {
  echo "{$r[1]} {$r[2]} {$r[3]} {$r[4]} {$r[5]}<br>";
}
?>
