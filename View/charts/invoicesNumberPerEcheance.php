<?php 
  require_once '../Model/dbConfigUser.php';
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<style>
  body {
    font-family: sans-serif;
  }

  label {
    font-size: smaller;
  }

  button {
    border: none;
    height: 11px;
    width: 41px;
  }
</style>


  <?php
    $conn = connectToUserDatabase($_COOKIE['username']);
    $sql = "SELECT echeance, COUNT(echeance) FROM facture_view GROUP BY echeance;";
    $result = $conn->query($sql);
    $xValues = array();
    $yValues = array();
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        array_push($xValues, $row['echeance']);
        array_push($yValues, $row['COUNT(echeance)']);
      }
    } 
    else {
      echo "No records has been found";
    }

    $conn->close();
  ?>

  <canvas id="myChart2" style="width:100%;max-width:600px"></canvas>
  <div class="button_group_chart_2">
  <?php
    foreach($xValues as $idx => $label) {
      echo '<div class="lbl">';
      echo '<button id="' . $idx . '" onclick="toggleLabel(' . $idx . ')"></button>';
      echo '<label for="' . $idx . '">' . $label . '</label>';
      echo '</div>';
    }
  ?>
  </div>


  <script>
    // generate random color
    function dynamicColors() {
      var r = Math.floor(Math.random() * 255);
      var g = Math.floor(Math.random() * 255);
      var b = Math.floor(Math.random() * 255);
      return "rgba(" + r + "," + g + "," + b + ", 0.5)";
    }

    // generate array of colors
    function poolColors(a) {
      var pool = [];
      for(i = 0; i < a; i++) {
          pool.push(dynamicColors());
      }
      return pool;
    }

    var xValues = <?php echo json_encode($xValues);?>;
    var yValues = <?php echo json_encode($yValues);?>;
    var backgroundColors = poolColors(yValues.length);
    var toggles = Array(5).fill(true);

    for (let i = 0; i < yValues.length; i++) {
      document.getElementById(i).style.backgroundColor = backgroundColors[i];
    }

    var originalData = {
      labels: xValues,
      datasets: [{
        data: yValues,
        backgroundColor: backgroundColors
      }]
    };

    var ctx = document.getElementById('myChart2').getContext('2d');
    var pieChart = new Chart(ctx, {
      type: 'pie',
      data: JSON.parse(JSON.stringify(originalData)),
      options: {
        tooltips: {
          callbacks: {
            label: function (tooltipItem, data) {
              var dataset = data.datasets[tooltipItem.datasetIndex];
              var total = dataset.data.reduce(function (previousValue, currentValue) {
                return Number(previousValue) + Number(currentValue);
              });
              var currentValue = dataset.data[tooltipItem.index];
              var percentage = ((currentValue / total) * 100).toFixed(2);
              return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' + percentage + '%)';
            }
          }
        },
        legend: {
          display: false // Hide the chart labels
        }
      }
    });

    function toggleLabel(index) {
      if(toggles[index]) {
        document.getElementById(index).nextElementSibling.style.textDecoration = "line-through";
        toggles[index] = false;
      } else {
        document.getElementById(index).nextElementSibling.style.textDecoration = "none";
        toggles[index] = true;
      }

      // Toggle the visibility of the label
      var meta = pieChart.getDatasetMeta(0);
      meta.data[index].hidden = !meta.data[index].hidden;

      // Update the dataset and label data
      pieChart.data.datasets[0].data = meta.data.map(function (element) {
        return element.hidden ? 0 : originalData.datasets[0].data[element._index];
      });
      pieChart.data.labels = meta.data.map(function (element) {
        return element.hidden ? '' : originalData.labels[element._index];
      });

      // Update the chart
      pieChart.update();
    }

  </script>

