<?php

class OneToAllFunction{

	function calculateOneToAll($ticker, $date, $lengthOfPeriod, $lag, $timeFrame, $sort, $calculation_type){
		
	require('../db/Select.php');
	require('crossCorrelation.php');
	$select = new Select();
	$crossCorrelation = new crossCorrelation();
	
	//Get all ticker symbols to compare
	$allTickerSymbols = array_column($select->getAllTickerInfo(), 'ticker');
	
	//Get course and date for origin ticker 
	$tickerData = $select->selectByTicker($ticker, $date, $lengthOfPeriod, $sort);
	$tickerCourse = array_column($tickerData, 'change');
	$tickerDate = array_column($tickerData, 'date');
	
	$resultArr = array();
	//get all mean values for correlations for every lag. compare given ticker with all other tickers
	foreach($allTickerSymbols as $currentTicker){
		$currentTickerData = $select->selectByTicker($currentTicker, $date, $lengthOfPeriod, $sort);
		$currentTickerCourse = array_column($currentTickerData, 'change');
		$currentTickerDate = array_column($currentTickerData, 'date');
		if($currentTickerDate === $tickerDate){
			if($calculation_type == 0){
				$result = $crossCorrelation->initCorrelationTwoTickers($tickerCourse, $currentTickerCourse, $timeFrame, $lag, count($currentTickerData));
			} else {
				$result = $crossCorrelation->initCorrelationTwoTickers( $currentTickerCourse, $tickerCourse, $timeFrame, $lag, count($currentTickerData));
			}
				for($i = 1; $i <= $lag; $i++){
					//echo $currentTicker;
					//print_r($result);
				$average = array_sum(array_column($result, $i))/count($result);
				$arr = array("average" => $average,"ticker" => $currentTicker,  "lag" => $i);
				array_push($resultArr, $arr);
			}
	}
	}
	sort($resultArr);
	return $resultArr;
	}
}
?>