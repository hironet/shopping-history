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
      throw new RuntimeException('shopsテーブルの作成でエラーが発生しました。');
    }
  }

  public function insertData($shop_name) {
    $shop_name = htmlspecialchars(trim($shop_name));

    $sql = <<<SQL
    INSERT INTO shops (shop_name)
    SELECT ? FROM dual WHERE NOT EXISTS (SELECT * FROM shops WHERE shop_name=?)
SQL;

    try {
      $stmt = $this->db->prepare($sql);
      $stmt->execute([$shop_name, $shop_name]);
    } catch (PDOException $e) {
      throw new RuntimeException('shopsテーブルへのINSERTでエラーが発生しました。');
    }
  }

  public function deleteData($shop_name) {
    $sql = 'DELETE FROM shops WHERE shop_name = ?';

    try {
      $stmt = $this->db->prepare($sql);
      $stmt->execute([$shop_name]);
    } catch (PDOException $e) {
      throw new RuntimeException('shopsテーブルからのDELETEでエラーが発生しました。');
    }
  }

  public function getAllData() {
    $sql = 'SELECT shop_id, shop_name FROM shops ORDER BY shop_name';

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
  }
}
?>
