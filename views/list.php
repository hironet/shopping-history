<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <title>買い物履歴管理システム</title>
  <style>
    @media screen and (max-width: 480px) {
      body {
        padding-top: 60px;
      }
    }

    @media screen and (min-width: 1024px) {
      body {
        padding-top: 60px;
      }
    }

    #nav {
      opacity: 0.9;
    }
  </style>
</head>
<body>
  <header>
    <nav id="nav" class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navbarNavAltMarkup" class="collapse navbar-collapse justify-content-center">
      </div>
    </nav>
  </header>
  <main>
    <div class="table-responsive">
      <form action="#" method="POST">
        <table class="table table-striped table-bordered align-middle">
          <thead>
            <tr class="text-center text-nowrap">
              <th>日付</th>
              <th>分類</th>
              <th>商品名</th>
              <th>店</th>
              <th>価格</th>
              <th>操作</th>
            </tr>
            <tr>
              <th>
                <input class="form-control" type="text" name="keyword[]" placeholder="検索">
              </th>
              <th>
                <select class="form-control" name="keyword[]">
                  <option value="" selected></option>
<?php
foreach ($categories as $category) {
  $category_name = $category[1];
  echo '<option value="' . $category_name . '">' . $category_name . '</option>';
}
?>
                </select>
              </th>
              <th>
                <input class="form-control" type="text" name="keyword[]" placeholder="検索">
              </th>
              <th>
                <select class="form-control" name="keyword[]">
                  <option value="" selected></option>
<?php
foreach ($shops as $shop) {
  $shop_name = $shop[1];
  echo '<option value="' . $shop_name . '">' . $shop_name . '</option>';
}
?>
                </select>
              </th>
              <th>
                <input class="form-control" type="number" name="keyword[]" placeholder="検索">
              </th>
              <th>
                <button class="btn btn-primary btn-sm" type="submit" name="operation" value="search">検索</button>
                <button class="btn btn-secondary btn-sm" type="reset">取消</button>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <input class="form-control" type="date" name="insert_data[]">
              </td>
              <td>
                <input class="form-control" type="text" name="insert_data[]" autocomplete="on" list="category_name_list">
                <datalist id="category_name_list">
<?php
foreach ($categories as $category) {
  $category_name = $category[1];
  echo '<option value="' . $category_name . '">';
}
?>
                </datalist>
              </td>
              <td>
                <input class="form-control" type="text" name="insert_data[]">
              </td>
              <td>
                <input class="form-control" type="text" name="insert_data[]" autocomplete="on" list="shop_name_list">
                <datalist id="shop_name_list">
<?php
foreach ($shops as $shop) {
  $shop_name = $shop[1];
  echo '<option value="' . $shop_name . '">';
}
?>
                </datalist>
              </td>
              <td>
                <input class="form-control" type="number" name="insert_data[]">
              </td>
              <td>
                <button class="btn btn-primary btn-sm" type="submit" name="operation" value="insert">登録</button>
                <button class="btn btn-secondary btn-sm" type="reset">取消</button>
              </td>
            </tr>
<?php
foreach ($shopping_histories as $sh) {
  $order_id = $sh[0];
  $purchase_date = $sh[1];
  $category_name = $sh[2];
  $product_name = $sh[3];
  $shop_name = $sh[4];
  $price = $sh[5];
?>
            <tr>
              <td class="text-nowrap"><?php echo date('Y/m/d(D)', strtotime($purchase_date)); ?></td>
              <td class="text-nowrap"><?php echo $category_name; ?></td>
              <td><?php echo $product_name; ?></td>
              <td class="text-nowrap"><?php echo $shop_name ?></td>
              <td class="text-end text-nowrap"><?php echo number_format($price) . " 円"; ?></td>
              <td class="text-nowrap">
                <button class="btn btn-success btn-sm" type="submit" name="operation" value="update,<?php echo $order_id; ?>">変更</button>
                <button class="btn btn-danger btn-sm" type="submit" name="operation" value="delete,<?php echo $order_id; ?>">削除</button>
              </td>
            </tr>
<?php
}
?>
          </tbody>
        </table>
      </form>
    </div>
  </main>
</body>
</html>
