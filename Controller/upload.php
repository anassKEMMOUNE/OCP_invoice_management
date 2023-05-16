<?php
require_once "../Model/executeSqlFile.php";
require_once "../Model/TableInsert1.php";
require_once "../Model/TableInsert2.php";
function uploadExcel($inputName){
  $target_dir = "../uploads/";
  $target_file = $target_dir . basename($_FILES[$inputName]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $rand_value = strval(random_int(0,100000));
  
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES[$inputName]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }
  
  // Check if file already exists
  if (file_exists($target_file)) {
    $newExt =  "_".$rand_value.".xlsx";
    $newName = str_replace(".xlsx",$newExt,$target_file) ;
    rename($target_file,$newName);
    $target_file = $newName;
  }
  
  // Check file size
  if ($_FILES[$inputName]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "xlsx") {
    echo "Sorry, only xlsx files are allowed.";
    $uploadOk = 0;
  }
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES[$inputName]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
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
  'siteFournisseur' => 'Site fournisseur'
);

$first = uploadExcel("fileToUpload");
$second = uploadExcel("fileToUpload2");

insertTable1($first,$dbsAttr);
insertTable2($second,$dbsAttr);

executeSqlFile("../Model/finalExcel.sql",true);

?>
