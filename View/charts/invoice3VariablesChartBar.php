<?php 
  require_once '../Model/dbConfigUser.php';
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<div class="input_group_graphs">
  <div>
  <input type="radio" id="entite" name="options" value="entite" onclick="createChart()" checked ="checked">
<label for="entite">Entite</label>
  </div>
<div>
<input type="radio" id="po" name="options" value="po" onclick="createChart2()">
<label for="po">Type d'achat PO</label>
</div>

</div>


<?php
  $conn = connectToUserDatabase($_COOKIE['username']);
  $sql = "SELECT nomEntite, echeance, COUNT(nomEntite) FROM entite NATURAL JOIN facture_view GROUP BY nomEntite, echeance;";
  $sql2 = "SELECT  SUBSTR(typeDAchatPO, 1, 1) AS typedachatpo, echeance, COUNT(*) AS commande_count FROM commande NATURAL JOIN facture_view GROUP BY SUBSTR(typeDAchatPO, 1, 1), echeance;";
  $result = $conn->query($sql);
  $result2 = $conn->query($sql2);

  $data = array();
  $labels = array();

  $data2 = array();
  $labels2 = array();

  $echeance = array(
    'Echue' => 0,
    'Echue dans 7 jours' => 1,
    'Echue dans 30 jours' => 2,
    'Echue dans 60 jours' => 3
  );

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if (count($data) == 0) {
        $data[$row['nomEntite']] = [0, 0, 0, 0];
        $data[$row['nomEntite']][$echeance[$row['echeance']]] = (int)$row['COUNT(nomEntite)'];
        array_push($labels, $row['nomEntite']);
      } else {
        if (in_array($row['nomEntite'], $labels)) {
            $data[$row['nomEntite']][$echeance[$row['echeance']]] = (int)$row['COUNT(nomEntite)'];
        } else {
            $data[$row['nomEntite']] = [0, 0, 0, 0];
            $data[$row['nomEntite']][$echeance[$row['echeance']]] = (int)$row['COUNT(nomEntite)'];
            array_push($labels, $row['nomEntite']);
        }
      }
    }
  } 
  else {
    echo "No records has been found";
  }
  $datasets = array();
  foreach ($data as &$value) {
    array_push($datasets, $value);
  }

  if ($result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
      if (count($data2) == 0) {
        $data2[$row['typedachatpo']] = [0, 0, 0, 0];
        $data2[$row['typedachatpo']][$echeance[$row['echeance']]] = (int)$row['commande_count'];
        array_push($labels2, $row['typedachatpo']);
      } else {
        if (in_array($row['typedachatpo'], $labels2)) {
            $data2[$row['typedachatpo']][$echeance[$row['echeance']]] = (int)$row['commande_count'];
        } else {
            $data2[$row['typedachatpo']] = [0, 0, 0, 0];
            $data2[$row['typedachatpo']][$echeance[$row['echeance']]] = (int)$row['commande_count'];
            array_push($labels2, $row['typedachatpo']);
        }
      }
    }
  } 
  else {
    echo "No records has been found";
  }
  $datasets2 = array();
  foreach ($data2 as &$value) {
    array_push($datasets2, $value);
  }
  $conn->close();
?>

<canvas id="dynaChart1" style="width:100%;max-width:600px"></canvas>
<canvas id="dynaChart2" style="width:100%;max-width:600px"></canvas>

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

  function createChart() {
    var labels = <?php echo json_encode($labels);?>;
    var datasets = <?php echo json_encode($datasets);?>;
  
    const chartData = [];
    for (let i = 0; i < datasets.length; i++) {
    const dataset = {
        label: labels[i],
        data: datasets[i],
        backgroundColor: dynamicColors()
    };
    chartData.push(dataset);
    }

  // Chart configuration
    const chartConfig = {
    type: 'bar',
    data: {
        labels: ['Echue', 'Echue dans 7 jours', 'Echue dans 30 jours', 'Echue dans 60 jours'],
        datasets: chartData
    },
    options: {
        // Configure chart options as needed
        legend: {display: false},
        title: {
            display: true,
            text: "Nombres de factures par entité"
        },
        scales: {
            yAxes: [{
            ticks: {
                beginAtZero: true,
                //max: Math.max(...yValues) + 1,
                stepSize: 1
            }    
            }]
        }
    }
    };

    var chartsToKeep = ["entiteChart"];

// Iterate through all chart instances
Chart.helpers.each(Chart.instances, function (instance) {
  // Check if the current instance's ID is in the chartsToKeep array
  if (!chartsToKeep.includes(instance.chart.canvas.id)) {
    // Destroy the chart instance if it's not in the chartsToKeep array
    instance.destroy();
  }
});
    //document.getElementById('dynaChart2').getContext('2d').destroy();
    var ctx = document.getElementById('dynaChart1').getContext('2d');
    //ctx.destroy();
    new Chart(ctx, chartConfig);
    //document.getElementById('dynaChart2').getContext('2d').clear();
    //document.querySelector("#dynaChart2").innerHTML = '<canvas id="dynaChart1"></canvas>';
  }

  function createChart2() {
    var labels2 = <?php echo json_encode($labels2);?>;
    var datasets2 = <?php echo json_encode($datasets2);?>;
  
    const chartData2 = [];
    for (let i = 0; i < datasets2.length; i++) {
    const dataset2 = {
        label: labels2[i],
        data: datasets2[i],
        backgroundColor: dynamicColors()
    };
    chartData2.push(dataset2);
    }

  // Chart configuration
    const chartConfig2 = {
    type: 'bar',
    data: {
        labels: ['Echue', 'Echue dans 7 jours', 'Echue dans 30 jours', 'Echue dans 60 jours'],
        datasets: chartData2
    },
    options: {
        // Configure chart options as needed
        legend: {display: false},
        title: {
            display: true,
            text: "Nombres de factures par type d'achat po"
        },
        scales: {
            yAxes: [{
            ticks: {
                beginAtZero: true,
                //max: Math.max(...yValues) + 1,
                stepSize: 1
            }    
            }]
        }
    }
    };
// Define an array of chart IDs that you want to keep
var chartsToKeep = ["entiteChart"];

// Iterate through all chart instances
Chart.helpers.each(Chart.instances, function (instance) {
  // Check if the current instance's ID is in the chartsToKeep array
  if (!chartsToKeep.includes(instance.chart.canvas.id)) {
    // Destroy the chart instance if it's not in the chartsToKeep array
    instance.destroy();
  }
});

    var ctx = document.getElementById('dynaChart1').getContext('2d');
    new Chart(ctx, chartConfig2);
    //document.querySelector("#dynaChart1").innerHTML = '<canvas id="dynaChart1"></canvas>';
    
  }
  document.getElementById("entite").click();
</script>

