<?php

class Select{
function selectByTicker($ticker, $date, $enddate, $sort){
require_once 'Connect.php';
$con = new Connect();

$conn = $con->con();

if($sort == 0){
	$sql = "SELECT * FROM dbo.table_historical WHERE TICKER = '$ticker' AND DATE <= '$date' AND DATE >= '$enddate' ORDER BY DATE DESC";
} else {
	$sql = "SELECT * FROM dbo.table_historical WHERE TICKER = '$ticker' AND DATE <= '$date' AND DATE >= '$enddate' ORDER BY DATE ASC";
}

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$result = array();

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	  
	$change = $row['Change'];
	$ticker = $row['Ticker'];
	$date = $row['Date'];
	$date1 = $date->format('Y-m-d');
	$closeCourse = $row['CloseCourse'];
	  
	$arr = array("ticker" => $ticker, "date" => $date1, "closeCourse" => $closeCourse, "change" => $change);

	array_push($result, $arr);
}

sqlsrv_free_stmt( $stmt);
if($sort == 0){
	return array_reverse($result);
} else {
	return $result;
}

}

function selectByTicker2($ticker, $date, $count, $sort){
require_once 'Connect.php';
$con = new Connect();

$conn = $con->con();

if($sort == 0){
	$sql = "SELECT TOP $count * FROM dbo.table_historical WHERE TICKER = '$ticker' AND DATE <= '$date' ORDER BY DATE DESC";
} else {
	$sql = "SELECT TOP $count * FROM dbo.table_historical WHERE TICKER = '$ticker' AND DATE >= '$date' ORDER BY DATE ASC";
}

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$result = array();

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	  
	$change = $row['Change'];
	$ticker = $row['Ticker'];
	$date = $row['Date'];
	$date1 = $date->format('Y-m-d');
	$closeCourse = $row['CloseCourse'];
	  
	$arr = array("ticker" => $ticker, "date" => $date1, "closeCourse" => $closeCourse, "change" => $change);

	array_push($result, $arr);
}

sqlsrv_free_stmt( $stmt);
if($sort == 0){
	return array_reverse($result);
} else {
	return $result;
}

}

function getTickerInfo($ticker){
require_once 'Connect.php';
$con = new Connect();

$conn = $con->con();

$sql = "SELECT * FROM dbo.table_tickerInfo WHERE TICKER = '$ticker'";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$result = array();

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	  
	  //$change = $row['CloseCourse'];

	//array_push($result, $change);
	return $row;
}

sqlsrv_free_stmt( $stmt);
//sqlsrv_close($conn);
return $result;
}

function getAllTickerInfo(){
require_once 'Connect.php';
$con = new Connect();

$conn = $con->con();

$sql = "SELECT Ticker, Company, Exchange FROM dbo.table_tickerInfo";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$result = array();

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
	  
	  //$change = $row['CloseCourse'];
	  $ticker = $row['0'];
	  $company = $row['1'];
	  $exchange = $row['2'];
	  
	  $arr = array("ticker" => $ticker, "exchange" => $exchange, "company" => $company);

	array_push($result, $arr);
	//return $row;
}

//sqlsrv_free_stmt( $stmt);
sqlsrv_close($conn);
return $result;
}

function getHighestCourses($count, $order){		//Order: 0 if sorting desc, 1 if sorting asc
require_once 'Connect.php';
$con = new Connect();

$conn = $con->con();

if($order == 0){
	$sql = "SELECT TOP $count Ticker, Change FROM dbo.table_historical WHERE DATE = (SELECT MAX(Date) Date FROM dbo.table_historical) ORDER BY Change DESC";
} else {
	$sql = "SELECT TOP $count Ticker, Change FROM dbo.table_historical WHERE DATE = (SELECT MAX(Date) Date FROM dbo.table_historical) ORDER BY Change ASC";
}


$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
	echo "False SQL Statement:";
    die( print_r( sqlsrv_errors(), true) );
}

$result = array();

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

	array_push($result, $row);
}

sqlsrv_free_stmt( $stmt);
//sqlsrv_close($conn);
return $result;
}

function getSearchTicker($search){
require_once 'Connect.php';
$con = new Connect();

$conn = $con->con();

$sql = "SELECT Ticker, Company, Exchange FROM dbo.table_tickerInfo WHERE TICKER LIKE '%$search%' OR COMPANY LIKE '%$search%' OR EXCHANGE LIKE '%$search%'";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$result = array();

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
	  
	  //$change = $row['CloseCourse'];

	array_push($result, $row);
	//return $row;
}

//sqlsrv_free_stmt( $stmt);
sqlsrv_close($conn);
return $result;
}

function getCurrentChangeByTickerAndDate($ticker, $date){
	require_once 'Connect.php';
	$con = new Connect();

	$conn = $con->con();

	$sql = "SELECT Change FROM dbo.table_current WHERE TICKER = '$ticker' AND (DATEPART(hh, Date) = $date) AND Change != 100 ORDER BY DATE ASC";
	$stmt = sqlsrv_query( $conn, $sql );
	if( $stmt === false) {
		die( print_r( sqlsrv_errors(), true) );
	}

	$result = array();

	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	  
		$change = $row['Change'];
	
		array_push($result, $change);
	}

sqlsrv_free_stmt( $stmt);
//sqlsrv_close($conn);
return $result;
}

function getExchanges(){
	require_once 'Connect.php';
	$con = new Connect();

	$conn = $con->con();

	$sql = "SELECT * FROM dbo.table_exchange";
	$stmt = sqlsrv_query( $conn, $sql );
	if( $stmt === false) {
		die( print_r( sqlsrv_errors(), true) );
	}

	$result = array();

	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	  
		$exchange = $row['Exchange'];

		array_push($result, $exchange);
	}

	sqlsrv_free_stmt( $stmt);
	//sqlsrv_close($conn);
	return $result;
}

function getCurrentValues(){
	require_once 'Connect.php';
	$con = new Connect();

	$conn = $con->con();

	$sql = "SELECT TOP 1000 Change, Ticker FROM dbo.table_current WHERE DATE = (SELECT MAX(Date) Date FROM dbo.table_current) AND Change != 0 ORDER BY NEWID()";
	$stmt = sqlsrv_query( $conn, $sql );
	if( $stmt === false) {
		die( print_r( sqlsrv_errors(), true) );
	}

	$result = array();

	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	  
		$change = $row['Change'];
		$ticker = $row['Ticker'];
		$arr = array("change" => $change, "ticker" => $ticker);
	
		array_push($result, $arr);
	}

sqlsrv_free_stmt( $stmt);
//sqlsrv_close($conn);
return $result;
}

function getNNewestCoursesWithDates($ticker, $n)
{
	require_once 'Connect.php';
	$con = new Connect();

	$conn = $con->con();

	$sql = "SELECT TOP $n Change, Date FROM dbo.table_historical WHERE Ticker = '$ticker' ORDER BY Date DESC;";
	$stmt = sqlsrv_query( $conn, $sql );
	if( $stmt === false) {
		die( print_r( sqlsrv_errors(), true) );
	}

	$result = array();

	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
		  
		$tempArr = array(
			"change" => $row['Change'],
			"date" => $row['Date']
		);

		array_push($result, $tempArr);
	}

	sqlsrv_free_stmt( $stmt);
	//sqlsrv_close($conn);
	return $result;
}
}
?>