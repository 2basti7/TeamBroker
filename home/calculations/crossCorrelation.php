<?php

/**
 * Class crossCorrelation
 * Main function for calculating the crosscorrelation coefficient of two tickers at a given timeframe and lag
 */
class crossCorrelation
{
    /** init function for calculating the crosscorrelation coefficient between to tickers
     * @param $ticker1 ticker1 as array with length of complete period
     * @param $ticker2 ticker2 as array with length of complete period
     * @param $timeFrame given timeframe, ticker arrays will be sliced to the timeFrame size
     * @param $lag given maximum lag value
     * @param $lengthOfCompletePeriod length of complete period
     * @return array two dimensional result array, which stores all cross correlation values
     */
    function initCorrelationTwoTickers($ticker1, $ticker2, $timeFrame, $lag, $lengthOfCompletePeriod)
    {
        // initialize empty two dimensional result array
        $result = [[]];

        // for loop to calculate the cross correlation values at a given day
        for ($currentDay = 0; $currentDay < ($lengthOfCompletePeriod - $timeFrame - $lag); $currentDay++) {

            // slice array of ticker1 to size of timeFrame
            $ticker1_sliced = array_slice($ticker1, $currentDay, $timeFrame);

            // for loop to calculate the cross correlation coefficient at a specific lag
            for ($currentLag = 1; $currentLag <= $lag; $currentLag++) {

                // slice array of ticker2 to size of timeFrame starting from currentDay plus currentLag
                $ticker2_sliced = array_slice($ticker2, ($currentDay + $currentLag), $timeFrame);

                // call cross correlation function for two tickers at a given lag
                $result[$currentDay][$currentLag] = $this->crossCorr($ticker1_sliced, $ticker2_sliced, $currentLag);
            }
        }
        return $result;
    }

    /** core function for calculating a specific cross correlation coefficient
     * @param $ticker1 ticker1 as already sliced array with a length of value timeFrame
     * @param $ticker2 ticker2 as already sliced array with a length of value timeFrame
     * @param $lag current lag, be careful it is not the maximum lag. It's the current lag value in the for loop for all lags
     * @return float|int returns cross correlation value of two tickers at a given day and a given lag
     */
    function crossCorr($ticker1, $ticker2, $lag)
    {
        // get amount of values that affect the calculation
        $allValuesOfGivenPeriod = count($ticker1);

        // get mean values of both tickers
        $mean1 = array_sum($ticker1) / $allValuesOfGivenPeriod;
        $mean2 = array_sum($ticker2) / $allValuesOfGivenPeriod;

        // get
        $lengthOfSplit = count($ticker1);

        // set variables for calculation
        $a = 0;
        $b = 0;
        $axb = 0;
        $a2 = 0;
        $b2 = 0;
        $aSplit = 0;
        $bSplit = 0;

        // calculating the covariance between both tickers
        for ($i = 0; $i < $lengthOfSplit; $i++) {
            $aSplit = $ticker1[$i] - $mean1;
            $bSplit = $ticker2[$i] - $mean2;
            $axb = $axb + ($aSplit * $bSplit);
        }

        // calculating the square root of the prodcut from each variance
        for ($i = 0; $i < $allValuesOfGivenPeriod; $i++) {
            $a = $ticker1[$i] - $mean1;
            $b = $ticker2[$i] - $mean2;
            $a2 = $a2 + pow($a, 2);
            $b2 = $b2 + pow($b, 2);
        }

        // calculate cross correlation coefficient
        if (sqrt($a2 * $b2) == 0) {
            $corr = 0;
        } else {
            $corr = $axb / sqrt($a2 * $b2);
        }
        return $corr;
    }
}

?>

