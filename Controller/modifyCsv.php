<?php 


        // Path to the CSV file
        function modifyFirstLineCsv($csvPath,$associativeArray){
            $firstRawData = ["uniteOperationelle", "identifiantGED", "service", "nomFournisseur", "blocage" , 
            "nomCDP", "nomEntite" ,"cA", "numCommande", "montantCommande","montantReceptionne","montantDesFactures", 
            "montantMiseADisposition" ,"numeroFacture" , "montantFactureTTCDevise", "acheteur", "typeDAchatPO", 
            "intervenant","nombreDeJoursAEcheance","echeance"];
            $firstLineData = array_map(function($key) use ($associativeArray) {
                return $associativeArray[$key];
            }, $firstRawData);
        $fileContent = file($csvPath);
        $arr = [];
        array_push($arr,implode(",",$firstLineData).PHP_EOL);
        array_push($arr,$fileContent);
        file_put_contents($csvPath, implode("\n",$arr));
        }
        


?>