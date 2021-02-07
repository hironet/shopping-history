<?php
require_once(__DIR__ . '/categories.php');
require_once(__DIR__ . '/shops.php');
require_once(__DIR__ . '/orders.php');

class ShoppingHistory {
  private $db;
  private $categories;
  private $shops;
  private $orders;

  function __construct($db) {
    $this->db = $db;
    $this->categories = new Categories($db);
    $this->shops = new Shops($db);
    $this->orders = new Orders($db);
  }

  public function createView() {
    $sql = <<<SQL
    CREATE OR REPLACE VIEW shopping_history AS
    SELECT a.order_id, a.purchase_date, b.category_name, a.product_name, c.shop_name, a.price
    FROM orders AS a
    JOIN categories AS b USING(category_id)
    JOIN shops AS c USING(shop_id)
SQL;

    try {
      if ($this->db->query($sql) === false) {
        echo 'shopping_historyビューの作成が失敗しました。<br>';
        exit(1);
      } else {
        echo 'shopping_historyビューの作成が成功しました。<br>';
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function insertData($data) {
    $this->categories->insertData($data['category_name']);
    $this->shops->insertData($data['shop_name']);
    $this->orders->insertData($data);
  }

  public function deleteData($order_id) {
    $this->orders->deleteData($order_id);
  }

  public function importCsv($file) {
    if (($handle = fopen($file, "r")) != false) {
      $keys = ['purchase_date', 'category_name', 'product_name', 'shop_name', 'price'];
      while (($values = fgetcsv($handle, 1000, ",")) != false) {
        if (count($values) != 5) continue;
        foreach ($values as &$value) {
          $value = htmlspecialchars(trim($value));
        }
        $values[0] = preg_replace('/[^0-9]/', '', $values[0]);
        $values[4] = preg_replace('/[^0-9]/', '', $values[4]);
        $data = array_combine($keys, $values);
        $this->insertData($data);
      }
      fclose($handle);
    } else {
      echo "{$file}を開けませんでした。<br>";
      exit(1);
    }
  }

  public function getAll() {
    $sql = <<<SQL
    SELECT order_id, purchase_date, category_name, product_name, shop_name, price
    FROM shopping_history
    ORDER BY order_id
SQL;

    try {
      $q = $this->db->query($sql);
      $rows = $q->fetchAll();
      return $rows;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
?>
