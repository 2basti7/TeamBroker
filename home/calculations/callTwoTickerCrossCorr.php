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
$lengthOfCompletePeriod = $_POST['lengthOfPeriod'];
$lag = $_POST['lag'];
$timeFrame = $_POST['timeFrame'];

/* set calculation type to gradient method or not */
$calculationType = false;
if (isset($_POST['calculation_type'])) {
    $calculationType = $_POST['calculation_type'];
}

/* get data which is related to the given parameters */
$dataTicker1 = $select->selectByTicker($ticker1_symbol, $startDate, $lengthOfCompletePeriod, 0);
$dataTicker2 = $select->selectByTicker($ticker2_symbol, $startDate, $lengthOfCompletePeriod, 0);

$enddate = $_POST['lengthOfPeriod'];
$lengthOfCompletePeriod = count($dataTicker1);

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
$result = $corr->initCorrelationTwoTickers($ticker1, $ticker2, $timeFrame, $lag, count($dataTicker1));

?>


<!-- build table which displays all cross correlation coefficients. Rows as a specific day in given interval and columns as lag value -->
<div class="row" id="tableWithValues" style="margin-left: 2px;">
    <table class="table table-bordered"
           style="width:60%; border-collapse: collapse;border: 1px solid black">
        <thead>
        <tr><?php
            if (count($result) > 1) {
                echo '<th style="border: 1px solid black" bgcolor="#f5f5f5">Days</th>';

                for ($head_col = 1; $head_col <= $lag; $head_col++) {
                    echo '<th style="border: 1px solid black" bgcolor="#f5f5f5">' . 'Lag ' . $head_col . '</th>';
                }
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        /* buld table only if calculation succeded */
        if (count($result) > 1) {

            for ($row = 0; $row < $lengthOfCompletePeriod - $timeFrame - $lag; $row++) {
                echo '<tr>';
                for ($col = 0; $col <= $lag; $col++) {
                    $dayInTableColumn = $dates[$row];
                    if ($col == 0) {
                        echo '<td align="center" style="border: 1px solid black" bgcolor="#f5f5f5">' . $dayInTableColumn . '</td>';
                    } else {
                        $linkParametersForChart = "index.php?action=chart&ticker1=" . $ticker1_symbol . "&ticker2=" . $ticker2_symbol . "&lag=" . $col . "&date="
                            . $dayInTableColumn . "&timeFrame=" . $timeFrame . "&actualValue=" . $result[$row][$col] . "&calculation_type=" . $calculationType;

                        /* every cell in the table contains a link which forwards to the related line charts */
                        if ($result[$row][$col] >= 0.7) {
                            echo '<td align="center" style="border: 1px solid black" bgcolor="#009900"><a class="addTooltip" title="Significant" style="color:rgb(255,255,255)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                        } elseif ($result[$row][$col] >= 0.5 && $result[$row][$col] < 0.7) {
                            echo '<td align="center" style="border: 1px solid black" bgcolor="#00CC33"><a class="addTooltip" title="Weak" style="color:rgb(255,255,255)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                        } elseif ($result[$row][$col] >= 0.3 && $result[$row][$col] < 0.5) {
                            echo '<td align="center" style="border: 1px solid black" bgcolor="#A0C544"><a class="addTooltip" title="Very weak" style="color:rgb(255,255,255)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                        } elseif ($result[$row][$col] >= 0.1 && $result[$row][$col] < 0.3) {
                            echo '<td align="center" style="border: 1px solid black" bgcolor="#ADA96E"><a class="addTooltip" title="Very weak" style="color:rgb(255,255,255)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                        } elseif ($result[$row][$col] >= -0.2 && $result[$row][$col] < 0.1) {
                            echo '<td align="center" style="border: 1px solid black" bgcolor="#EE9A4D"><a class="addTooltip" title="Insignificant" style="color:rgb(0,0,0)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                        } elseif ($result[$row][$col] >= -0.5 && $result[$row][$col] < -0.2) {
                            echo '<td align="center" style="border: 1px solid black" bgcolor="#F88017"><a class="addTooltip" title="Insignificant" style="color:rgb(0,0,0)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                        } elseif ($result[$row][$col] < -0.5) {
                            echo '<td align="center" style="border: 1px solid black" bgcolor="#a52a2a"><a class="addTooltip" title="Insignificant" style="color:rgb(0,0,0)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                        } else {
                            echo '<td><a href="' . $linkParametersForChart . '">' . $result[$row][$col] . '</a></td>';
                        }
                    }
                }
                echo '</tr>';
            }
        } else {
            echo '<div class="alert alert-danger col-lg-1" style="width:280px"><strong>Not successfull!</strong> Please specify a time period longer than timeframe + lag!</div>';
        }


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

            for ($i = 0; $i < $lengthOfCompletePeriod - $timeFrame - $lag; $i++) {
                for ($j = 1; $j <= $lag; $j++) {
                    if ($result[$i][$j] === $max) {
                        $currentDayHighest = $i;
                        $currentLagHighest = $j;
                    }
                }
            }

            for ($x = 0; $x < $lengthOfCompletePeriod - $timeFrame - $lag; $x++) {
                for ($y = 1; $y <= $lag; $y++) {
                    if ($result[$x][$y] === $min) {
                        $currentDayLowest = $x;
                        $currentLagLowest = $y;
                    }
                }
            }

            /* build the links for http requests to draw the charts */
            $linkHighestValue = "index.php?action=chart&ticker1=" . $ticker1_symbol . "&ticker2=" . $ticker2_symbol . "&lag=" . $currentLagHighest . "&date="
                . $dates[$currentDayHighest] . "&timeFrame=" . $timeFrame . "&actualValue=" . $max . "&calculation_type=" . $calculationType;

            $linkLowestValue = "index.php?action=chart&ticker1=" . $ticker1_symbol . "&ticker2=" . $ticker2_symbol . "&lag=" . $currentLagLowest . "&date="
                . $dates[$currentDayLowest] . "&timeFrame=" . $timeFrame . "&actualValue=" . $min . "&calculation_type=" . $calculationType;
        }
        ?>
        </tbody>
    </table>
</div>

<!-- table which displays the highest and lowest value in an own div container -->
<div class="row" id="highLowValues">
    <div class="col-md-6">
        <table class="table table-bordered"
               style="width:60%; border-collapse: collapse;border: 1px solid black">
            <tbody>
            <?php if (count($result) > 1) {
                echo '<tr class="success">
        <td style="border: 1px solid black">Highest Value</td>';
                echo '<td style="border: 1px solid black"><a href="' . $linkHighestValue . '">' . $max . '</a></td>';
                echo '</tr>
    <tr class="danger">
        <td style="border: 1px solid black">Lowest Value</td>';
                echo '<td style="border: 1px solid black"><a href="' . $linkLowestValue . '">' . $min . '</a></td>';
            } ?>
            </tr>
            </tbody>
        </table>
    </div>
</div>