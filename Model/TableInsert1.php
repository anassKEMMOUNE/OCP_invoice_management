<?php

function insertTable1($pathTofile,$dbsAttr){
require_once __DIR__.'/dbConfig.php';
require_once "excelReader/excel_reader2.php";
require_once "excelReader/SpreadsheetReader.php";
require_once "../Model/executeSqlFile.php";
// First sheet upload
$Base1reader = new SpreadsheetReader($pathTofile); // $target_file
// var_dump($reader);
$count = 0;
$attr;
foreach($Base1reader as $key => $row){
    // var_dump($row);
    if($count == 0){
        $attr = $row;
        $count++;
    }
    else{
        // Insertion into fournisseur table
        $codeFournisseur = $row[array_search($dbsAttr['codeFournisseur'], $attr)];
        $nomFournisseur = $row[array_search($dbsAttr['nomFournisseur'], $attr)];
        $siteFournisseur = $row[array_search($dbsAttr['siteFournisseur'], $attr)];
        $sql = "INSERT INTO `fournisseur` (`codeFournisseur`, `nomFournisseur`, `siteFournisseur`) VALUES ('$codeFournisseur', '$nomFournisseur', '$siteFournisseur');";
        if ($conn->query($sql) === TRUE) {
        echo "Fournisseur insertion executed succesfully ";
        } else {
        echo "Error: " . $conn->error;
        }

        // Insertion into entite table
        $sql = "INSERT INTO `entite` (`nomEntite`) VALUES ('Missing');";
        if ($conn->query($sql) === TRUE) {
        echo "Entite insertion executed succesfully ";
        } else {
        echo "Error: " . $conn->error;
        }

        // Insertion into chefdeprojet table
        $maxIdEQuery = "SELECT MAX(idE) FROM entite;";
        if ($maxIdE = $conn->query($maxIdEQuery)) {
            while ($rowMaxIdE = $maxIdE -> fetch_row()) {
                $maxIdEValue = $rowMaxIdE[0];
                $sql = "INSERT INTO `chefdeprojet` (`idE`, `nomCDP`) VALUES ('$maxIdEValue', 'Missing');";
                if ($conn->query($sql) === TRUE) {
                echo "Chefdeprojet insertion executed succesfully ";
                } else {
                echo "Max selection error: " . $conn->error;
                }
                echo "Max idE determined succesfully ";
            }
        } else {
        echo "Insertion error: " . $conn->error;
        }

        // Insertion into commande table
        $numCommande = $row[array_search($dbsAttr['numCommande'], $attr)];
        $service = $row[array_search($dbsAttr['service'], $attr)];
        $typeDAchatPO = $row[array_search($dbsAttr['typeDAchatPO'], $attr)];
        $uniteOperationelle = $row[array_search($dbsAttr['uniteOperationelle'], $attr)];
        $montantCommande = $row[array_search($dbsAttr['montantCommande'], $attr)];
        $montantReceptionne = $row[array_search($dbsAttr['montantReceptionne'], $attr)];
        $acheteur = $row[array_search($dbsAttr['acheteur'], $attr)];
        $maxCDPQuery = "SELECT MAX(idCDP) FROM chefdeprojet;";
        if ($maxCDP = $conn->query($maxCDPQuery)) {
            while ($rowMaxCDP = $maxCDP -> fetch_row()) {
                $maxCDPEValue = $rowMaxCDP[0];
                $sql = "INSERT INTO `commande` (`numCommande`, `service`, `typeDAchatPO`, `uniteOperationelle`, `montantCommande`, `montantReceptionne`, `acheteur`, `codeFournisseur`, `idCDP`) VALUES ('$numCommande', '$service', '$typeDAchatPO', '$uniteOperationelle', '$montantCommande', '$montantReceptionne', '$acheteur', '$codeFournisseur', '$maxCDPEValue');";
                if ($conn->query($sql) === TRUE) {
                echo "Commande insertion executed succesfully ";
                } else {
                echo "Max selection error: " . $conn->error;
                }
                echo "Max idCDP determined succesfully ";
            }
        } else {
        echo "Error: " . $conn->error;
        }

        // Insertion into facture table
        $identifiantGED = $row[array_search($dbsAttr['identifiantGED'], $attr)];
        $numeroFacture = $row[array_search($dbsAttr['numeroFacture'], $attr)];
        $montantDesFactures = $row[array_search($dbsAttr['montantDesFactures'], $attr)];
        $montantFactureTTCDevise = $row[array_search($dbsAttr['montantFactureTTCDevise'], $attr)];
        $montantMiseADisposition = $row[array_search($dbsAttr['montantMiseADisposition'], $attr)];
        $intervenant = $row[array_search($dbsAttr['intervenant'], $attr)];
        $nombreDeJoursAEcheance = $row[array_search($dbsAttr['nombreDeJoursAEcheance'], $attr)];
        $sql = "INSERT INTO `facture` (`identifiantGED`, `numeroFacture`, `montantDesFactures`, `montantFactureTTCDevise`, `montantMiseADisposition`, `intervenant`, `nombreDeJoursAEcheance`, `cA`, `blocage`, `numCommande`, `idE`) VALUES ('$identifiantGED', '$numeroFacture', '$montantDesFactures', '$montantFactureTTCDevise', '$montantMiseADisposition', '$intervenant', '$nombreDeJoursAEcheance', 'Missing', 'Missing', '$numCommande', '$maxIdEValue');";
        if ($conn->query($sql) === TRUE) {
        echo "Facture insertion executed succesfully ";
        } else {
        echo "Error: " . $conn->error;
        }
    }
}
$conn->close();
}

?>