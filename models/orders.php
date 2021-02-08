<?php
class Orders {
  private $db;

  function __construct($db) {
    $this->db = $db;
  }

  public function createTable() {
    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS `orders` (
    order_id int(11) NOT NULL AUTO_INCREMENT,
    purchase_date date NOT NULL,
    category_id int(11) NOT NULL,
    product_name varchar(100),
    shop_id int(11) NOT NULL,
    price int(11) NOT NULL,
    PRIMARY KEY (order_id),
    CONSTRAINT fk_category_id FOREIGN KEY (category_id) REFERENCES categories (category_id) ON UPDATE CASCADE,
    CONSTRAINT fk_shop_id FOREIGN KEY (shop_id) REFERENCES shops (shop_id) ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
SQL;

    try {
      if ($this->db->query($sql) === false) {
        echo 'ordersテーブルの作成が失敗しました。<br>';
        exit(1);
      } else {
        echo 'ordersテーブルの作成が成功しました。<br>';
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function insertData($data) {
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

    foreach ($data as &$d) {
      $d = htmlspecialchars(trim($d));
    }
    $data['purchase_date'] = preg_replace('/[^0-9]/', '', $data['purchase_date']);
    $data['price'] = preg_replace('/[^0-9]/', '', $data['price']);

    try {
      $q = $this->db->prepare($sql);
      if ($q->execute(array(
        $data['purchase_date'],
        $data['category_name'],
        $data['product_name'],
        $data['shop_name'],
        $data['price']
        )) === true) {
        echo 'ordersテーブルへのINSERTが成功しました。<br>';
      } else {
        echo 'ordersテーブルへのINSERTが失敗しました。<br>';
        exit(1);
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function deleteData($order_id) {
    $sql = 'DELETE FROM orders WHERE order_id = ?';

    try {
      $q = $this->db->prepare($sql);
      if ($q->execute(array($order_id)) === true) {
        echo 'ordersテーブルからのDELETEが成功しました。<br>';
      } else {
        echo 'ordersテーブルからのDELETEが失敗しました。<br>';
        exit(1);
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
?>
