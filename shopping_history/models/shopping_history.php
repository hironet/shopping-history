<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/my-sys/shopping_history/models/categories.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/my-sys/shopping_history/models/shops.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/my-sys/shopping_history/models/orders.php');

class ShoppingHistory {
  private $db;

  function __construct($db) {
    $this->db = $db;
  }

  public function create_view() {
    $sql = <<<SQL
    CREATE OR REPLACE VIEW shopping_history AS
    SELECT a.order_id, a.purchase_date, b.category_name, a.product_name, c.shop_name, a.price
    FROM orders AS a
    JOIN categories AS b USING(category_id)
    JOIN shops AS c USING(shop_id)
SQL;

    try {
      if ($this->db->query($sql) === false) {
        echo 'shopping_historyビューの作成が失敗しました。<br>';
        exit(1);
      } else {
        echo 'shopping_historyビューの作成が成功しました。<br>';
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function insert_shopping_history($sh) {
    $sql = <<<SQL
    INSERT INTO orders (purchase_date, category_id, product_name, shop_id, price)
    VALUES (
      ?,
      (SELECT category_id FROM categories WHERE category_name = ?),
      ?,
      (SELECT shop_id FROM shops WHERE shop_name = ?),
      ?
    )
SQL;

    try {
      $q = $this->db->prepare($sql);
      if ($q->execute(array(
        $sh['purchase_date'], $sh['category_name'],
        $sh['product_name'], $sh['shop_name'], $sh['price'])) === true) {
          echo 'ordersテーブルへのINSERTが成功しました。<br>';
      } else {
        echo 'ordersテーブルへのINSERTが失敗しました。<br>';
        exit(1);
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function get_all() {
    $sql = <<<SQL
    SELECT order_id, purchase_date, category_name, product_name, shop_name, price
    FROM shopping_history
    ORDER BY order_id
SQL;

    try {
      $q = $this->db->query($sql);
      $rows = $q->fetchAll();
      return $rows;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
?>
