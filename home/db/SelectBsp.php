<?php
$ticker1 = "AAPL";
$ticker2 = "GOOG";
$count = 10;
$date = "2016-05-25";

require_once 'Select.php';
$con = new Select();
echo "GETCOURSEBYTICKER<br>";
$conn = $con->selectByTicker($ticker1, $date, $count, 0);
print_r($conn); 
echo "<br>";
$conn = $con->selectByTicker($ticker1, $date, $count, 1);
$ticker = array_column($conn, 'closeCourse');
print_r($conn); 
echo "<br>";
print_r($ticker);

echo "<br>";
$conn = $con->getAllTickerInfo();
//print_r($conn); 

echo "<br>";
$conn = $con->getHighestCourses(10, 0);
print_r($conn); 

echo "<br>";
$conn = $con->getExchanges();
print_r($conn); 

?>