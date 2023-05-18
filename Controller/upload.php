<?php
require_once "../Model/executeSqlFile.php";
require_once "../Model/TableInsert1.php";
require_once "../Model/TableInsert2.php";
require_once "modifyCsv.php";
function uploadExcel($inputName){
  $target_dir = "../uploads/";
  $target_file = $target_dir . basename($_FILES[$inputName]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $rand_value = strval(random_int(0,100000));
  $error = "";
  
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES[$inputName]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      $error = "File is not an image.";
      $uploadOk = 0;
    }
  }
  
  // Check if file already exists
  if (file_exists($target_file)) {
    $newExt =  "_".$rand_value.".xlsx";
    $newName = str_replace(".xlsx", $newExt, $target_file) ;
    $target_file = $newName;
  }
  
  // Check file size
  if ($_FILES[$inputName]["size"] > 500000) {
    $error =  "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "xlsx") {
    $error =  "Sorry, only xlsx files are allowed.";
    $uploadOk = 0;
  }
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $error =  "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $target_file)) {
      $error =  "The file ". htmlspecialchars( basename( $_FILES[$inputName]["name"])). " has been uploaded.";
    } else {
      $error =  "Sorry, there was an error uploading your file.";
    }
  }

  return $target_file;
}

$dbsAttr = array(
  'nomCDP' => 'Chef de projet',
  'numCommande' => 'Num commande',
  'service' => 'Service',
  'typeDAchatPO' => "Type d'achat PO",
  'uniteOperationelle' => 'Nom Unité Opérationnelle',
  'montantCommande' => 'Montant de la commande/Appel de cde',
  'montantReceptionne' => 'Montant des réceptions',
  'acheteur' => 'Acheteur',
  'nomEntite' => 'Entité',
  'identifiantGED' => 'Identifiant GED',
  'numeroFacture' => 'Numéro Facture',
  'montantDesFactures' => 'Montant des factures',
  'montantFactureTTCDevise' => 'Montant Facture TTC (DEVISE)',
  'montantMiseADisposition' => 'Montant mise à disposition',
  'intervenant' => 'Intervenant',
  'nombreDeJoursAEcheance' => "Nombre de jours à l'échéance",
  'cA' => 'CA',
  'blocage' => 'Blocage',
  'codeFournisseur' => 'Code fournisseur',
  'nomFournisseur' => 'Fournisseur',
  'siteFournisseur' => 'Site fournisseur',
  'entiteSite' => 'Entité Site',
  'siteCEC' => 'Site CEC',
  'deviseFacture' => 'Devise Facture',
  'typeF' => 'Type',
  'entiteG' => 'Entité G',
  'rank_' => 'RANK',
  'echeance' => 'Échéance'
);

$first = uploadExcel("fileToUpload");
$second = uploadExcel("fileToUpload2");
$csvOutput = executeSqlFile("../Model/ClearDB.sql");

modifyFirstLineCsv($csvOutput,$dbsAttr);
insertTable1($first, $dbsAttr);
insertTable2($second, $dbsAttr);

executeSqlFile("../Model/finalExcel.sql",true);
//header("Location: ../index.php");

?>
