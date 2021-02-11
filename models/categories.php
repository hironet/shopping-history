<?php
class Categories {
  private $db;

  function __construct($db) {
    $this->db = $db;
  }

  public function createTable() {
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

  public function insertData($category_name) {
    $category_name = htmlspecialchars(trim($category_name));

    $sql = <<<SQL
    INSERT INTO categories (category_name)
    SELECT ? FROM dual WHERE NOT EXISTS (SELECT * FROM categories WHERE category_name=?)
SQL;

    try {
      $q = $this->db->prepare($sql);
      if ($q->execute([$category_name, $category_name]) === true) {
        echo 'categoriesテーブルへのINSERTが成功しました。<br>';
      } else {
        echo 'categoriesテーブルへのINSERTが失敗しました。<br>';
        exit(1);
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function deleteData($category_name) {
    $sql = 'DELETE FROM categories WHERE category_name = ?';

    try {
      $q = $this->db->prepare($sql);
      if ($q->execute([$category_name]) === true) {
        echo 'categoriesテーブルからのDELETEが成功しました。<br>';
      } else {
        echo 'categoriesテーブルからのDELETEが失敗しました。<br>';
        exit(1);
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getAllData() {
    $sql = 'SELECT category_id, category_name FROM categories ORDER BY category_name';

    try {
      $q = $this->db->query($sql);
      return $q->fetchAll();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
?>
