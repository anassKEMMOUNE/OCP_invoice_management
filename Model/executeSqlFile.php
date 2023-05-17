<?php
function executeSqlFile($sqlFile , $withDir = false){
    require __DIR__.'/dbConfig.php';
    // Read the SQL file
    
    $sqlCommands = file_get_contents($sqlFile);
    $StorePath = str_replace("Model","Exports/csvOut.csv",__DIR__);
    $StorePath = str_replace('\\',"/",$StorePath);

    if ($withDir == true){

       $sqlCommands = str_replace("directoryToChange",$StorePath,$sqlCommands);
       echo $sqlCommands;
    }
    // Execute the SQL commands
    if ($conn->multi_query($sqlCommands)) {
        do {
            // Check if there are more results
            if ($result = $conn->store_result()) {
                // Free the result set
                $resultStore = $result;
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());
    } else {
        echo "Error executing SQL commands: " . $conn->error;
    }
    return 
    // Close the MySQL connection
    $conn->close();
}

?>
