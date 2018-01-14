<?php

$lineCount = 0;
$year = "2018";
$month = 1;
$handle = fopen('C:\Users\Monschu\Desktop\Outlook\export.csv', "r");
if (is_resource($handle)) {
  while (($line = fgets($handle)) !== false) {
    $lineCount++;

    //skip header lines
    if ($lineCount < 4) {
      continue;
    }

    //reset for new month
    if ($lineCount == 8) {
      $lineCount = 0;
      $month++;
    }

    //get array (values) from string with comma
    $data = explode(",", $line);
    //create new array
    $calenderDate = array();
    $day = 0;
    foreach ($data as $index => $duty) {
      if ($duty == "") {
        continue;
      }
      if ($index == 0) {
        $name = $duty;
        continue;
      }

      if ($index % 2 == 1) {
        $day++;
        $timeFrom = "7:30";
        $timeTo = "12:30";
      } else {
        $timeFrom = "12:30";
        $timeTo = "17:30";
      }

      $date = $day."/".$month."/".$year;
      $calenderDate[$date] = array();
      $calenderDate[$date][$duty.$timeFrom] = array();
      $calenderDate[$date][$duty.$timeFrom]["timeFrom"] = $timeFrom;
      $calenderDate[$date][$duty.$timeFrom]["timeTo"] = $timeTo;
      $calenderDate[$date][$duty.$timeFrom]["person"] = $name;
      $calenderDate[$date][$duty.$timeFrom]["duty"] = $duty;
    }

  }

  fclose($handle);
  unlink('C:\Users\Monschu\Desktop\Outlook\import.csv');
  foreach ($calenderDate as $date => $row) {
    foreach ($row as $dutyTime => $fields) {
      $csvLine = $date.','.$fields["timeFrom"].','.$fields["timeTo"].','.$fields["duty"].','.$fields["person"]."\n";
      file_put_contents('C:\Users\Monschu\Desktop\Outlook\import.csv', $csvLine, FILE_APPEND);
    }
  }









  //$exportLine = implode(',',$calenderDate);
  //var_dump($exportLine);
  //file_put_contents('C:\Users\Monschu\Desktop\Outlook\import.csv', $exportLine);

} else {

}

 ?>
