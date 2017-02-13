<?php
if (isset($_POST['change'])) {
    require('../db/Select.php');
    $select = new Select();
}
$ticker1 = $_POST["ticker1"];//'AAPL';
$ticker2 = $_POST["ticker2"];
$date = $_POST["date"];
$delay = $_POST["delay"];
$timeFrame = $_POST["days"];
$data = $select->selectByTicker2($ticker1, $date, $timeFrame, 1);
$data2 = $select->selectByTicker2($ticker2, $date, $timeFrame + $delay, 1);
$ticker1Data = array_column($data, 'change');//$select->getCourseChangeByTicker($ticker1, $date, $timeFrame, 1);
$ticker2Data = array_column($data2, 'change');//$select->getCourseChangeByTicker($ticker2, $date, $timeFrame + $delay, 1);

$days = array_column($data, 'date');//$select->getCourseDateByTicker($ticker1, $date, $timeFrame, 1);

$ticker3Data = array_slice($ticker2Data, $delay);

$calculationType = "false";
if (isset($_POST['calculation_type'])) {
    $calculationType = $_POST['calculation_type'];
}

//echo $calculationType;
if ($calculationType == "true") {
    $ticker1Data = convert($ticker1Data);
    $ticker2Data = convert($ticker2Data);
    $ticker3Data = convert($ticker3Data);
}

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

?>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Original charts</div>
        <div class="panel-body">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<script type="text/javascript">
    var days = <?php echo json_encode($days, JSON_PRETTY_PRINT) ?>;
    var ticker1Data = <?php echo json_encode($ticker1Data, JSON_PRETTY_PRINT) ?>;
    var ticker2Data = <?php echo json_encode($ticker2Data, JSON_PRETTY_PRINT) ?>;
    var ticker1 = <?php echo json_encode($ticker1, JSON_PRETTY_PRINT) ?>;
    var ticker2 = <?php echo json_encode($ticker2, JSON_PRETTY_PRINT) ?>;

    var calculationType = <?php echo json_encode($calculationType, JSON_PRETTY_PRINT) ?>;
    ;
    var lineTension = 0.4;
    if (calculationType == "true") {
        lineTension = 0;
    }
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: days,
            datasets: [{
                lineTension: lineTension,

                label: ticker1,
                data: ticker1Data,
                backgroundColor: "rgba(153,255,51,0.4)",
                borderColor: "rgba(153,255,51,1)"
            }, {
                lineTension: lineTension,
                label: ticker2,
                data: ticker2Data,
                backgroundColor: "rgba(169, 68, 66, 0.48)",
                borderColor: "rgba(169, 68, 66, 0.8)"
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "Change in %"
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "Date"
                    }
                }]
            }
        }
    });
</script>


<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $_POST['company'] ?> shifted for <?= $delay ?> days</div>
        <div class="panel-body">
            <canvas id="myChart2"></canvas>
        </div>
    </div>
</div>
<script type="text/javascript">
    var days = <?php echo json_encode($days, JSON_PRETTY_PRINT) ?>;
    var ticker1Data = <?php echo json_encode($ticker1Data, JSON_PRETTY_PRINT) ?>;
    var ticker3Data = <?php echo json_encode($ticker3Data, JSON_PRETTY_PRINT) ?>;
    var ticker1 = <?php echo json_encode($ticker1, JSON_PRETTY_PRINT) ?>;
    var ticker2 = <?php echo json_encode($ticker2, JSON_PRETTY_PRINT) ?>;

    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: days,
            datasets: [{
                lineTension: lineTension,
                label: ticker1,
                data: ticker1Data,
                backgroundColor: "rgba(153,255,51,0.4)"
            }, {
                lineTension: lineTension,
                label: ticker2,
                data: ticker3Data,
                backgroundColor: "rgba(169, 68, 66, 0.48)"
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "Change in %"
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "Date"
                    }
                }]
            }
        }
    });
</script>
		


