<?php
class Categories {
  private $db;

  function __construct($db) {
    $this->db = $db;
  }

  public function create_table() {
    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS categories (
    category_id int(11) NOT NULL AUTO_INCREMENT,
    category_name varchar(30) NOT NULL UNIQUE,
    PRIMARY KEY (category_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
SQL;

    try {
      if ($this->db->query($sql) === false) {
        echo 'categoriesテーブルの作成が失敗しました。<br>';
        exit(1);
      } else {
        echo 'categoriesテーブルの作成が成功しました。<br>';
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function insert_data($data) {
    $sql = <<<SQL
    INSERT INTO categories (category_name)
    SELECT ? FROM dual WHERE NOT EXISTS (SELECT * FROM categories WHERE category_name=?)
SQL;

    try {
      $q = $this->db->prepare($sql);
      if ($q->execute(array($data, $data)) === true) {
        echo 'categoriesテーブルへのINSERTが成功しました。<br>';
      } else {
        echo 'categoriesテーブルへのINSERTが失敗しました。<br>';
        exit(1);
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
?>
