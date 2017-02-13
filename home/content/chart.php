<?php
$ticker1 = $select->getTickerInfo($_GET['ticker1']);
$ticker2 = $select->getTickerInfo($_GET['ticker2']);
	
$favouriteCalculations = $_SESSION['favouriteCalculations'];
$fav = array("ticker1" => $_GET["ticker1"], "ticker2" => $_GET["ticker2"], "lag" => $_GET["lag"], "date" => $_GET["date"], "timeFrame" => $_GET["timeFrame"], "actualValue" => $_GET["actualValue"]);
$existing = -1;
$heart = "glyphicon-heart-empty";
$isFav = "true";
if(($key = array_search($fav, $favouriteCalculations)) !== false) {
	$existing = $key;
	$heart = "glyphicon-heart";
	$isFav = "false";
	//$existing = 1;
	//echo "existing";
} else {
	//echo "not existing";
}
if(isset($_GET['fav'])){
		
	if($_GET['fav'] == "true"){
		$heart = "glyphicon-heart";
		$isFav = "false";
		if($existing === -1) {
			array_push($favouriteCalculations, $fav);
		} else {
		}
	} else if($_GET['fav'] == "false"){
		$isFav = "true";
		$heart = "glyphicon-heart-empty";
		//echo "existing";
		unset($favouriteCalculations[$existing]);
	}
	$_SESSION['favouriteCalculations'] = $favouriteCalculations;
} 

?>

<div class="col-md-12">
	<div class="panel panel-default">
        <div class="panel-heading">Compare <?=$ticker1["Company"]." and ".$ticker2["Company"]?>
		
		
		
		</div>
        <div class="panel-body">
		
		
		
	<div class="col-md-6">
	<div class="panel panel-success">
        <div class="panel-heading"><?php echo $ticker1["Company"];?></div>
        <div class="panel-body">
        	<table class="table">
	        		<tbody>
	        			<tr>
	        				<td>Symbol</td>
	        				<td><?php echo "<a href=index.php?action=displayTicker&ticker=".$ticker1["Ticker"].">".$ticker1["Ticker"]."</a>";?></td>
	        			</tr>
	        			<tr>
	        				<td>Company</td>
	        				<td><?php echo $ticker1["Company"];?></td>
	        			</tr>
	        			<tr>
	        				<td>Exchange</td>
	        				<td><?php echo $ticker1["Exchange"];?></td>
	        			</tr>
	        			<tr>
	        				<td>Country</td>
	        				<td><?php echo $ticker1["Country"];?></td>
	        			</tr>
						<tr>
	        				<td>Market capacity</td>
	        				<td><?php echo $ticker1["MarketCapacity"]." $";?></td>
	        			</tr>
						<tr>
	        				<td>IPO year</td>
	        				<td><?php echo $ticker1["IPOYear"];?></td>
	        			</tr>
						<tr>
	        				<td>Category</td>
	        				<td><?php echo $ticker1["Category"];?></td>
	        			</tr>
						<tr>
		                        <td colspan = "2">Click <a target="_blank" href="<?=$ticker1["Link"];?>">here</a> for more information</td>
		                </tr>
	        		</tbody>
	        	</table>
        	
        </div>
    </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-danger">
        <div class="panel-heading"><?php echo $ticker2["Company"];?></div>
        <div class="panel-body">
        	<table class="table">
	        		<tbody>
	        			<tr>
	        				<td>Symbol</td>
	        				<td><?php echo "<a href=index.php?action=displayTicker&ticker=".$ticker2["Ticker"].">".$ticker2["Ticker"]."</a>";?></td>
	        			</tr>
	        			<tr>
	        				<td>Company</td>
	        				<td><?php echo $ticker2["Company"];?></td>
	        			</tr>
	        			<tr>
	        				<td>Exchange</td>
	        				<td><?php echo $ticker2["Exchange"];?></td>
	        			</tr>
	        			<tr>
	        				<td>Country</td>
	        				<td><?php echo $ticker2["Country"];?></td>
	        			</tr>
						<tr>
	        				<td>Market capacity</td>
	        				<td><?php echo $ticker2["MarketCapacity"]." $";?></td>
	        			</tr>
						<tr>
	        				<td>IPO year</td>
	        				<td><?php echo $ticker2["IPOYear"];?></td>
	        			</tr>
						<tr>
	        				<td>Category</td>
	        				<td><?php echo $ticker2["Category"];?></td>
	        			</tr>
						<tr>
		                    <td colspan = "2">Click <a target="_blank" href="<?=$ticker2["Link"];?>">here</a> for more information</td>
		                </tr>
	        		</tbody>
	        	</table>
        	
        </div>
    </div>
</div>

	<div class="col-md-12">
		<div class = "panel panel-default">
		<div class="panel-heading">Calculated with values:<a href="<?='index.php?action=chart&ticker1='.$_GET["ticker1"].'&ticker2='.$_GET["ticker2"].'&lag='.$_GET["lag"].'&date='.$_GET["date"].
		'&timeFrame='.$_GET["timeFrame"].'&actualValue='.$_GET["actualValue"].'&fav='.$isFav?>" "><span class="glyphicon <?=$heart?> pull-right"></a></div>
			
			<div class="panel-body">
				<table class="table">
	        		<tbody>
	        			<tr>
	        				<td>Date:</td>
	        				<td ><?=$_GET['date']?></td>
	        			</tr>
	        			<tr>
	        				<td>Timeframe:</td>
	        				<td><?=$_GET['timeFrame']?></td>
	        			</tr>
						<tr>
	        				<td>Lag:</td>
	        				<td><?=$_GET['lag']?></td>
	        			</tr>
	        			<tr>
	        				<td>Calculated correlation:</td>
	        				<td><?=$_GET['actualValue']?></td>
	        			</tr>
						<tr>
							<td>Gradient chart:</td>
							<td><?php
								if(isset($_GET["calculation_type"])){
									if($_GET["calculation_type"] == "true"){
										echo '<input id="calculation_type" data-no-uniform="true" type="checkbox" class="iphone-toggle" checked>';
									} else {
										echo '<input id="calculation_type" data-no-uniform="true" type="checkbox" class="iphone-toggle">';
									}
								} else {
									echo '<input id="calculation_type" data-no-uniform="true" type="checkbox" class="iphone-toggle">';
								}?>
						</tr>
	        		</tbody>
	        	</table>
			</div>
			
		</div>
		<input = "text" id = "date" value="<?=$_GET['date']?>" hidden>
		<input = "text" id = "days" value="<?=$_GET['timeFrame']?>" hidden>
		<input = "text" id = "delay" value="<?=$_GET['lag']?>" hidden>
		<input = "text" id = "company" value="<?=$ticker2["Company"]?>" hidden>
		<input = "text" id = "ticker1" value="<?=$ticker1["Ticker"]?>" hidden>
		<input = "text" id = "ticker2" value="<?=$ticker2["Ticker"]?>" hidden>
	<div id="chart" class="row top-buffer">
		
    
		<?php
		$_POST["ticker1"] = $_GET["ticker1"];//"AAPL";
		$_POST["ticker2"] = $_GET["ticker2"];//"GOOG";
		$_POST["company"] = $ticker2["Company"];
		$_POST["date"] = $_GET["date"];//"2016-02-12";
		$_POST["days"] = $_GET["timeFrame"];//"30";
		$_POST["delay"] = $_GET["lag"];//"5";
		$_POST["actualValue"] = $_GET["actualValue"];
		if(isset($_GET["calculation_type"])){
			$_POST["calculation_type"] = $_GET["calculation_type"];
		}
		include('charts/compareTwoTickerChart.php');
		?>
		</div>
		</div>
    </div>
</div>