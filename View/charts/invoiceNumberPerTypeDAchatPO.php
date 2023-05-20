<?php 
  require_once '../../Model/dbConfig.php';
?>

<!DOCTYPE html>
<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<body>

<?php
  $sql = "SELECT  SUBSTR(typeDAchatPO, 1, 1) AS typedachatpo, COUNT(*) AS commande_count FROM commande GROUP BY SUBSTR(typeDAchatPO, 1, 1);";
  $result = $conn->query($sql);
  $xValues = array();
  $yValues = array();
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($xValues, $row['typedachatpo']);
      array_push($yValues, $row['commande_count']);
    }
  } 
  else {
    echo "No records has been found";
  }

  $conn->close();
?>

<canvas id="myChart" style="width:100%;max-width:600px"></canvas>

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

  new Chart("myChart", {
    type: "doughnut",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: poolColors(yValues.length),
        data: yValues
      }]
    },
    options: {
      title: {
        display: true,
        text: "Nombre de commande par type d'achat PO"
      }
    }
  });
</script>

</body>
</html>
