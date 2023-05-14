<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$rand_value = strval(random_int(111,10000));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  $newExt =  "_".$rand_value.".xlsx";
  $newName = str_replace(".xlsx",$newExt,$target_file) ;
  rename($target_file,$newName);
  $target_file = $newName;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "xlsx") {
  echo "Sorry, only xlsx files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    /* Importing data from the excel file

    require "excelReader/excel_reader2.php";
    require "excelReader/SpreadsheetReader.php";
    echo "****";
    echo $target_file;
    echo "****";
    $reader = new SpreadsheetReader($target_file);
    foreach($reader as $key => $row){
      var_dump($row);
    }
    */
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

// Converting from Excel to CSV
require_once '../Model/dbConfig.php';
require_once 'convertToCsv.php';
require_once 'modifyCsv.php';
require_once '../Model/insertTableCsv.php';
require_once '../Model/createBaseFromSql.php';
$xlsx = $target_file;
$csv = str_replace("xlsx","csv",$xlsx);
$csv = str_replace("uploads","Csv",$csv);
convertToCsv($xlsx,$csv);
modifyFirstLineCsv($csv);
createBaseTable('../Model/baseTable.sql');
insertTableFromCSV($csv,"BaseTable");
?>