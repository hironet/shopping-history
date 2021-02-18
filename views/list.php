<?php
function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>
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

    /* 先頭から2カラム目までに適用 */
    .col12-nowrap td:nth-of-type(-n+2), th:nth-of-type(-n+2) {
      white-space: nowrap;
    }

    /* 4カラム目から最後までに適用 */
    .col456-nowrap td:nth-of-type(n+4), th:nth-of-type(n+4) {
      white-space: nowrap;
    }

    .col5-align td:nth-of-type(5) {
      text-align: right;
    }
  </style>
</head>
<body>
  <header>
    <nav id="nav" class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
      <span class="navbar-brand">買い物履歴管理システム</span>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navbarNavAltMarkup" class="collapse navbar-collapse justify-content-center">
        <div class="navbar-nav">
          <a class="nav-link" href=".">一覧表示</a>
          <a class="nav-link" href="." data-bs-toggle="modal" data-bs-target="#import-file-modal">インポート</a>
          <a class="nav-link" href="." data-bs-toggle="modal" data-bs-target="#help-modal">ヘルプ</a>
        </div>
      </div>
    </nav>
    <form action="." method="POST" enctype="multipart/form-data">
      <!-- ファイルインポートモーダル -->
      <div class="modal fade" id="import-file-modal" tabindex="-1" aria-labelledby="import-file-modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="import-file-modal-label">CSVファイルのインポート</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>インポートするCSVファイルを選択して下さい。</p>
              <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
              <input type="file" name="csv-file" size="200">
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">キャンセル</button>
              <button class="btn btn-primary" type="submit" name="operation" value="import">インポート</button>
            </div>
          </div>
        </div>
      </div><!-- ファイルインポートモーダル -->
    </form>
    <!-- ヘルプモーダル -->
    <div class="modal fade" id="help-modal" tabindex="-1" aria-labelledby="help-modal-label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="help-modal-label">ヘルプ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h6 class="text-decoration-underline">■ 検索について</h6>
            <ul>
              <li>検索キーワードには以下のパターンを使用できる</li>
            </ul>
            <table class="table table-striped table-bordered align-middle">
              <thead>
                <tr class="text-center">
                  <th>パターン</th>
                  <th>説明</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>%</td>
                  <td>0文字以上の任意の文字列にマッチする</td>
                </tr>
                <tr>
                  <td>_</td>
                  <td>任意の1文字にマッチする</td>
                </tr>
              </tbody>
            </table>
            <h6 class="text-decoration-underline">■ 登録について</h6>
            <ul>
              <li>テキストボックスにデータを入力し、登録ボタンを押す</li>
              <li>商品名の入力は任意であるが、その他のカラムは必須となる</li>
            </ul>
            <h6 class="text-decoration-underline">■ 変更について</h6>
            <ul>
              <li>変更したいカラムのテキストボックスにデータを入力し、変更したいレコードの変更ボタンを押す</li>
              <li>最低1つのカラムは入力必須となる</li>
            </ul>
            <h6 class="text-decoration-underline">■ 削除について</h6>
            <ul>
              <li>削除したいレコードの削除ボタンを押す</li>
            </ul>
            <h6 class="text-decoration-underline">■ ショートカットキーについて</h6>
            <ul>
              <li>以下のショートカットキーを使用できる</li>
            </ul>
            <table class="table table-striped table-bordered align-middle">
              <thead>
                <tr class="text-center">
                  <th>キー</th>
                  <th>説明</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><kbd>Ctrl + 1</kbd></td>
                  <td>日付テキストボックスにフォーカスする</td>
                </tr>
                <tr>
                  <td><kbd>Ctrl + 2</kbd></td>
                  <td>分類テキストボックスにフォーカスする</td>
                </tr>
                <tr>
                  <td><kbd>Ctrl + 3</kbd></td>
                  <td>商品名テキストボックスにフォーカスする</td>
                </tr>
                <tr>
                  <td><kbd>Ctrl + 4</kbd></td>
                  <td>店テキストボックスにフォーカスする</td>
                </tr>
                <tr>
                  <td><kbd>Ctrl + 5</kbd></td>
                  <td>価格テキストボックスにフォーカスする</td>
                </tr>
                <tr>
                  <td><kbd>Ctrl + d</kbd></td>
                  <td>日付テキストボックスに今日の日付を入力する</td>
                </tr>
                <tr>
                  <td><kbd>Ctrl + r</kbd></td>
                  <td>リセットボタンを押す</td>
                </tr>
                <tr>
                  <td><kbd>Ctrl + s</kbd></td>
                  <td>検索ボタンを押す</td>
                </tr>
                <tr>
                  <td><kbd>Ctrl + i</kbd></td>
                  <td>登録ボタンを押す</td>
                </tr>
                <tr>
                  <td><kbd>t</kbd></td>
                  <td>ページ最上部にスクロールする</td>
                </tr>
                <tr>
                  <td><kbd>b</kbd></td>
                  <td>ページ最下部にスクロールする</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">閉じる</button>
          </div>
        </div>
      </div>
    </div><!-- ヘルプモーダル -->
  </header>
  <main>
    <p class="text-end">データ件数：<span class="fw-bold text-danger"><?php echo number_format($number_of_data); ?></span> 件 / 合計金額：<span class="fw-bold text-danger"><?php echo number_format($sum_price); ?></span> 円</p>
    <div class="table-responsive">
      <form action="." method="POST">
        <table class="table table-striped table-bordered align-middle col12-nowrap col456-nowrap col5-align">
          <thead>
            <tr class="text-center">
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
                価格
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
foreach ($categories as $category) {
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
foreach ($shops as $shop) {
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
                <button id="insert-btn" class="btn btn-dark btn-sm" type="submit" name="operation" value="insert">登録</button>
              </th>
            </tr>
          </thead>
          <tbody>
<?php
foreach ($data as $d) {
?>
            <tr>
              <td><?php echo h($d['purchase_date']); ?></td>
              <td><?php echo h($d['category_name']); ?></td>
              <td><?php echo h($d['product_name']); ?></td>
              <td><?php echo h($d['shop_name']); ?></td>
              <td><?php echo number_format(h($d['price'])); ?> 円</td>
              <td>
                <button class="btn btn-success btn-sm" type="submit" name="operation" value="update,<?php echo $d['order_id']; ?>">変更</button>
                <button class="btn btn-danger btn-sm" type="submit" name="operation" value="delete,<?php echo $d['order_id']; ?>">削除</button>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
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
      document.querySelectorAll('input').forEach(function (input) {
        input.addEventListener('keydown', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            let btn = document.getElementById('search-btn');
            let event = new MouseEvent('click');
            btn.dispatchEvent(event);
          }
        });
      });

      // ショートカットキー処理
      window.addEventListener('keydown', function(e) {
        switch (e.key) {
          case 'b':  // ページ最下部にスクロールする処理
            let doc = document.documentElement;
            let bottom = doc.scrollHeight - doc.clientHeight;
            window.scroll(0, bottom);
            break;
          case 't':  // ページ最上部にスクロールする処理
            window.scroll(0, 0);
            break;
        }

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
            case '5':  // 価格テキストボックスにフォーカスする処理
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
              document.getElementById('insert-btn').dispatchEvent(new MouseEvent('click'));
              break;
          }
        }
      });
    });
  </script>
</body>
</html>
