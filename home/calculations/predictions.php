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
//$calcTime = 21;
$result = [];
$myChange = "";
// get the course change of the choosen ticker
$CourseChangesOfTicker1 = $con->getCurrentChangeByTickerAndDate($choosenTicker, $calcTime);
$CourseChangeOfTicker1 = array_pop($CourseChangesOfTicker1);
//$likelihoods = $con->getLikelihood($choosenTicker,16);
switch (true) {
    // große Änderung hoch
    case $CourseChangeOfTicker1 >= 0.1:
        $myChange = '<span class="fa fa-arrow-up pull-right"></span>';
        calculationOfLikelihood($choosenTicker, $CourseChangesOfTicker1, $calcTime, 0);
        break;
    // mimimale bis gleichbleibende Änderung (hoch&tief)
    case $CourseChangeOfTicker1 < 0.1 and $CourseChangeOfTicker1 > -0.1:
        calculationOfLikelihood($choosenTicker, $CourseChangesOfTicker1, $calcTime, 3);
        $myChange = '<span class="fa fa-arrow-right pull-right"></span>';
        break;
    // größe Änderung runter
    case $CourseChangeOfTicker1 <= -0.1:
        calculationOfLikelihood($choosenTicker, $CourseChangesOfTicker1, $calcTime, 6);
        $myChange = '<span class="fa fa-arrow-down pull-right"></span>';
        break;
    default:
        echo "fehler: ";
        break;
}

function calculationOfLikelihood($ticker, $ticker1Change, $choosenTime, $case)
{
    global $con;
    $tickers = $con->getAllTickerInfo();
    $countTickers = count($tickers);
    $resultValueArray = [[]];

    for ($ArraySize2 = 0; $ArraySize2 < $countTickers; $ArraySize2++) {
        for ($ArraySize = 0; $ArraySize < 10; $ArraySize++) {
            $resultValueArray[$tickers[$ArraySize2]["ticker"]][$ArraySize] = 0;
        }
    }
    for ($varTicker = 0; $varTicker < $countTickers; $varTicker++) {
        $tickerName1 = $ticker;
        $tickerName2 = $tickers[$varTicker]["ticker"];
        $ticker2Change = $con->getCurrentChangeByTickerAndDate($tickerName2, ($choosenTime + 1));
        if (count($ticker1Change) != count($ticker2Change)) {
            // echo count($ticker1Change)." : ";
            // echo count($ticker2Change);
            // echo "<br>";
            continue;
        }
        $arrayCount = count($ticker1Change);
        for ($day = 0; $day < $arrayCount; $day++) {
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
    $result[0] = highest($resultValueArray, $tickers, ($case));
    $result[1] = lowest($resultValueArray, $tickers, ($case + 2));
}

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
 

