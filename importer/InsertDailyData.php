<?php

/**
* Importer for updating historical stock data 
* Inserts historical stock data for all tickers in the database for the previous day.
*/
require_once 'Connect.php';
require_once 'SelectTickerSymbols.php';

//Connect to Database
$conn = new Connect();
$con = $conn->con();
	
//Get Ticker Symbols and save as array
$ticker = new SelectTickerSymbols();
$tickerArray = $ticker->getTickerSymbols();

$yesterday = date('d-m-Y', strtotime("-1day"));

foreach($tickerArray as $ticker){
	getStockDataByTicker($ticker, $yesterday, $con, FALSE);
}

function getStockDataByTicker($ticker, $startDate, $con, $isForDaily){
	//Save dateparts in array 
	$startDateParts = explode("-", $startDate);
	$day = 0;
	$month = 1;
	$year = 2;

	echo $ticker."<br>";
	//Url to yahoo finance api
	$url = "http://ichart.finance.yahoo.com/table.csv?s=".$ticker."&a=".($startDateParts[$month] - 1)."&b=".$startDateParts[$day]."&c=".$startDateParts[$year]."&d=".($startDateParts[$month] - 1)."&e=".$startDateParts[$day]."&f=".$startDateParts[$year]."&g=d&ignore=.csv";
	
	//Check if status code for url is ok 
	if(testUrl($url) == 200){
		
		//Open csv file from url and save in array with reverse order
		$file = fopen($url, "r");
		$csvAsArray = reverseCsv($file);
		
		//Get last course change to calculate change
		$oldclose = 00.000000;
		$select = "SELECT TOP 1 CloseCourse FROM dbo.table_historical WHERE Ticker = '$ticker' ORDER BY DATE DESC";
		$get = sqlsrv_query($con, $select);
		$row = sqlsrv_fetch_array($get, SQLSRV_FETCH_ASSOC);
		$oldclose = $row['CloseCourse'];
		echo $oldclose;	

		foreach($csvAsArray as $value){	
			if($value == FALSE){
				echo("error in currentRow; ticker: ".$ticker." <br/>");
			}else if(sizeof($value) == 7){
				$date = $value[0];
				$open = $value[1];
				$high = $value[2];
				$low = $value[3];
				$close = $value[4];
				$volume = $value[5];
				$change = $close - $oldclose;
				$change = $change/$close;
				$change = $change * 100;

				//Insert query with values from csv
				$insert = "INSERT INTO dbo.table_historical(Ticker, Date, OpenCourse, High, Low, CloseCourse, Volume, Change) VALUES('".$ticker."', '".$date."', '".$open."', '".$high."', '".$low."', '".$close."', '".$volume."', '".$change."')";
				$query = sqlsrv_query($con, $insert);
				if($query == FALSE)
					var_dump(sqlsrv_errors());
				sqlsrv_free_stmt($query);
				$oldclose = $close;
			}else{
				echo("wrong size <br/>");
				echo("size is: ".sizeof($dataCurrentRow)."<br/>");
			}
		}
		fclose($file);		
	} else{
		echo("could not load file from url <br/>");
	}


}	

function reverseCsv($file)
{
	$rows = array();
	fgetcsv($file);
	while(($data = fgetcsv($file)) != FALSE) {
		array_push($rows, $data);
	}
	return array_reverse($rows);
}

function testUrl($url)
{
	$header = get_headers($url);
	return substr($header[0], 9, 3);	
}
?>