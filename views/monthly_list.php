<?php include_once(__DIR__ . '/common/functions.php'); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php include_once(__DIR__ . '/common/head.php'); ?>
  <style>
    /* 第2カラムに適用 */
    .col2-align td:nth-of-type(2) {
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
<?php if (isset($number_of_data)) { ?>
    <p class="text-end">データ件数：<span class="fw-bold text-danger"><?php echo number_format($number_of_data); ?></span> 件</p>
<?php } ?>
    <div class="table-responsive">
      <table class="table table-striped table-bordered align-middle col2-align">
        <thead>
          <tr class="text-center row-nowrap">
            <th>月</th>
            <th>商品数</th>
            <th>合計金額</th>
          </tr>
        </thead>
        <tbody>
<?php foreach ((array)$data as $d) { ?>
          <tr>
            <td><?php echo h($d['purchase_month']); ?></td>
            <td><?php echo h($d['count']); ?></td>
            <td><?php echo number_format(h($d['sum_price'])); ?> 円</td>
          </tr>
<?php } ?>
        </tbody>
      </table>
    </div><!-- table-responsive -->
  </main>
<?php include_once(__DIR__ . '/common/script.php'); ?>
</body>
</html>
