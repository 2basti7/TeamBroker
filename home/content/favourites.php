<?php
/*Getting favourite tickersymbols from session*/
$favourites = $_SESSION['favourites'];
sort($favourites);

/*Getting favourite calculations from session*/
$favouriteCalculations = $_SESSION['favouriteCalculations'];
sort($favouriteCalculations);
?>

<div class="col-md-12">
    <div class="col-md-6">
        <div class="panel panel-success">
		<!-- Display favourite tickers -->
            <div class="panel-heading">Favourite tickers</div>
            <div class="panel-body">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Ticker</td>
                        <td>Company</td>
                    </tr>
                    <?php
                    for ($i = 0; $i < count($favourites); $i++) {
                        $tickerInfo = $select->getTickerInfo($favourites[$i]);
                        $link = "index.php?action=displayTicker&ticker=" . $favourites[$i];
                        echo "<tr>";
                        echo '<td><a href="' . $link . '">' . $favourites[$i] . '</td>';
                        echo '<td><a href="' . $link . '">' . $tickerInfo["Company"] . '</td>';
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-success">
			<!-- Display favourite calculations -->
            <div class="panel-heading">Favourite calculations</div>
            <div class="panel-body">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Ticker 1</td>
                        <td>Ticker 2</td>
                        <td>Date</td>
                        <td>Lag</td>
                        <td>Correlation</td>
                    </tr>
                    <?php

                    for ($i = 0; $i < count($favouriteCalculations); $i++) {
                        $link = 'index.php?action=compareSite&ticker1=' . $favouriteCalculations[$i]['ticker1'] .
                            '&ticker2=' . $favouriteCalculations[$i]['ticker2'] .
                            '&lag=' . $favouriteCalculations[$i]['lag'] .
                            '&startDate=' . $favouriteCalculations[$i]['startDate'] .
							'&endDate=' . $favouriteCalculations[$i]['endDate'].
                            '&timeFrame=' . $favouriteCalculations[$i]['timeFrame'] .
                            '&actualValue=' . $favouriteCalculations[$i]['actualValue'];

                        echo "<tr>";
                        echo '<td><a href = "' . $link . '">' . $favouriteCalculations[$i]['ticker1'] . '</a></td>';
                        echo '<td><a href = "' . $link . '">' . $favouriteCalculations[$i]['ticker2'] . '</a></td>';
                        echo '<td><a href = "' . $link . '">' . $favouriteCalculations[$i]['startDate'] . '</a></td>';
                        echo '<td><a href = "' . $link . '">' . $favouriteCalculations[$i]['lag'] . '</a></td>';
                        echo '<td><a href = "' . $link . '">' . $favouriteCalculations[$i]['actualValue'] . '</a></td>';
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>