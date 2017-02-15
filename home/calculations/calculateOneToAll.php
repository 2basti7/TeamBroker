<?php

//used for showing 10 best and 10 worst results from one against all / all against one calculations in a table

require('OneToAllFunction.php');
$oneToAllFunction = new OneToAllFunction();

//Get POST variables and save
$ticker = strtoupper($_POST["ticker1"]);
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$lag = $_POST['lag'];
$timeFrame = $_POST['timeFrame'];
$sort = 0;
$calculation_type = $_POST['calculation_type'];
//Calculate crosscorrelation one against all / all against one
$resultArr = $oneToAllFunction->calculateTickerAgainstAll($ticker, $startDate, $endDate, $lag, $timeFrame, $sort, $calculation_type);
$lengthOfPeriod = count($resultArr);
$res = array_slice($resultArr, 0, 10);
$resRev = array_reverse(array_slice($resultArr, -10, 10));
?>

<div class="col-md-12">

	<!-- table for 10 best postitive correlations -->
    <div class="col-md-6">

        <?php
        if ($resRev[0]['average'] !== 0) {
			//header for table 
            echo '<div class="panel panel-success">
				<div class="panel-heading">Top 10 best positive correlation</div>
				<div class="panel-body">
				<table class="table">
	        		<tbody>
					<td><div class="panel-heading">Ticker</div></td>
					<td align = "center"><div class="panel-heading">&#8709; Value</div></td>
					<td align = "center"><div class="panel-heading">Lag</div></td>';

			//building the table with links to crosscorrelation calculation for two tickers
            for ($i = 0; $i < 10; $i++) {
                echo "<tr>";
                if ($calculation_type == 1) {
                    echo '<td><a target="_blank" href="index.php?action=showTwoTickers&ticker1=' . $resRev[$i]['ticker'] . '&ticker2=' . $ticker . '&startDate=' . $startDate . '&endDate=' . $endDate . '&lag_value='
                        . $lag . '&timeFrame=' . $timeFrame . '&lag_best=' . $resRev[$i]['lag'] . '">' . $resRev[$i]['ticker'] . '</td>';
                } else {
                    echo '<td><a target="_blank" href="index.php?action=showTwoTickers&ticker1=' . $ticker . '&ticker2=' . $resRev[$i]['ticker'] . '&startDate=' . $startDate . '&endDate=' . $endDate . '&lag_value='
                        . $lag . '&timeFrame=' . $timeFrame . '&lag_best=' . $resRev[$i]['lag'] . '">' . $resRev[$i]['ticker'] . '</td>';
                }
                echo '<td style="color: green" align = "center">' . round($resRev[$i]['average'], 4) . '</td>';
                echo '<td align = "center">' . $resRev[$i]['lag'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<div class="alert alert-danger col-lg-1" style="width:280px"><strong>Not successfull!</strong> Please specify a time period longer than timeframe + lag!</div>';
        }
        ?>
        </tbody>
        </table>

    </div>
	</div>
	</div>
	<!-- table for 10 best negative correlations -->
	<div class="col-md-6">

		<?php
		if ($res[0]['average'] !== 0) {
			//header for table 
			echo '<div class="panel panel-danger">
						<div class="panel-heading">Top 10 best negative correlation</div>
						<div class="panel-body">
						<table class="table">
						<tbody>
						<td><div class="panel-heading">Ticker</div></td>
						<td align = "center"><div class="panel-heading">&#8709; Value</div></td>
						<td align = "center"><div class="panel-heading">Lag</div></td>';

			//building the table with links to crosscorrelation calculation for two tickers
			for ($i = 0; $i < 10; $i++) {
				echo "<tr>";
				if ($calculation_type == 1) {
					echo '<td><a target="_blank" href="index.php?action=showTwoTickers&ticker1=' . $res[$i]['ticker'] . '&ticker2=' . $ticker . '&startDate=' . $startDate . '&endDate=' . $endDate . '&lag_value='
						. $lag . '&timeFrame=' . $timeFrame . '&lag_best=' . $res[$i]['lag'] . '">' . $res[$i]['ticker'] . '</td>';
				} else {
					echo '<td><a target="_blank" href="index.php?action=showTwoTickers&ticker1=' . $ticker . '&ticker2=' . $res[$i]['ticker'] . '&startDate=' . $startDate . '&endDate=' . $endDate . '&lag_value='
						. $lag . '&timeFrame=' . $timeFrame . '&lag_best=' . $res[$i]['lag'] . '">' . $res[$i]['ticker'] . '</td>';
				}
				echo '<td style="color: red" align = "center">' . round($res[$i]['average'], 4) . '</td>';
				echo '<td align = "center">' . $res[$i]['lag'] . '</td>';
				echo '</tr>';
			}
		}
		?>
		</tbody>
		</table>
	</div>
	</div>
	</div>
</div>