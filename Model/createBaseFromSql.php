<?php
function createBaseTable($sqlFile){
    require __DIR__.'/dbConfig.php';
    // Read the SQL file
    
    $sqlCommands = file_get_contents($sqlFile);
    
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
}

?>
