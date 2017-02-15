<?php

class OneToAllFunction
{
	/** Function for calculating crosscorrelation with one fixed ticker and all other tickers from the database;
	* returns the average correlationcoefficient for all tickers and lags
	*
	* @param $ticker ticker which is used for calculating crosscorrelation
	* @param $startDate start date for values which are used for crosscorrelation
	* @param $endDate end date for values which are used for crosscorrelation
	* @param $lag maximum lag which is used for calculating crosscorrelation
	* @param $timeFrame number of values which are used for one crosscorrelation calulation
	* @param $calculationType set to 1, if calculating crosscorrelation with fixed ticker to all others; set to 0, if calculating crosscorrelation with all other to fixed ticker
	* @return array with average correlationcoefficient for each ticker and lag 
	*/
    function calculateTickerAgainstAll($ticker, $date, $lengthOfPeriod, $lag, $timeFrame, $sort, $calculation_type)
    {

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
		//Get data for all tickers from the database
        foreach ($allTickerSymbols as $currentTicker) {
            $currentTickerData = $select->selectByTicker($currentTicker, $date, $lengthOfPeriod, $sort);
            $currentTickerCourse = array_column($currentTickerData, 'change');
            $currentTickerDate = array_column($currentTickerData, 'date');
            if ($currentTickerDate === $tickerDate) {
				//calculationType == 0 for one against all, calculationType == 1 for all against one
                if ($calculation_type == 0) {
                    $result = $crossCorrelation->initCorrelationTwoTickers($tickerCourse, $currentTickerCourse, $timeFrame, $lag, count($currentTickerData));
                } else {
                    $result = $crossCorrelation->initCorrelationTwoTickers($currentTickerCourse, $tickerCourse, $timeFrame, $lag, count($currentTickerData));
                }
				//Calculate average values for correlations for every lag
                for ($i = 1; $i <= $lag; $i++) {
                    $average = array_sum(array_column($result, $i)) / count($result);
                    $arr = array("average" => $average, "ticker" => $currentTicker, "lag" => $i);
                    array_push($resultArr, $arr);
                }
            }
        }
        sort($resultArr);
        return $resultArr;
    }
}

?>