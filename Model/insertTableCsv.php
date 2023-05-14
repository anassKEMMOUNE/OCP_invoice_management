<?php

function insertTableFromCSV($csvFile,$tableName){
require __DIR__.'/dbConfig.php';

// CSV file details
$delimiter = ",";

// Read the CSV file
$file = fopen($csvFile, "r");
if (!$file) {
    die("Error opening the CSV file.");
}

// Get the column names from the first line of the CSV
$columns = fgetcsv($file, 0, $delimiter);

// Prepare the SQL statement
$placeholders = implode(", ", array_fill(0, count($columns), "?"));
$sql = "INSERT INTO $tableName (" . implode(", ", $columns) . ") VALUES ($placeholders)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Read and insert the data into the database
while (($data = fgetcsv($file, 0, $delimiter)) !== false) {
    $values = array_map("trim", $data); // Trim leading/trailing spaces

    // Bind parameters dynamically based on the number of columns
    $bindTypes = str_repeat("s", count($columns)); // Assuming all columns are strings
    $stmt->bind_param($bindTypes, ...$values);

    // Execute the statement
    $stmt->execute();
}

// Close the file
fclose($file);

// Close the statement
$stmt->close();

// Close the connection
$conn->close();


}

?>
<?php

?>

