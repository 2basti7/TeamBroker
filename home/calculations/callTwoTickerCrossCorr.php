<?php

/* require crossCorrelation file in order to calculate the cross correlation */
require_once 'crossCorrelation.php';
$corr = new crossCorrelation();

/* for calculating one ticker against all also include Select.php file */
if (!isset($_POST["oneToAll"])) {
    include '../db/Select.php';
    $select = new Select();
}

/* custom method to convert the ordering of an array */
function convert($arr)
{
    $help = array();
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] < 0) {
            array_push($help, -1);
        } else if ($arr[$i] > 0) {
            array_push($help, 1);
        } else {
            array_push($help, 0);
        }
    }
    return $help;
}


/* fetch all input parameters from input fields in CompareTwoTickers or OneAgainstAll */
$ticker1_symbol = strtoupper($_POST['ticker1']);
$ticker2_symbol = strtoupper($_POST['ticker2']);
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$lag = $_POST['lag'];
$timeFrame = $_POST['timeFrame'];

/* set calculation type to gradient method or not */
$calculationType = false;
if (isset($_POST['calculation_type'])) {
    $calculationType = $_POST['calculation_type'];
}

/* get data which is related to the given parameters */
$dataTicker1 = $select->selectByTicker($ticker1_symbol, $startDate, $endDate, 0);
$dataTicker2 = $select->selectByTicker($ticker2_symbol, $startDate, $endDate, 0);

$lengthOfPeriod = count($dataTicker1);

/* store course change values in $ticker1 */
$ticker1 = array_column($dataTicker1, 'change');
$ticker2 = array_column($dataTicker2, 'change');
$dates = array_column($dataTicker1, 'date');

/* if gradient method then convert arrays */
if ($calculationType === "true") {
    $ticker1 = convert($ticker1);
    $ticker2 = convert($ticker2);
}

/* call cross correlation function to calculate all cross correlation coefficients */
$result = $corr->initCorrelationTwoTickers($ticker1, $ticker2, $timeFrame, $lag, $lengthOfPeriod);

?>


<!-- build table which displays all cross correlation coefficients. Rows as a specific day in given interval and columns as lag value -->
        <?php
        /* custom function to find maximum and minimum in an multidimensional array */
        function findMax($array)
        {
            if (is_array($array)) {
                foreach ($array as $key => $value) {
                    $array[$key] = findMax($value);
                }
                return max($array);
            } else {
                return $array;
            }
        }

        function findMin($array)
        {
            if (is_array($array)) {
                foreach ($array as $key => $value) {
                    $array[$key] = findMin($value);
                }
                return min($array);
            } else {
                return $array;
            }
        }


        /* get the highest and lowest value in the table with the related position */
        if (count($result) > 1) {
            $max = findMax($result);
            $min = findMin($result);

            for ($i = 0; $i < $lengthOfPeriod - $timeFrame - $lag; $i++) {
                for ($j = 1; $j <= $lag; $j++) {
                    if ($result[$i][$j] === $max) {
                        $currentDayHighest = $i;
                        $currentLagHighest = $j;
                    }
                }
            }

            for ($x = 0; $x < $lengthOfPeriod - $timeFrame - $lag; $x++) {
                for ($y = 1; $y <= $lag; $y++) {
                    if ($result[$x][$y] === $min) {
                        $currentDayLowest = $x;
                        $currentLagLowest = $y;
                    }
                }
            }

            /* build the links for http requests to draw the charts */
            $linkHighestValue = "index.php?action=compareSite&ticker1=" . $ticker1_symbol . "&ticker2=" . $ticker2_symbol . "&lag=" . $currentLagHighest . "&startDate="
                . $dates[$currentDayHighest] . "&timeFrame=" . $timeFrame . "&actualValue=" . $max . "&calculation_type=" . $calculationType. "&endDate=" . $dates[$currentDayLowest + $timeFrame];

            $linkLowestValue = "index.php?action=compareSite&ticker1=" . $ticker1_symbol . "&ticker2=" . $ticker2_symbol . "&lag=" . $currentLagLowest . "&startDate="
                . $dates[$currentDayLowest] . "&timeFrame=" . $timeFrame. "&actualValue=" . $min . "&calculation_type=" . $calculationType. "&endDate=" . $dates[$currentDayLowest + $timeFrame];
        
			include("twoTickerCrossCorrTable.php");
		} else {
			echo '<div class="alert alert-danger col-lg-1" style="width:280px"><strong>Not successfull!</strong> Please specify a time period longer than timeframe + lag!</div>';
		}
        ?>
       
</div>