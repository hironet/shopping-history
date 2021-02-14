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

    if ($this->db->query($sql) === false) {
      throw new RuntimeException('ordersテーブルの作成でエラーが発生しました。');
    }
  }

  public function insertData($input) {
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
      $stmt = $this->db->prepare($sql);
      $stmt->execute([
        $input['purchase_date'],
        $input['category_name'],
        $input['product_name'],
        $input['shop_name'],
        $input['price']
      ]);
    } catch (PDOException $e) {
      throw new RuntimeException('ordersテーブルへのINSERTでエラーが発生しました。');
    }
  }

  public function updateData($order_id, $old_data, $input) {
    // 更新されないカラムは現在のデータに置き換える
    foreach ($input as $key => &$value) {
      $value = ($value === '' ? $old_data[$key] : $value);
    }

    $sql = <<<SQL
    UPDATE orders
    SET
      purchase_date = ?,
      category_id = (SELECT category_id FROM categories WHERE category_name = ?),
      product_name = ?,
      shop_id = (SELECT shop_id FROM shops WHERE shop_name = ?),
      price = ?
    WHERE order_id = ?
SQL;

    if ($input['purchase_date'] !== '') {
      try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
          $input['purchase_date'],
          $input['category_name'],
          $input['product_name'],
          $input['shop_name'],
          $input['price'],
          $order_id
        ]);
      } catch (PDOException $e) {
        throw new RuntimeException('ordersテーブルのUPDATEでエラーが発生しました。');
      }
    }
  }

  public function deleteData($order_id) {
    $sql = 'DELETE FROM orders WHERE order_id = ?';

    try {
      $stmt = $this->db->prepare($sql);
      $stmt->execute([$order_id]);
    } catch (PDOException $e) {
      throw new RuntimeException('ordersテーブルからのDELETEでエラーが発生しました。');
    }
  }
}
?>
