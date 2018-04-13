<?php

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");

function outputCSV($data, $headings) {
  $output = fopen("php://output", "w");
  fputcsv($output, $headings, ';');
  foreach ($data as $row)
    fputcsv($output, $row, ';', chr(0)); // here you can change delimiter/enclosure

  fclose($output);
}

?>