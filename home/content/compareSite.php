<?php
/*Creating arrays with all informations about tickers*/
$ticker1 = $select->getTickerInfo($_GET['ticker1']);
$ticker2 = $select->getTickerInfo($_GET['ticker2']);

/*Testing if calculation is in favourites*/
$favouriteCalculations = $_SESSION['favouriteCalculations'];
$fav = array("ticker1" => $_GET["ticker1"], "ticker2" => $_GET["ticker2"], "lag" => $_GET["lag"], "startDate" => $_GET["startDate"], "endDate" => $_GET["endDate"], "timeFrame" => $_GET["timeFrame"], "actualValue" => $_GET["actualValue"]);
$existing = -1;
$heart = "glyphicon-heart-empty";
$isFav = "true";
if (($key = array_search($fav, $favouriteCalculations)) !== false) {
    $existing = $key;
    $heart = "glyphicon-heart";
    $isFav = "false";
}
if (isset($_GET['fav'])) {

    if ($_GET['fav'] == "true") {
        $heart = "glyphicon-heart";
        $isFav = "false";
        if ($existing === -1) {
            array_push($favouriteCalculations, $fav);
        } else {
        }
    } else if ($_GET['fav'] == "false") {
        $isFav = "true";
        $heart = "glyphicon-heart-empty";
        //echo "existing";
        unset($favouriteCalculations[$existing]);
    }
    $_SESSION['favouriteCalculations'] = $favouriteCalculations;
}

?>

<!-- Show ticker info for both tickers -->
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Compare <?= $ticker1["Company"] . " and " . $ticker2["Company"] ?>
        </div>
        <div class="panel-body">


            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading"><?php echo $ticker1["Company"]; ?></div>
                    <div class="panel-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Symbol</td>
                                <td><?php echo "<a href=index.php?action=displayTicker&ticker=" . $ticker1["Ticker"] . ">" . $ticker1["Ticker"] . "</a>"; ?></td>
                            </tr>
                            <tr>
                                <td>Company</td>
                                <td><?php echo $ticker1["Company"]; ?></td>
                            </tr>
                            <tr>
                                <td>Exchange</td>
                                <td><?php echo $ticker1["Exchange"]; ?></td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td><?php echo $ticker1["Country"]; ?></td>
                            </tr>
                            <tr>
                                <td>Market capacity</td>
                                <td><?php echo $ticker1["MarketCapacity"] . " $"; ?></td>
                            </tr>
                            <tr>
                                <td>IPO year</td>
                                <td><?php echo $ticker1["IPOYear"]; ?></td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td><?php echo $ticker1["Category"]; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Click <a target="_blank" href="<?= $ticker1["Link"]; ?>">here</a> for
                                    more information
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading"><?php echo $ticker2["Company"]; ?></div>
                    <div class="panel-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Symbol</td>
                                <td><?php echo "<a href=index.php?action=displayTicker&ticker=" . $ticker2["Ticker"] . ">" . $ticker2["Ticker"] . "</a>"; ?></td>
                            </tr>
                            <tr>
                                <td>Company</td>
                                <td><?php echo $ticker2["Company"]; ?></td>
                            </tr>
                            <tr>
                                <td>Exchange</td>
                                <td><?php echo $ticker2["Exchange"]; ?></td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td><?php echo $ticker2["Country"]; ?></td>
                            </tr>
                            <tr>
                                <td>Market capacity</td>
                                <td><?php echo $ticker2["MarketCapacity"] . " $"; ?></td>
                            </tr>
                            <tr>
                                <td>IPO year</td>
                                <td><?php echo $ticker2["IPOYear"]; ?></td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td><?php echo $ticker2["Category"]; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Click <a target="_blank" href="<?= $ticker2["Link"]; ?>">here</a> for
                                    more information
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

			<!-- Show values that are used for calculation. Getting these values by HTTP-GET request -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Calculated with values:<a
                                href="<?= 'index.php?action=compareSite&ticker1=' . $_GET["ticker1"] . '&ticker2=' . $_GET["ticker2"] . '&lag=' . $_GET["lag"] . '&startDate=' . $_GET["startDate"] .
                                '&endDate=' . $_GET["endDate"] . '&actualValue=' . $_GET["actualValue"] . '&fav=' . $isFav ."&timeFrame=".$_GET["timeFrame"] ?>"
                        "><span class="glyphicon <?= $heart ?> pull-right"></span></a></div>

                    <div class="panel-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Start date:</td>
                                <td><?= $_GET['startDate'] ?></td>
                            </tr>
                            <tr>
                                <td>End date:</td>
                                <td><?= $_GET['endDate'] ?></td>
                            </tr>
                            <tr>
                                <td>Lag:</td>
                                <td><?= $_GET['lag'] ?></td>
                            </tr>
                            <tr>
                                <td>Calculated correlation:</td>
                                <td><?= $_GET['actualValue'] ?></td>
                            </tr>
                            <tr>
                                <td>Gradient chart:</td>
								<input = "text" id = "startDate" value="<?= $_GET['startDate'] ?>" hidden>
								<input = "text" id = "days" value="<?= $_GET['timeFrame'] ?>" hidden>
								<input = "text" id = "delay" value="<?= $_GET['lag'] ?>" hidden>
								<input = "text" id = "company" value="<?= $ticker2["Company"] ?>" hidden>
								<input = "text" id = "ticker1" value="<?= $ticker1["Ticker"] ?>" hidden>
								<input = "text" id = "ticker2" value="<?= $ticker2["Ticker"] ?>" hidden>
                                <td><?php
                                    if (isset($_GET["calculation_type"])) {
                                        if ($_GET["calculation_type"] == "true") {
                                            echo '<input id="calculation_type" data-no-uniform="true" type="checkbox" class="gradientChart" checked>';
                                        } else {
                                            echo '<input id="calculation_type" data-no-uniform="true" type="checkbox" class="gradientChart">';
                                        }
                                    } else {
                                        echo '<input id="calculation_type" data-no-uniform="true" type="checkbox" class="gradientChart">';
                                    } ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                
                <div id="chart" class="row top-buffer">


                <?php
				/*Creating charts by including compareTwoTickerChart.php and giving values by HTTP-POST request*/
                    $_POST["ticker1"] = $_GET["ticker1"];//"AAPL";
                    $_POST["ticker2"] = $_GET["ticker2"];//"GOOG";
                    $_POST["company"] = $ticker2["Company"];
                    $_POST["startDate"] = $_GET["startDate"];//"2016-02-12";
                    $_POST["days"] = $_GET["timeFrame"];//"30";
                    $_POST["delay"] = $_GET["lag"];//"5";
                    $_POST["actualValue"] = $_GET["actualValue"];
                    if (isset($_GET["calculation_type"])) {
                        $_POST["calculation_type"] = $_GET["calculation_type"];
                    }
                    include('charts/compareTwoTickerChart.php');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>