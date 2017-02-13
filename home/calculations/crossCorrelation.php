<?php

/**
 * Class crossCorrelation
 * Main function for calculating the crosscorrelation values of two tickers at a given timeFrame and lag
 */
class crossCorrelation
{
    /** init function for calculating the crosscorrelation between to tickers
     * @param $ticker1 ticker1 as array with length of complete period
     * @param $ticker2 ticker2 as array with length of complete period
     * @param $timeFrame given timeFrame, ticker arrays will be sliced to the timeFrame size
     * @param $lag given maximum lag value
     * @param $lengthOfCompletePeriod length of complete period
     * @return array two dimensional result array, which stores all cross correlation values
     */
    function initCorrelationTwoTickers($ticker1, $ticker2, $timeFrame, $lag, $lengthOfCompletePeriod)
    {
        $result = [[]];

        for ($currentValue = 0; $currentValue < ($lengthOfCompletePeriod - $timeFrame - $lag); $currentValue++) {
            $ticker1_sliced = array_slice($ticker1, $currentValue, $timeFrame);
            //$ticker2_sliced = array_slice($ticker2, $currentValue, $timeFrame);

            for ($numberOfLags = 1; $numberOfLags <= $lag; $numberOfLags++) {
                $ticker2_sliced = array_slice($ticker2, ($currentValue + $numberOfLags), $timeFrame); //new
                $result[$currentValue][$numberOfLags] = $this->crossCorr($ticker1_sliced, $ticker2_sliced, $numberOfLags);
            }
        }
        return $result;
    }

    /**
     * @param $ticker1 ticker1 as already sliced array with a length of value timeFrame
     * @param $ticker2 ticker2 as already sliced array with a length of value timeFrame
     * @param $lag current lag, be careful it is not the maximum lag. It's the current lag value in the for loop for all lags
     * @return float|int returns cross correlation value of two tickers at a given day and a given lag
     */
    function crossCorr($ticker1, $ticker2, $lag)
    {
        $allValuesOfGivenPeriod = count($ticker1);
        $mean1 = array_sum($ticker1) / $allValuesOfGivenPeriod;
        $mean2 = array_sum($ticker2) / $allValuesOfGivenPeriod;
        $splitArrayA = $ticker1;//array_slice($ticker1, 0, ($allValuesOfGivenPeriod - $lag)); // Array from 0 to end - lag
        $splitArrayB = $ticker2;//array_slice($ticker2, $lag); // Array from lag to end
        $lengthOfSplit = count($splitArrayA);
        // set variables
        $a = 0;
        $b = 0;
        $axb = 0;
        $a2 = 0;
        $b2 = 0;
        $aSplit = 0;
        $bSplit = 0;
        // calculation
        for ($i = 0; $i < ($lengthOfSplit); $i++) {
            $aSplit = $splitArrayA[$i] - $mean1;
            $bSplit = $splitArrayB[$i] - $mean2;
            $axb = $axb + ($aSplit * $bSplit);
        }
        for ($i = 0; $i < $allValuesOfGivenPeriod; $i++) {
            $a = $ticker1[$i] - $mean1;
            $b = $ticker2[$i] - $mean2;
            $a2 = $a2 + pow($a, 2);
            $b2 = $b2 + pow($b, 2);
        }
        // correlation
        if (sqrt($a2 * $b2) == 0) {
            $corr = 0;
        } else {
            $corr = $axb / sqrt($a2 * $b2);
        }
        return $corr;
    }
}

?>

