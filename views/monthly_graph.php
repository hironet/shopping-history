<?php include_once(__DIR__ . '/common/functions.php'); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php include_once(__DIR__ . '/common/head.php'); ?>
</head>
<body>
  <header>
<?php include_once(__DIR__ . '/common/header.php'); ?>
  </header>
  <main>
<?php if (isset($error_message_1)) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= $error_message_1 ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>
    <div class="chart-container mx-auto" style="position: relative; height:60vh; width:95vw">
      <canvas id="monthly-bar-chart"></canvas>
    </div>
  </main>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<?php
foreach ((array)$data as $d) {
  $year = date('Y', strtotime($d['purchase_month']));
  $month = date('m', strtotime($d['purchase_month']));
  $data_set[$year][$month] = $d['sum_price'];
}
?>
  <script>
    let ctx = document.getElementById("monthly-bar-chart").getContext('2d');
    let dataset = [];
    let bgcolor = [
      'rgba(110, 167, 161, 0.5)',
      'rgba(98, 137, 164, 0.5)',
      'rgba(92, 115, 183, 0.5)',
      'rgba(115, 97, 171, 0.5)',
      'rgba(143, 100, 171, 0.5)',
      'rgba(199, 103, 129, 0.5)',
      'rgba(243, 112, 83, 0.5)',
      'rgba(246, 139, 88, 0.5)',
      'rgba(253, 191, 100, 0.5)',
      'rgba(248, 235, 101, 0.5)',
      'rgba(192, 219, 117, 0.5)',
      'rgba(122, 185, 119, 0.5)'
    ];
    let bdcolor = [
      'rgba(110, 167, 161, 1)',
      'rgba(98, 137, 164, 1)',
      'rgba(92, 115, 183, 1)',
      'rgba(115, 97, 171, 1)',
      'rgba(143, 100, 171, 1)',
      'rgba(199, 103, 129, 1)',
      'rgba(243, 112, 83, 1)',
      'rgba(246, 139, 88, 1)',
      'rgba(253, 191, 100, 1)',
      'rgba(248, 235, 101, 1)',
      'rgba(192, 219, 117, 1)',
      'rgba(122, 185, 119, 1)'
    ];
<?php foreach ($data_set as $year => $price) { ?>
    dataset.push({
      label: '<?= $year ?>年',
      data: [<?=
      isset($price['01']) ? $price['01'] : 0, ',',
      isset($price['02']) ? $price['02'] : 0, ',',
      isset($price['03']) ? $price['03'] : 0, ',',
      isset($price['04']) ? $price['04'] : 0, ',',
      isset($price['05']) ? $price['05'] : 0, ',',
      isset($price['06']) ? $price['06'] : 0, ',',
      isset($price['07']) ? $price['07'] : 0, ',',
      isset($price['08']) ? $price['08'] : 0, ',',
      isset($price['09']) ? $price['09'] : 0, ',',
      isset($price['10']) ? $price['10'] : 0, ',',
      isset($price['11']) ? $price['11'] : 0, ',',
      isset($price['12']) ? $price['12'] : 0
      ?>],
      backgroundColor: bgcolor[<?= $year ?> % 12],
      borderColor: bdcolor[<?= $year ?> % 12],
      borderWidth: 1
    });
<?php } ?>
    let monthly_bar_chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
        datasets: dataset,
      },
      options: {
        title: {
          display: true,
          text: '月毎グラフ'
        },
        scales: {
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: '月'
            }
          }],
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: '合計金額'
            },
            ticks: {
              beginAtZero: true
            }
          }]
        },
        maintainAspectRatio: false
      }
    });
  </script>
<?php include_once(__DIR__ . '/common/script.php'); ?>
</body>
</html>
