<?php
// Load the PhpSpreadsheet library
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
function convertToCsv($xlsxDir , $csvDir){
// Create a new PhpSpreadsheet object
$spreadsheet = IOFactory::load($xlsxDir);

// Set the active sheet to the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Get the sheet data as an array
$data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

// Open a new CSV file for writing
$csvFile = fopen($csvDir, 'w');

// Loop through each row of data
foreach ($data as $row) {
    // Write the row to the CSV file
    fputcsv($csvFile, $row);
}

// Close the CSV file
fclose($csvFile);

}


?>