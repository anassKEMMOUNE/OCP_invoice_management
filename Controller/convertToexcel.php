<?php
// require_once 'vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// function convertToExcel($csvDir, $xlsxDir)
// {
//     // Open the CSV file for reading
//     $csvFile = fopen($csvDir, 'r');

//     // Create a new PhpSpreadsheet object
//     $spreadsheet = new Spreadsheet();
//     $sheet = $spreadsheet->getActiveSheet();

//     // Read each row from the CSV file and write to the Excel sheet
//     while (($row = fgetcsv($csvFile)) !== false) {
//         $sheet->fromArray($row, null, 'A' . $sheet->getHighestRow());
//     }

//     // Close the CSV file
//     fclose($csvFile);

//     // Create a writer object for the Excel file
//     $writer = new Xlsx($spreadsheet);

//     // Save the Excel file
//     $writer->save($xlsxDir);
// }
?>