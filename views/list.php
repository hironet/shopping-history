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
        padding-top: 30px;
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
      <table class="table table-striped table-bordered">
        <thead>
          <tr class="text-center text-nowrap">
            <th>日付</th>
            <th>分類</th>
            <th>商品名</th>
            <th>店</th>
            <th>価格</th>
          </tr>
        </thead>
        <tbody>
<?php foreach ($shopping_histories as $sh) { ?>
          <tr>
            <td class="text-nowrap"><?php echo date('Y/m/d(D)', strtotime($sh[1])); ?></td>
            <td class="text-nowrap"><?php echo $sh[2]; ?></td>
            <td><?php echo $sh[3]; ?></td>
            <td class="text-nowrap"><?php echo $sh[4]; ?></td>
            <td class="text-end text-nowrap"><?php echo number_format($sh[5]) . " 円"; ?></td>
          </tr>
<?php } ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
