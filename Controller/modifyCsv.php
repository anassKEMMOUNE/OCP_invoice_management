<?php 

function modifyFirstLineCsv(string $filePath, $associativeArray) {
    $firstRawData = ["rank_","uniteOperationelle", "identifiantGED","siteCEC", "service", "nomFournisseur", "blocage" , 
    "nomCDP", "nomEntite" ,"cA", "numCommande", "montantCommande","montantReceptionne","montantDesFactures", 
    "montantMiseADisposition" ,"numeroFacture" , "montantFactureTTCDevise", "deviseFacture","typeF","acheteur", "typeDAchatPO", 
    "intervenant","nombreDeJoursAEcheance","echeance"];
    $newRow = array_map(function($key) use ($associativeArray) {
        return $associativeArray[$key];
    }, $firstRawData);
var_dump($newRow);
    // Read the existing contents of the file
$fileContents = file_get_contents($filePath);

// Create the new row string
$newRowString = '"' . implode('","', $newRow) . '"' . PHP_EOL;

// Insert the new row at the beginning of the file
$fileContents = $newRowString . $fileContents;

// Write the updated contents back to the file
file_put_contents($filePath, $fileContents);
var_dump($filePath);
echo "New row added successfully.";

}


?>