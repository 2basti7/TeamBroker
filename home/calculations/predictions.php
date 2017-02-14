<!-- 
    tries to make a prediction for the live data at a specific time.
    Train data by classification of the course change of two tickers.
    classification: ticker 1 goes up and ticker 2 goes up -> 0
    (case)          ticker 1 goes up and ticker 2 stays equal -> 1
                    ticker 1 goes up and ticker 2 goes down -> 2
                    ticker 1 stays equal and ticker 2 goes up -> 3
                    ...
                    ticker 1 goes down and ticker 2 stays equal -> 7
                    ticker 1 goes down and ticker 2 ggoes down -> 8.
    After classifiation -> counts the appearance of every case to calculate the likelihood.
 -->
<?php
$choosenTicker = $_POST['ticker1'];
require_once '../db/Select.php';
$con = new Select();
// time on the server
$localTime = date("G:i");
// time for the calculation
$calcTime = $localTime;
// only data from 16h-23h, because stock exchange is closed
if ($localTime < 16) {
    $calcTime = date("G", strtotime("16:00:00"));
} elseif ($localTime > 23) {
    $calcTime = date("G", strtotime("16:00:00"));
} else {
    $calcTime += 1;
}
$result = [];
$myChange = "";
// get the course change of the choosen ticker
$CourseChangesOfTicker1 = $con->getCurrentChangeByTickerAndDate($choosenTicker, $calcTime);
$CourseChangeOfTicker1 = array_pop($CourseChangesOfTicker1);
// classification of the choosen ticker and call the method to compare it with the other ticker
switch (true) {
    // high change up
    case $CourseChangeOfTicker1 >= 0.1:
        $myChange = '<span class="fa fa-arrow-up pull-right"></span>';
        calculationOfLikelihood($choosenTicker, $CourseChangesOfTicker1, $calcTime, 0);
        break;
    // stay equals
    case $CourseChangeOfTicker1 < 0.1 and $CourseChangeOfTicker1 > -0.1:
        calculationOfLikelihood($choosenTicker, $CourseChangesOfTicker1, $calcTime, 3);
        $myChange = '<span class="fa fa-arrow-right pull-right"></span>';
        break;
    // high change down
    case $CourseChangeOfTicker1 <= -0.1:
        calculationOfLikelihood($choosenTicker, $CourseChangesOfTicker1, $calcTime, 6);
        $myChange = '<span class="fa fa-arrow-down pull-right"></span>';
        break;
    default:
        echo "fehler: ";
        break;
}
/*
    Function: calculationOfLikelihood($ticker, $ticker1Change, $choosenTime, $case).
    Parameter:  ticker - the choosen ticker
                ticker1Change - the change of the choosen ticker as array
                choosenTime - the choosen time
                case - the case -> 0 is UpUp, 1 is UpEquals, 2 is UpDown, 3 is EqualsUp, .. , 8 is DownDown
    Compare the course change of the choosen ticker against the changes of all tickers in the db to categorize them. 
    Count the appearance of the different cases to get a likelihood of occurrence.
*/
function calculationOfLikelihood($ticker, $ticker1Change, $choosenTime, $case)
{
    global $con;
    $tickers = $con->getAllTickerInfo();
    $countTickers = count($tickers);
    $resultValueArray = [[]];
    // initialize a helper array for the calculation
    for ($ArraySize2 = 0; $ArraySize2 < $countTickers; $ArraySize2++) {
        for ($ArraySize = 0; $ArraySize < 10; $ArraySize++) {
            $resultValueArray[$tickers[$ArraySize2]["ticker"]][$ArraySize] = 0;
        }
    }
    // runs over all tickers (Ticker1 and Ticker 2)
    for ($varTicker = 0; $varTicker < $countTickers; $varTicker++) {
        $tickerName1 = $ticker;
        $tickerName2 = $tickers[$varTicker]["ticker"];
        $ticker2Change = $con->getCurrentChangeByTickerAndDate($tickerName2, ($choosenTime + 1));
        if (count($ticker1Change) != count($ticker2Change)) {
            continue;
        }
        $arrayCount = count($ticker1Change);
        for ($day = 0; $day < $arrayCount; $day++) {
            // convoluted switch-case to get the right combination of course changes (get the correct case)
            switch (true) {
                case $ticker1Change[$day] >= 0.1:
                    switch (true) {

                        case $ticker2Change[$day] >= 0.1:
                            $resultValueArray[$tickers[$varTicker]["ticker"]][0] += 1;
                            break;

                        case $ticker2Change[$day] < 0.1 and $ticker2Change[$day] > -0.1:
                            $resultValueArray[$tickers[$varTicker]["ticker"]][1] += 1;
                            break;

                        case $ticker2Change[$day] <= -0.1:
                            $resultValueArray[$tickers[$varTicker]["ticker"]][2] += 1;
                            break;
                        default:
                            echo "fehler: " . $ticker1Change[$day] . " oder " . $ticker2Change[$day] . "<br>";
                            break;
                    }
                    break;

                case $ticker1Change[$day] < 0.1 and $ticker1Change[$day] > -0.1:
                    switch (true) {

                        case $ticker2Change[$day] >= 0.1:
                            $resultValueArray[$tickers[$varTicker]["ticker"]][3] += 1;
                            break;

                        case $ticker2Change[$day] < 0.1 and $ticker2Change[$day] > -0.1:
                            $resultValueArray[$tickers[$varTicker]["ticker"]][4] += 1;
                            break;

                        case $ticker2Change[$day] <= -0.1:
                            $resultValueArray[$tickers[$varTicker]["ticker"]][5] += 1;
                            break;
                        default:
                            echo "fehler: " . $ticker1Change[$day] . " oder " . $ticker2Change[$day] . "<br>";
                            break;
                    }
                    break;

                case $ticker1Change[$day] <= -0.1:
                    switch (true) {

                        case $ticker2Change[$day] >= 0.1:
                            $resultValueArray[$tickers[$varTicker]["ticker"]][6] += 1;
                            break;

                        case $ticker2Change[$day] < 0.1 and $ticker2Change[$day] > -0.1:
                            $resultValueArray[$tickers[$varTicker]["ticker"]][7] += 1;
                            break;

                        case $ticker2Change[$day] <= -0.1:
                            $resultValueArray[$tickers[$varTicker]["ticker"]][8] += 1;
                            break;

                        default:
                            echo "fehler: " . $ticker1Change[$day] . " oder " . $ticker2Change[$day] . "<br>";
                            break;
                    }
                    break;
                default:
                    echo "fehler: " . $ticker1Change[$day] . " oder " . $ticker2Change[$day] . "<br>";
                    break;
            }

        }
        $resultValueArray[$tickers[$varTicker]["ticker"]][9] = $arrayCount;
    }
    global $result;
    // get highest and lowest values of the result array
    $result[0] = highest($resultValueArray, $tickers, ($case));
    $result[1] = lowest($resultValueArray, $tickers, ($case + 2));
}

/*
    Function: highest($arr, $tickerList, $case).
    Parameter:  arr - a 2-dim. array for searching the highest value in it.
                tickerList - array with all ticker informations.
                case - the case -> 0 is UpUp, 1 is UpEquals, 2 is UpDown, 3 is EqualsUp, .. , 8 is DownDown.
    Find the highest value in a 2-dim. array and store it with the related ticker name in a result array.
*/
function highest($arr, $tickerList, $case)
{
    $result = [];
    $max = max(array_column($arr, $case));
    $result[0] = $max;
    $maxKeys = array_keys(array_column($arr, $case), $max);
    $i = 1;
    foreach ($maxKeys as $va) {
        $result[$i] = $tickerList[$va]["ticker"];
        $i++;
    }
    return $result;
}

/*
    Function: lowest($arr, $tickerList, $case).
    Parameter:  arr - a 2-dim. array for searching the highest value in it.
                tickerList - array with all ticker informations.
                case - the case -> 0 is UpUp, 1 is UpEquals, 2 is UpDown, 3 is EqualsUp, .. , 8 is DownDown.
    Find the lowest value in a 2-dim. array and store it with the related ticker name in a result array.
*/
function lowest($arr, $tickerList, $case)
{
    $result = [];
    $max = max(array_column($arr, $case));
    $result[0] = $max;
    $maxKeys = array_keys(array_column($arr, $case), $max);
    $i = 1;
    foreach ($maxKeys as $va) {
        $result[$i] = $tickerList[$va]["ticker"];
        $i++;
    }
    return $result;
}


?>

<!-- HTML part for visualize the result -->
<div class="panel panel-info">
    <div class="panel-heading" id="test">Live data prediction for <a
                href="index.php?action=displayTicker&ticker=<?php echo $choosenTicker ?>"><?php echo $choosenTicker ?></a>
    </div>
    <div class="panel-body">
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">Choosen Ticker at <?php echo($calcTime - 1) ?>:00h</div>
                <div class="panel-body">

                    <tbody>
                    <a href="index.php?action=displayTicker&ticker=<?php echo $choosenTicker ?>"><?php echo $choosenTicker ?></a> <?php echo $myChange ?>

                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-body">
                    Stock exchange is only open from 16:00h - 24:00h (UTC)
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">Increased probability to go up at <?php echo($calcTime) ?>:00h</div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                        <?php
                        for ($i = 1; $i < count($result[0]); $i++) {
                            echo "<tr>";
                            echo '<td><span class="fa fa-arrow-up"></span></td>';
                            echo '<td><a href="index.php?action=displayTicker&ticker=' . $result[0][$i] . '">' . $result[0][$i] . '</td>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-danger">
                <div class="panel-heading">Increased probability to go down at <?php echo($calcTime) ?>:00h</div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                        <?php

                        for ($i = 1; $i < count($result[1]); $i++) {
                            echo "<tr>";
                            echo '<td><span class="fa fa-arrow-down"></span></td>';
                            echo '<td><a href="index.php?action=displayTicker&ticker=' . $result[1][$i] . '">' . $result[1][$i] . '</td>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
 

