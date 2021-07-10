<?php


$start_date = new DateTime;

$start_date = strtotime( 'Jan 1st, 2019' );
$end_date = time();

echo 'start date: ', date('Y-M-d', $start_date), "\r\n";
echo 'end date:   ', date('Y-M-d', $end_date), "\r\n";

echo 'start week: ', date('W', $start_date), "\r\n";
echo 'end week:   ', date('W', $end_date), "\r\n";

echo 'start year: ', date('Y', $start_date), "\r\n";
echo 'end year:   ', date('Y', $end_date), "\r\n";

echo 'num years:  ', date('Y', $end_date) - date('Y', $start_date), "\r\n";

$day = new DateTime;

for ( $day = strtotime('Monday', $start_date); $day < $end_date; $day = strtotime('+7 day', $day)){
  echo 'Monday: ', date('Y-M-d', $day), "\r\n";

}


?>
