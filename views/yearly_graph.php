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
      <canvas id="yearly-bar-chart"></canvas>
    </div>
  </main>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<?php
foreach ((array)$data as $d) {
  $data_set[$d['purchase_year']] = $d['sum_price'];
}
?>
  <script>
    let ctx = document.getElementById("yearly-bar-chart").getContext('2d');
    let label = [];
    let data = [];
<?php foreach ($data_set as $year => $price) { ?>
    label.push('<?= $year ?>年');
    data.push('<?= $price ?>');
<?php } ?>
    let dataset = [{
      data: data,
      backgroundColor: 'rgba(243, 112, 83, 0.5)',
      borderColor: 'rgba(243, 112, 83, 1)',
      borderWidth: 1
    }];
    let yearly_bar_chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: label,
        datasets: dataset,
      },
      options: {
        title: {
          display: true,
          text: '年毎グラフ'
        },
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: '年'
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
