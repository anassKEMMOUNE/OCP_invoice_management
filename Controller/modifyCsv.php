<?php 

// Path to the CSV file
function modifyFirstLineCsv($filePath,$associativeArray){
    // CSV file path
    
    
    // First line data
    $firstRawData = ["uniteOperationelle", "identifiantGED", "service", "nomFournisseur", "blocage" , 
    "nomCDP", "nomEntite" ,"cA", "numCommande", "montantCommande","montantReceptionne","montantDesFactures", 
    "montantMiseADisposition" ,"numeroFacture" , "montantFactureTTCDevise", "acheteur", "typeDAchatPO", 
    "intervenant","nombreDeJoursAEcheance"];
    $firstLineData = array_map(function($key) use ($associativeArray) {
        return $associativeArray[$key];
    }, $firstRawData);

    
    // Read the existing CSV file
    $file = fopen($filePath, 'r');
    $existingData = [];
    if ($file) {
        while (($row = fgetcsv($file)) !== false) {
            $existingData[] = $row;
        }
        fclose($file);
    }
    
    // Create a temporary file
    $tmpFilePath = '../Exports/tmp_file.csv';
    $tmpFile = fopen($tmpFilePath, 'w');
    
    // Write the first line data to the temporary file
    fputcsv($tmpFile, $firstLineData);
    
    // Write the existing data to the temporary file
    foreach ($existingData as $row) {
        fputcsv($tmpFile, $row);
    }
    
    // Close the temporary file
    fclose($tmpFile);
    
    // Replace the original file with the temporary file
    rename($tmpFilePath, $filePath);
    
    // Function to delete the temporary file
    function deleteTempFile($filePath) {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    
    // Call the function to delete the temporary file
    deleteTempFile($tmpFilePath);
    
    
}


?>