<?php
require_once(__DIR__ . '/categories.php');
require_once(__DIR__ . '/shops.php');
require_once(__DIR__ . '/orders.php');

class ShoppingHistories {
  private $db;
  private $categories;
  private $shops;
  private $orders;

  const KEYS = ['purchase_date', 'category_name', 'product_name', 'shop_name', 'price'];

  function __construct($db) {
    $this->db = $db;
    $this->categories = new Categories($db);
    $this->shops = new Shops($db);
    $this->orders = new Orders($db);
  }

  public function createView() {
    $sql = <<<SQL
    CREATE OR REPLACE VIEW shopping_histories AS
    SELECT a.order_id, a.purchase_date, b.category_name, a.product_name, c.shop_name, a.price
    FROM orders AS a
    JOIN categories AS b USING(category_id)
    JOIN shops AS c USING(shop_id)
SQL;

    try {
      if ($this->db->query($sql) === false) {
        echo 'shopping_historiesビューの作成が失敗しました。<br>';
        exit(1);
      } else {
        echo 'shopping_historiesビューの作成が成功しました。<br>';
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  private function checkUsedCategory($category_name) {
    $sql = 'SELECT count(*) FROM shopping_histories WHERE category_name = ?';

    try {
      $q = $this->db->prepare($sql);
      $q->execute([$category_name]);
      return ($q->fetch()[0] > 0) ? true : false;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  private function checkUsedShop($shop_name) {
    $sql = 'SELECT count(*) FROM shopping_histories WHERE shop_name = ?';

    try {
      $q = $this->db->prepare($sql);
      $q->execute([$shop_name]);
      return ($q->fetch()[0] > 0) ? true : false;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function makeData($data) {
    if (count($data) === 5) {
      return array_combine(self::KEYS, $data);
    } else {
      return array_combine(self::KEYS, ['', '', '', '', '']);
    }
  }

  public function insertData($data) {
    $this->categories->insertData($data['category_name']);
    $this->shops->insertData($data['shop_name']);
    $this->orders->insertData($data);
  }

  public function updateData($order_id, $old_data, $new_data) {
    $this->orders->updateData($order_id, $new_data);
    if ($this->checkUsedCategory($old_data['category_name']) === false) {
      $this->categories->deleteData($old_data['category_name']);
    }
    if ($this->checkUsedShop($old_data['shop_name']) === false) {
      $this->shops->deleteData($old_data['shop_name']);
    }
  }

  public function deleteData($order_id, $data) {
    $this->orders->deleteData($order_id);
    if ($this->checkUsedCategory($data['category_name']) === false) {
      $this->categories->deleteData($data['category_name']);
    }
    if ($this->checkUsedShop($data['shop_name']) === false) {
      $this->shops->deleteData($data['shop_name']);
    }
  }

  public function importCsv($file) {
    if (($handle = fopen($file, "r")) != false) {
      while (($values = fgetcsv($handle, 1000, ",")) != false) {
        if (count($values) != 5) continue;
        $data = array_combine(self::KEYS, $values);
        $this->insertData($data);
      }
      fclose($handle);
    } else {
      echo "{$file}を開けませんでした。<br>";
      exit(1);
    }
  }

  public function getDataByKeyword($keyword) {
    $sql = <<<SQL
    SELECT order_id, purchase_date, category_name, product_name, shop_name, price
    FROM shopping_histories
    WHERE
      purchase_date LIKE ? AND
      category_name LIKE ? AND
      product_name LIKE ? AND
      shop_name LIKE ? AND
      price LIKE ?
    ORDER BY order_id
SQL;

    try {
      $q = $this->db->prepare($sql);
      $q->execute([
        $keyword['purchase_date'],
        $keyword['category_name'],
        $keyword['product_name'],
        $keyword['shop_name'],
        $keyword['price']
      ]);
      return $q->fetchAll();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getDataByOrderID($order_id) {
    $sql = <<<SQL
    SELECT order_id, purchase_date, category_name, product_name, shop_name, price
    FROM shopping_histories
    WHERE order_id = ?
    ORDER BY order_id
SQL;

    try {
      $q = $this->db->prepare($sql);
      $q->execute([$order_id]);
      return $q->fetch();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getSumPrice($keyword) {
    $sql = <<<SQL
    SELECT sum(price)
    FROM shopping_histories
    WHERE
      purchase_date LIKE ? AND
      category_name LIKE ? AND
      product_name LIKE ? AND
      shop_name LIKE ? AND
      price LIKE ?
SQL;

    try {
      $q = $this->db->prepare($sql);
      $q->execute([
        $keyword['purchase_date'],
        $keyword['category_name'],
        $keyword['product_name'],
        $keyword['shop_name'],
        $keyword['price']
      ]);
      return $q->fetch()[0];
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getAllCategories() {
    return $this->categories->getAllData();
  }

  public function getAllShops() {
    return $this->shops->getAllData();
  }
}
?>
