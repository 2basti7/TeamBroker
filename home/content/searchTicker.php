<?php
$allTickers = $select->getAllTickerInfo();
$countTickers = count($allTickers);
?>
<script>
	showResult("%");
</script>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><h4>Search a Ticker (<?php echo $countTickers ?> tickers in database)</h4></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
				<input class="form-control" type="text" size="30" onkeyup="showResult(this.value)" placeholder="search ticker">
                </div>
            </div>
            <div class="row">
			<div class="col-lg-12">
			
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Ticker</th>
                        <th>Full name</th>
                        <th>Stock Exchange</th>
                    </tr>
                </thead>
                <tbody id="livesearch">
                    
                </tbody>
            </table>
			<div id="moreResults"></div>
            <hr>
        </div>
    </div>
        </div>
    </div>
</div>



