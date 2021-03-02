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
      <form action=".?menu=monthly" method="POST">
        <table class="table table-striped table-bordered align-middle col2-align">
          <thead>
            <tr class="text-center row-nowrap">
              <th>
                月
                <input id="purchase-month-asc" class="btn-check" type="submit" name="order" value="1 asc" autocomplete="off"<?php echo $order === '1 asc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="purchase-month-asc">▲</label>
                <input id="purchase-month-desc" class="btn-check" type="submit" name="order" value="1 desc" autocomplete="off"<?php echo $order === '1 desc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="purchase-month-desc">▼</label>
              </th>
              <th>
                商品数
                <input id="count-asc" class="btn-check" type="submit" name="order" value="2 asc" autocomplete="off"<?php echo $order === '2 asc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="count-asc">▲</label>
                <input id="count-desc" class="btn-check" type="submit" name="order" value="2 desc" autocomplete="off"<?php echo $order === '2 desc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="count-desc">▼</label>
              </th>
              <th>
                合計金額
                <input id="sum-price-asc" class="btn-check" type="submit" name="order" value="3 asc" autocomplete="off"<?php echo $order === '3 asc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="sum-price-asc">▲</label>
                <input id="sum-price-desc" class="btn-check" type="submit" name="order" value="3 desc" autocomplete="off"<?php echo $order === '3 desc' ? ' checked' : ''; ?>>
                <label class="btn-sm btn-secondary" for="sum-price-desc">▼</label>
              </th>
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
      </form>
    </div><!-- table-responsive -->
  </main>
<?php include_once(__DIR__ . '/common/script.php'); ?>
</body>
</html>
