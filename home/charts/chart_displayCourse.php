<!-- display a course of a specific ticker with the aid of 'chart.js' -->
<canvas id="myChart"></canvas>
<?php
// get current date,course and the corresponding days of the ticker
$courseDate = date('Y-m-d');
$data = $select->selectByTicker2($tickerName, $courseDate, 30, 0);
$stockData = array_column($data, 'closeCourse');
$days = array_column($data, 'date');
?>

<script type="text/javascript">
    // json_encode in order to cast php array to javascript object
    var days = <?php echo json_encode($days, JSON_PRETTY_PRINT) ?>;
    var stockData = <?php echo json_encode($stockData, JSON_PRETTY_PRINT) ?>;
    var label = <?php echo json_encode($tickerName, JSON_PRETTY_PRINT) ?>;

    // use of 'chart.js' for display data
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            // 
            labels: days,
            datasets: [
                {
                    label: label,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: stockData,
                    spanGaps: false,
                },
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "Course in $"
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
