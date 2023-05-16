<?php 

// Path to the CSV file
function modifyFirstLineCsv($csvPath,$final_map){
$fileContent = file($csvPath);
$fileContent[0]= str_replace('"','',$fileContent[0]);
$fileContent[0] = str_replace("\n","",$fileContent[0]);
$firstLineArray = explode(",",$fileContent[0]);
foreach ($firstLineArray as $key => $ele){
$firstLineArray[$key] =  $final_map[$ele];
}
$fileContent[0] = implode(",",$firstLineArray).PHP_EOL;
file_put_contents($csvPath, $fileContent);
}






?>