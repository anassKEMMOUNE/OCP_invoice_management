<?php


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
// First sheet upload
$reader = new SpreadsheetReader("../uploads/DATABASE SHEET (EXAMPLE) 1.xlsx"); // $target_file
// var_dump($reader);
$count = 0;
$attr;
foreach($reader as $key => $row){
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

// Second sheet upload
$base2reader = new SpreadsheetReader("../uploads/base2.xlsx"); // $target_file
// var_dump($reader);
$count = 0;
$attr;
foreach($base2reader as $key => $row){
    // var_dump($row);
    if($count == 0){
        $attr = $row;
        $count++;
    }
    else{
        // Updating table facture
        $identifiantGED = $row[array_search($dbsAttr['identifiantGED'], $attr)];
        $blocage = $row[array_search($dbsAttr['blocage'], $attr)];
        $cA = $row[array_search($dbsAttr['cA'], $attr)];
        $sql = "UPDATE `facture` SET `blocage` = '$blocage', `cA` = '$cA' WHERE `facture`.`identifiantGED` = '$identifiantGED'";
        if ($conn->query($sql) === TRUE) {
        echo "blocage and ca update executed succesfully ";
        } else {
        echo "Update error: " . $conn->error;
        }

        // Updating table entite
        $nomEntite = $row[array_search($dbsAttr['nomEntite'], $attr)];
        $nomEntiteCountQuery = "SELECT COUNT(*) nomEntite FROM entite E WHERE E.nomEntite = '$nomEntite';"; 
        if ($nomEntiteCount = $conn->query($nomEntiteCountQuery)) {
            while ($rowNomEntiteCount = $nomEntiteCount -> fetch_row()) {
                $nomEntiteCountValue = $rowNomEntiteCount[0];
                if($nomEntiteCountValue == 0){
                    $sql = "UPDATE `entite` SET `nomEntite` = '$nomEntite' WHERE `idE` = (SELECT `idE` FROM `facture` WHERE `identifiantGED` = '$identifiantGED');";
                    if ($conn->query($sql) === TRUE) {
                    echo "nomEntite update executed succesfully ";
                    } else {
                    echo "Update error: " . $conn->error;
                    }
                }
                else {
                    $existentIdEQuery = "SELECT idE FROM entite E WHERE E.nomEntite = '$nomEntite';";
                    if ($existentIdE = $conn->query($existentIdEQuery)) {
                        while ($rowExistentIdE = $existentIdE -> fetch_row()) {
                            $existentIdEValue = $rowExistentIdE[0];
                        }
                    }

                    $toBeReplaceIdEQuery = "SELECT `idE` FROM `facture` WHERE `identifiantGED` = '$identifiantGED';";
                    if ($toBeReplacedIdE = $conn->query($toBeReplaceIdEQuery)) {
                        while ($rowToBeReplacedIdE = $toBeReplacedIdE -> fetch_row()) {
                            $toBeReplacedIdEValue = $rowToBeReplacedIdE[0];
                        }
                    }

                    $updatingFactureQuery = "UPDATE `facture` SET `idE` = '$existentIdEValue' WHERE `idE` = '$toBeReplacedIdEValue';";
                    if ($conn->query($updatingFactureQuery) === TRUE) {
                        echo "idE update executed succesfully ";
                    } else {
                        echo "Update error: " . $conn->error;
                    }

                    $updatingChefDeProjetQuery = "UPDATE `chefdeprojet` SET `idE` = '$existentIdEValue' WHERE `idE` = '$toBeReplacedIdEValue';";
                    if ($conn->query($updatingChefDeProjetQuery) === TRUE) {
                        echo "idE update executed succesfully ";
                    } else {
                        echo "Update error: " . $conn->error;
                    }

                    $deletingExistentIdEQuery = "DELETE FROM `entite` WHERE `idE` = '$toBeReplacedIdEValue';";
                    if ($conn->query($deletingExistentIdEQuery) === TRUE) {
                        echo "redendunt idE deletion executed succesfully ";
                    } else {
                        echo "Update error: " . $conn->error;
                    }
                }
            }
        }

        // Updating table chefdeprojet
        $nomCDP = $row[array_search($dbsAttr['nomCDP'], $attr)];
        $nomCDPCountQuery = "SELECT COUNT(*) idCDP FROM chefdeprojet CDP WHERE (CDP.nomCDP = '$nomCDP' AND CDP.idE = (SELECT idE FROM entite WHERE nomEntite = '$nomEntite'));"; 
        if ($nomCDPCount = $conn->query($nomCDPCountQuery)) {
            while ($rowNomCDPCount = $nomCDPCount -> fetch_row()) {
                $nomCDPCountValue = $rowNomCDPCount[0];
                if($nomCDPCountValue == 0){
                    $sql = "UPDATE `chefdeprojet` SET `nomCDP` = '$nomCDP' WHERE `idCDP` = (SELECT `idCDP` FROM `commande` WHERE `numCommande` = (SELECT `numCommande` FROM `facture` WHERE `identifiantGED` = '$identifiantGED'));";
                    if ($conn->query($sql) === TRUE) {
                    echo "nomCDP update executed succesfully ";
                    } else {
                    echo "Update error: " . $conn->error;
                    }
                }
                else{
                    $existentCDPQuery = "SELECT idCDP FROM chefdeprojet CDP WHERE (CDP.nomCDP = '$nomCDP' AND CDP.idE = (SELECT idE FROM entite WHERE nomEntite = '$nomEntite'));";
                    if ($existentCDP = $conn->query($existentCDPQuery)) {
                        while ($rowExistentCDP = $existentCDP -> fetch_row()) {
                            $existentCDPValue = $rowExistentCDP[0];
                        }
                    }

                    $toBeReplacedCDPQuery = "SELECT `idCDP` FROM `commande` WHERE `numCommande` = (SELECT `numCommande` FROM `facture` WHERE `identifiantGED` = '$identifiantGED');";
                    if ($toBeReplacedCDP = $conn->query($toBeReplacedCDPQuery)) {
                        while ($rowToBeReplacedCDP = $toBeReplacedCDP -> fetch_row()) {
                            $toBeReplacedCDPValue = $rowToBeReplacedCDP[0];
                        }
                    }

                    $updatingCommandeQuery = "UPDATE `commande` SET `idCDP` = '$existentCDPValue' WHERE `idCDP` = '$toBeReplacedCDPValue';";
                    if ($conn->query($updatingCommandeQuery) === TRUE) {
                        echo "idCDP update executed succesfully ";
                    } else {
                        echo "Update error: " . $conn->error;
                    }

                    $deletingExistentCDPQuery = "DELETE FROM `chefdeprojet` WHERE `idCDP` = '$toBeReplacedCDPValue';";
                    if ($conn->query($deletingExistentCDPQuery) === TRUE) {
                        echo "redendunt idCDP deletion executed succesfully ";
                    } else {
                        echo "Update error: " . $conn->error;
                    }
                }
            }
        }
    }
}
executeSqlFile("../Model/finalExcel.sql",true);
$conn->close();
?>