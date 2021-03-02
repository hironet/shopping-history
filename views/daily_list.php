<?php include_once(__DIR__ . '/common/functions.php'); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php include_once(__DIR__ . '/common/head.php'); ?>
  <style>
    /* 1行に適用 */
    .row-nowrap {
      white-space: nowrap;
    }

    /* 第1から第2カラムまで適用 */
    .col12-nowrap td:nth-of-type(-n+2), th:nth-of-type(-n+2) {
      white-space: nowrap;
    }

    /* 第4カラムから最後のカラムまで適用 */
    .col456-nowrap td:nth-of-type(n+4), th:nth-of-type(n+4) {
      white-space: nowrap;
    }

    /* 第5カラムに適用 */
    .col5-align td:nth-of-type(5) {
      text-align: right;
    }
  </style>
</head>
<body>
  <header>
<?php include_once(__DIR__ . '/common/header.php'); ?>
  </header>
  <main>
<?php if (isset($error_message_1)) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo $error_message_1; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>
<?php if (isset($error_message_2)) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo $error_message_2; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>
<?php if (isset($success_message)) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo $success_message; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>
<?php if (isset($number_of_data) && isset($sum_price)) { ?>
    <p class="text-end">データ件数：<span class="fw-bold text-danger"><?php echo number_format($number_of_data); ?></span> 件 / 合計金額：<span class="fw-bold text-danger"><?php echo number_format($sum_price); ?></span> 円</p>
<?php } ?>
    <div class="table-responsive">
      <form action="." method="POST">
        <table class="table table-striped table-bordered align-middle col12-nowrap col456-nowrap col5-align">
          <thead>
            <tr class="text-center row-nowrap">
              <th>
                日付
                <input id="purchase-date-asc" class="btn-check" type="radio" name="order" value="2 asc" autocomplete="off"<?php echo $order === '2 asc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="purchase-date-asc">▲</label>
                <input id="purchase-date-desc" class="btn-check" type="radio" name="order" value="2 desc" autocomplete="off"<?php echo $order === '2 desc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="purchase-date-desc">▼</label>
              </th>
              <th>
                分類
                <input id="category-name-asc" class="btn-check" type="radio" name="order" value="3 asc" autocomplete="off"<?php echo $order === '3 asc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="category-name-asc">▲</label>
                <input id="category-name-desc" class="btn-check" type="radio" name="order" value="3 desc" autocomplete="off"<?php echo $order === '3 desc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="category-name-desc">▼</label>
              </th>
              <th>
                商品名
                <input id="product-name-asc" class="btn-check" type="radio" name="order" value="4 asc" autocomplete="off"<?php echo $order === '4 asc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="product-name-asc">▲</label>
                <input id="product-name-desc" class="btn-check" type="radio" name="order" value="4 desc" autocomplete="off"<?php echo $order === '4 desc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="product-name-desc">▼</label>
              </th>
              <th>
                店
                <input id="shop-name-asc" class="btn-check" type="radio" name="order" value="5 asc" autocomplete="off"<?php echo $order === '5 asc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="shop-name-asc">▲</label>
                <input id="shop-name-desc" class="btn-check" type="radio" name="order" value="5 desc" autocomplete="off"<?php echo $order === '5 desc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="shop-name-desc">▼</label>
              </th>
              <th>
                金額
                <input id="price-asc" class="btn-check" type="radio" name="order" value="6 asc" autocomplete="off"<?php echo $order === '6 asc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="price-asc">▲</label>
                <input id="price-desc" class="btn-check" type="radio" name="order" value="6 desc" autocomplete="off"<?php echo $order === '6 desc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="price-desc">▼</label>
              </th>
              <th>
                <button id="reset-btn" class="btn btn-secondary btn-sm" type="submit" name="operation" value="reset">リセット</button>
              </th>
            </tr>
            <tr>
              <th>
                <input id="purchase-date-tbox" class="form-control" type="text" name="input[]" value="<?php echo $keyword['purchase_date'] === '%' ? '' : $keyword['purchase_date']; ?>" placeholder="検索・登録・変更">
              </th>
              <th>
                <input id="category-name-tbox" class="form-control" type="text" name="input[]" value="<?php echo $keyword['category_name'] === '%' ? '' : $keyword['category_name']; ?>" autocomplete="on" list="category_name_list" placeholder="検索・登録・変更">
                <datalist id="category_name_list">
<?php
foreach ((array)$categories as $category) {
  $category_name = $category[1];
  echo '<option value="' . h($category_name) . '">', PHP_EOL;
}
?>
                </datalist>
              </th>
              <th>
                <input id="product-name-tbox" class="form-control" type="text" name="input[]" value="<?php echo $keyword['product_name'] === '%' ? '' : $keyword['product_name']; ?>" placeholder="検索・登録・変更">
              </th>
              <th>
                <input id="shop-name-tbox" class="form-control" type="text" name="input[]" value="<?php echo $keyword['shop_name'] === '%' ? '' : $keyword['shop_name']; ?>" autocomplete="on" list="shop_name_list" placeholder="検索・登録・変更">
                <datalist id="shop_name_list">
<?php
foreach ((array)$shops as $shop) {
  $shop_name = $shop[1];
  echo '<option value="' . h($shop_name) . '">', PHP_EOL;
}
?>
                </datalist>
              </th>
              <th>
                <input id="price-tbox" class="form-control" type="text" name="input[]" value="<?php echo $keyword['price'] === '%' ? '' : $keyword['price']; ?>" placeholder="検索・登録・変更">
              </th>
              <th>
                <button id="search-btn" class="btn btn-primary btn-sm" type="submit" name="operation" value="search">検索</button>
<?php if ($isDemoMode === true) { ?>
                <button id="insert-btn" class="btn btn-dark btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#demo-mode-modal">登録</button>
<?php } else { ?>
                <button id="insert-btn" class="btn btn-dark btn-sm" type="submit" name="operation" value="insert">登録</button>
<?php } ?>
              </th>
            </tr>
          </thead>
          <tbody>
<?php foreach ((array)$data as $d) { ?>
            <tr>
              <td><?php echo h($d['purchase_date']); ?></td>
              <td><?php echo h($d['category_name']); ?></td>
              <td><?php echo h($d['product_name']); ?></td>
              <td><?php echo h($d['shop_name']); ?></td>
              <td><?php echo number_format(h($d['price'])); ?> 円</td>
              <td>
<?php if ($isDemoMode === true) { ?>
                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#demo-mode-modal">変更</button>
                <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#demo-mode-modal">削除</button>
<?php } else { ?>
                <button class="btn btn-success btn-sm update-btn" type="submit" name="operation" value="update,<?php echo $d['order_id']; ?>">変更</button>
                <button class="btn btn-danger btn-sm delete-btn" type="submit" name="operation" value="delete,<?php echo $d['order_id']; ?>">削除</button>
<?php } ?>
              </td>
            </tr>
<?php } ?>
          </tbody>
        </table>
      </form>
    </div><!-- table-responsive -->
  </main>
<?php include_once(__DIR__ . '/common/script.php'); ?>
  <script>
    // YYYY-MM-DD形式の日付を返す
    function formatDate(dt) {
      let y = dt.getFullYear();
      let m = ('00' + (dt.getMonth() + 1)).slice(-2);
      let d = ('00' + dt.getDate()).slice(-2);
      return (y + '-' + m + '-' + d);
    }

    window.addEventListener('DOMContentLoaded', function() {
      // テキストボックスでEnterキーを押すと検索ボタンを押す処理
      document.querySelectorAll('input').forEach(function(input) {
        input.addEventListener('keydown', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            let btn = document.getElementById('search-btn');
            let event = new MouseEvent('click');
            btn.dispatchEvent(event);
          }
        });
      });

      // 登録の確認
      document.getElementById('insert-btn').addEventListener('click', function(e) {
        let checked = confirm('本当に登録してよいですか？');
        if (checked === false) {
          e.preventDefault();
        }
      });

      // 変更の確認
      document.querySelectorAll('.update-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
          let checked = confirm('本当に変更してよいですか？');
          if (checked === false) {
            e.preventDefault();
          }
        });
      });

      // 削除の確認
      document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
          let checked = confirm('本当に削除してよいですか？');
          if (checked === false) {
            e.preventDefault();
          }
        });
      });

      // ショートカットキー処理
      window.addEventListener('keydown', function(e) {
        if (e.ctrlKey) {
          switch (e.key) {
            case '1':  // 日付テキストボックスにフォーカスする処理
              e.preventDefault();
              document.getElementById('purchase-date-tbox').focus();
              break;
            case '2':  // 分類テキストボックスにフォーカスする処理
              e.preventDefault();
              document.getElementById('category-name-tbox').focus();
              break;
            case '3':  // 商品名テキストボックスにフォーカスする処理
              e.preventDefault();
              document.getElementById('product-name-tbox').focus();
              break;
            case '4':  // 店テキストボックスにフォーカスする処理
              e.preventDefault();
              document.getElementById('shop-name-tbox').focus();
              break;
            case '5':  // 金額テキストボックスにフォーカスする処理
              e.preventDefault();
              document.getElementById('price-tbox').focus();
              break;
            case 'd':  // 日付テキストボックスに今日の日付を入力する処理
              e.preventDefault();
              document.getElementById('purchase-date-tbox').value = formatDate(new Date());
              break;
            case 'r':  // リセットボタンを押す処理
              e.preventDefault();
              document.getElementById('reset-btn').dispatchEvent(new MouseEvent('click'));
              break;
            case 's':  // 検索ボタンを押す処理
              e.preventDefault();
              document.getElementById('search-btn').dispatchEvent(new MouseEvent('click'));
              break;
            case 'i':  // 登録ボタンを押す処理
              e.preventDefault();
              document.getElementById('insert-btn').dispatchEvent(new MouseEvent('click', {cancelable: true}));
              break;
          }
        }
      });
    });
  </script>
</body>
</html>
