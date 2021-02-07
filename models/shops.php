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

  public function insertData($data) {
    $sql = <<<SQL
    INSERT INTO shops (shop_name)
    SELECT ? FROM dual WHERE NOT EXISTS (SELECT * FROM shops WHERE shop_name=?)
SQL;

    try {
      $q = $this->db->prepare($sql);
      if ($q->execute(array($data, $data)) === true) {
        echo 'shopsテーブルへのINSERTが成功しました。<br>';
      } else {
        echo 'shopsテーブルへのINSERTが失敗しました。<br>';
        exit(1);
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
?>