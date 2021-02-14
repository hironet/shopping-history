<?php
class Shops {
  private $db;

  function __construct($db) {
    $this->db = $db;
  }

  public function createTable() {
    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS shops (
    shop_id int(11) NOT NULL AUTO_INCREMENT,
    shop_name varchar(50) NOT NULL UNIQUE,
    PRIMARY KEY (shop_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
SQL;

    if ($this->db->query($sql) === false) {
      throw new RuntimeException('shopsテーブルの作成が失敗しました。');
    }
  }

  public function insertData($shop_name) {
    $shop_name = htmlspecialchars(trim($shop_name));

    $sql = <<<SQL
    INSERT INTO shops (shop_name)
    SELECT ? FROM dual WHERE NOT EXISTS (SELECT * FROM shops WHERE shop_name=?)
SQL;

    $q = $this->db->prepare($sql);
    if ($q->execute([$shop_name, $shop_name]) === false) {
      throw new RuntimeException('shopsテーブルへのINSERTが失敗しました。');
    }
  }

  public function deleteData($shop_name) {
    $sql = 'DELETE FROM shops WHERE shop_name = ?';

    $q = $this->db->prepare($sql);
    if ($q->execute([$shop_name]) === false) {
      throw new RuntimeException('shopsテーブルからのDELETEが失敗しました。');
    }
  }

  public function getAllData() {
    $sql = 'SELECT shop_id, shop_name FROM shops ORDER BY shop_name';

    $q = $this->db->query($sql);
    return $q->fetchAll();
  }
}
?>
