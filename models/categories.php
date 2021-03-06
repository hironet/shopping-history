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

    if ($this->db->query($sql) === false) {
      throw new RuntimeException('categoriesテーブルの作成でエラーが発生しました。');
    }
  }

  public function insertData($category_name) {
    $sql = <<<SQL
    INSERT INTO categories (category_name)
    SELECT ? FROM dual WHERE NOT EXISTS (SELECT * FROM categories WHERE category_name=?)
SQL;

    try {
      $stmt = $this->db->prepare($sql);
      $stmt->execute([$category_name, $category_name]);
    } catch (PDOException $e) {
      throw new RuntimeException('categoriesテーブルへのINSERTでエラーが発生しました。');
    }
  }

  public function deleteData($category_name) {
    $sql = 'DELETE FROM categories WHERE category_name = ?';

    try {
      $stmt = $this->db->prepare($sql);
      $stmt->execute([$category_name]);
    } catch (PDOException $e) {
      throw new RuntimeException('categoriesテーブルからのDELETEでエラーが発生しました。');
    }
  }

  public function getAllData() {
    $sql = 'SELECT category_id, category_name FROM categories ORDER BY category_name';

    if (($stmt = $this->db->query($sql)) === false) {
      throw new RuntimeException('categoriesテーブルからのSELECTでエラーが発生しました。');
    }
    return $stmt->fetchAll();
  }
}
