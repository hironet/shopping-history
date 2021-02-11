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

    try {
      if ($this->db->query($sql) === false) {
        echo 'shopsテーブルの作成が失敗しました。<br>';
        exit(1);
      } else {
        echo 'shopsテーブルの作成が成功しました。<br>';
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function insertData($shop_name) {
    $shop_name = htmlspecialchars(trim($shop_name));

    $sql = <<<SQL
    INSERT INTO shops (shop_name)
    SELECT ? FROM dual WHERE NOT EXISTS (SELECT * FROM shops WHERE shop_name=?)
SQL;

    try {
      $q = $this->db->prepare($sql);
      if ($q->execute([$shop_name, $shop_name]) === true) {
        echo 'shopsテーブルへのINSERTが成功しました。<br>';
      } else {
        echo 'shopsテーブルへのINSERTが失敗しました。<br>';
        exit(1);
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function deleteData($shop_name) {
    $sql = 'DELETE FROM shops WHERE shop_name = ?';

    try {
      $q = $this->db->prepare($sql);
      if ($q->execute([$shop_name]) === true) {
        echo 'shopsテーブルからのDELETEが成功しました。<br>';
      } else {
        echo 'shopsテーブルからのDELETEが失敗しました。<br>';
        exit(1);
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getAllData() {
    $sql = 'SELECT shop_id, shop_name FROM shops ORDER BY shop_name';

    try {
      $q = $this->db->query($sql);
      return $q->fetchAll();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
?>
