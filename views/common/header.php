<nav id="nav" class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">買い物履歴管理システム</span>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"   -controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbarNavAltMarkup" class="collapse navbar-collapse">
      <div class="navbar-nav me-auto">
        <a class="nav-link" href=".">日毎一覧</a>
        <a class="nav-link" href=".?menu=monthly">月毎一覧</a>
        <a class="nav-link" href=".?menu=yearly">年毎一覧</a>
      </div>
<?php if ($isDemoMode === true) { ?>
      <button class="btn btn-outline-success mx-2" type="button" data-bs-toggle="modal" data-bs-target="#demo-mode-modal">インポート</button>
<?php } else { ?>
      <button class="btn btn-outline-success mx-2" type="button" data-bs-toggle="modal" data-bs-target="#file-import-modal">インポート</button>
<?php } ?>
      <button class="btn btn-outline-primary mx-2" type="button" data-bs-toggle="modal" data-bs-target="#help-modal">ヘルプ</button>
    </div>
  </div>
</nav>
<form action="." method="POST" enctype="multipart/form-data">
  <!-- ファイルインポートモーダル -->
  <div class="modal fade" id="file-import-modal" tabindex="-1" aria-labelledby="file-import-modal-label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="file-import-modal-label">インポート</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
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
<!-- デモモードモーダル -->
<div class="modal fade" id="demo-mode-modal" tabindex="-1" aria-labelledby="demo-mode-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="demo-mode-modal-label">禁止されている操作</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>デモモードのため、その操作は行えません。</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">閉じる</button>
      </div>
    </div>
  </div>
</div><!-- デモモードモーダル -->
