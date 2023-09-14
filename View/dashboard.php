<?php 
session_start();
if (!isset($_SESSION['user_id'])){
header("Location: login.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
include 'head.html';

?>
<body class = 'main'>

    <?php
        include "sidebar.html";

    ?>
    <div class="main_blocki">
    <div class="blocc">
    <div class="dashboard_block1">
        <?php
        include 'charts/invoiceNumberPerTypeDAchatPO.php';
        ?>
    </div>
    <div class="dashboard_block2">
     <?php
    include 'charts/invoicesNumberPerEcheance.php';
    ?> 
    </div>
    <div class="dashboard_block3">
    <?php
    include 'charts/factureEchue.php';
    ?>
    </div>

    </div>
    <div class="dashboard_graphs">
        <div class="dynamicGraph">
            <?php
        include 'charts/invoice3VariablesChartBar.php';
          ?>
        </div> 
        <div class="entiteGraph">
            <?php
        include 'charts/invoicesNumberPerEntite.php';
        ?>
        </div>

    </div>

    </div>




</body>
</html>