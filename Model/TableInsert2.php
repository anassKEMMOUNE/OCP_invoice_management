<?php
function insertTable2($pathTofile,$dbsAttr,$user){
    require __DIR__.'/dbConfigUser.php';
    require_once "excelReader/excel_reader2.php";
    require_once "excelReader/SpreadsheetReader.php";
    require_once "../Model/executeSqlFile.php";
    $conn = connectToUserDatabase($user);
    // Second sheet upload
    $base2reader = new SpreadsheetReader($pathTofile);
    $count = 0;
    $attr;

    foreach($base2reader as $key => $row){
        if($count == 0){
            $attr = $row;
            $count++;
            $error;
        }
        else{
            // Updating table facture
            $identifiantGED = $row[array_search($dbsAttr['identifiantGED'], $attr)];
            $blocage = $row[array_search($dbsAttr['blocage'], $attr)];
            $cA = $row[array_search($dbsAttr['cA'], $attr)];
            $entiteG = $row[array_search($dbsAttr['entiteG'], $attr)];
            $sql = "UPDATE `facture` SET `blocage` = '$blocage', `cA` = '$cA', `entiteG` = '$entiteG' WHERE `facture`.`identifiantGED` = '$identifiantGED'";
            if ($conn->query($sql) === TRUE) {
                $error = "blocage and ca update executed succesfully ";
            } else {
                $error = "Update error: " . $conn->error;
            }

            // Updating table entite
            $nomEntite = $row[array_search($dbsAttr['nomEntite'], $attr)];
            $entiteSite = $row[array_search($dbsAttr['entiteSite'], $attr)];
            $nomEntiteCountQuery = "SELECT COUNT(*) nomEntite FROM entite E WHERE E.nomEntite = '$nomEntite';"; 
            if ($nomEntiteCount = $conn->query($nomEntiteCountQuery)) {
                while ($rowNomEntiteCount = $nomEntiteCount -> fetch_row()) {
                    $nomEntiteCountValue = $rowNomEntiteCount[0];
                    if($nomEntiteCountValue == 0){
                        $sql = "UPDATE `entite` SET `nomEntite` = '$nomEntite', `entiteSite` = '$entiteSite' WHERE `idE` = (SELECT `idE` FROM `facture` WHERE `identifiantGED` = '$identifiantGED');";
                        if ($conn->query($sql) === TRUE) {
                            $error = "nomEntite update executed succesfully ";
                        } else {
                            $error = "Update error: " . $conn->error;
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
                            $error = "idE update executed succesfully ";
                        } else {
                            $error = "Update error: " . $conn->error;
                        }

                        $updatingChefDeProjetQuery = "UPDATE `chefdeprojet` SET `idE` = '$existentIdEValue' WHERE `idE` = '$toBeReplacedIdEValue';";
                        if ($conn->query($updatingChefDeProjetQuery) === TRUE) {
                            $error = "idE update executed succesfully ";
                        } else {
                            $error = "Update error: " . $conn->error;
                        }

                        $deletingExistentIdEQuery = "DELETE FROM `entite` WHERE `idE` = '$toBeReplacedIdEValue';";
                        if ($conn->query($deletingExistentIdEQuery) === TRUE) {
                            $error = "redendunt idE deletion executed succesfully ";
                        } else {
                            $error = "Update error: " . $conn->error;
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
                            $error = "nomCDP update executed succesfully ";
                        } else {
                            $error = "Update error: " . $conn->error;
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
                            $error = "idCDP update executed succesfully ";
                        } else {
                            $error = "Update error: " . $conn->error;
                        }

                        $deletingExistentCDPQuery = "DELETE FROM `chefdeprojet` WHERE `idCDP` = '$toBeReplacedCDPValue';";
                        if ($conn->query($deletingExistentCDPQuery) === TRUE) {
                            $error = "redendunt idCDP deletion executed succesfully ";
                        } else {
                            $error = "Update error: " . $conn->error;
                        }
                    }
                }
            }
        }
    }
    $conn->close();
}

?>