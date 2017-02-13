<?php
if(!empty($_GET['ticker'])){
 	$tickerName = $_GET['ticker'];
}else{
	$tickerName = 'no ticker selected';
}
$tickerInfo = $select->getTickerInfo("$tickerName");

$favourites = $_SESSION['favourites'];
	
if(isset($_GET['fav'])){
	if($_GET['fav'] == 'true'){
		array_push($favourites, $tickerName);
	} else {
		if(($key = array_search($tickerName, $favourites)) !== false) {
			unset($favourites[$key]);
		}
	}
	$_SESSION['favourites'] = $favourites;
}
?> 

<div class="col-md-12">
	<div class = "row">
	<div class="col-md-2">
	<input type="button" value="Back" onclick="window.history.back()" /> 
	</div>
	</div>
	<br>
	<div class="panel panel-default">
        <!--<div class="panel-heading">Ticker: <?php echo $tickerName; ?><a href="#" onclick="setFav(<?php echo $tickerName; ?>)"><span class="glyphicon glyphicon-heart pull-right"></a></div>-->
		<?php
			if(in_array($tickerName, $favourites)){
				echo '<div class="panel-heading" >Ticker:'. $tickerName.'<a href="index.php?action=displayTicker&ticker='.$tickerName.'&fav=false"><span class="glyphicon glyphicon-heart pull-right"></a></div>' ;
				
			} else {
				echo '<div class="panel-heading" >Ticker:'. $tickerName.'<a href="index.php?action=displayTicker&ticker='.$tickerName.'&fav=true"><span class="glyphicon glyphicon-heart-empty pull-right"></a></div>' ;
				
				$_SESSION['favourites'] = $favourites;
			}
		?>
        <div class="panel-body">
        	<div class="row">
	        	<div class="col-md-4">
		        	<div class="panel panel-info">
		        		<div class="panel-heading">additional informations</div>
		        		<div class="panel-body">
		        			<table class="table">
		                    <tbody>
		                      <tr>
		                        <td>Company name:</td>
		                        <td><?php echo $tickerInfo["Company"]; ?></td>
		                      </tr>
		                      <tr>
		                        <td>Ticker:</td>
		                        <td><?php echo $tickerInfo["Ticker"]; ?></td>
		                      </tr>
		                      <tr>
		                        <td>Exchange:</td>
		                        <td><?php echo $tickerInfo["Exchange"]; ?></td>
		                      </tr>
		                      <tr>
		                        <td>Country:</td>
		                        <td><?php echo $tickerInfo["Country"]; ?></td>
		                      </tr>
		                        <tr>
		                        <td>Market capacity:</td>
		                        <td><?php echo $tickerInfo["MarketCapacity"]. " $"; ?></td>
		                      </tr>   
		                      <tr>
		                        <td>IPO Year:</td>
		                        <td><?php echo $tickerInfo["IPOYear"]; ?></td>
		                      </tr>
							  <tr>
		                        <td>Category:</td>
		                        <td><?php echo $tickerInfo["Category"]; ?></td>
		                      </tr>
							  <tr>
		                        <td colspan = "2">Click <a target="_blank" href="<?=$tickerInfo["Link"];?>">here</a> for more information</td>
		                       
		                      </tr>
		                    </tbody>
		                  </table>
		        		</div>
		        	</div>
		        </div>
		        <div class="col-md-8">
		        	<div class="panel panel-warning">
		        		<div class="panel-heading">Current stock prize (last 30 days)</div>
		        		<div class="panel-body">
		        			<?php include("charts/chart_displayCourse.php"); ?>
		        		</div>
		        	</div>
	        	</div>
        	</div>
        	
        </div>
    </div>
</div>

<script type="text/javascript">
var fav = new Array();
function getFav() {
	return fav;
}
function setFav(favValue){
	fav.push(favValue);
	window.alert(favValue);
}
}

</script>