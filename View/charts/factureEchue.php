<p class='p1'>Nombre des factures échues</p>
<div>
<p class="numberofechue">
<?php
require_once '../Model/dbConfigUser.php';
$conn = connectToUserDatabase($_COOKIE['username']);
$qu = "SELECT identifiantGED FROM facture WHERE montantDesFactures = montantMiseADisposition";
$result = $conn->query($qu);
$arr = $result-> fetch_all();
echo count($arr);
?>
</p>
<p class="percentageofechue">
<?php
$au = "SELECT identifiantGED FROM facture";
$result2 = $conn->query($au);
$arri = $result2-> fetch_all();
echo strval((count($arr)/count($arri)) * 100)."%";
?>
</p>
</div>
<p class="p1 p2">Poucentage de factures échues</p>
