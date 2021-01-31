<?php
class Orders {
  private $db;

  function __construct($db) {
    $this->db = $db;
  }

  public function create_table() {
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
}
?>
