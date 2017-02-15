<!-- after clicking the button, table will appear in this div -->
<div id="resultingTableDiv" class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="font-size: 1.1em">Resulting table</div>
        <div class="panel-body">
            <div class="row" style="margin-left:2px">
                <?php
                $_POST["ticker1"] = $_GET["ticker1"];
                $_POST["ticker2"] = $_GET["ticker2"];
                $_POST["startDate"] = $_GET["startDate"];
                $_POST["endDate"] = $_GET["endDate"];
                $_POST["lag"] = $_GET["lag_value"];
                $_POST["timeFrame"] = $_GET["timeFrame"];
                $_POST["oneToAll"] = "true";
                if (isset($_GET['calculation_type'])) {
                    $_POST['calculation_type'] = $_GET['calculation_type'];
                }
                include('calculations/callTwoTickerCrossCorr.php"');
                ?>
            </div>
        </div>
    </div>
</div>