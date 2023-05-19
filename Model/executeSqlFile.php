<?php
function executeSqlFile($sqlFile , $withDir = false):string{
    require __DIR__.'/dbConfig.php';
    //generating random file name
    $a = rand(111,11111);
    $outPath = "/Exports/csvOut".strval($a).".csv";
    $sqlCommands = file_get_contents($sqlFile);
    // Read the SQL file
    $StorePath = str_replace("Model",$outPath,__DIR__);
    $StorePath = str_replace('\\',"/",$StorePath);
    //echo $StorePath;
    if ($withDir == true){

       $sqlCommands = str_replace("directoryToChange",$StorePath,$sqlCommands);
       
       
    }
    // Execute the SQL commands
    if ($conn->multi_query($sqlCommands)) {
        do {
            // Check if there are more results
            if ($result = $conn->store_result()) {
                // Free the result set
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());
    } else {
        echo "Error executing SQL commands: " . $conn->error;
    }
    
    // Close the MySQL connection
    $conn->close();
    //echo "\n This the : $outpath";
    
    return $StorePath;
}

?>