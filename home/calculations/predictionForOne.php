<?php
class prediction {
	
	public $ticker;
	public $n;
	public $goingUp;
	public $goingDown;
	public $all;
	public $daysBack;
	public $sortedForNBest;
	public $sortedForNBestNegative;
	public $cc;
	public $currentChangePositive;
	public $currentChangeNegative;
	
	function predictCourseMovement($ticker, $daysBack, $n)
	{
		require_once '../db/Select.php';
		require_once 'crossCorrelation.php';
		$select = new Select();
		$crossCorrelation = new crossCorrelation();
		
		$lag = 5;
		$this->ticker = $ticker;
		$this->n = $n;
		$this->daysBack = $daysBack;

		//courses of ticker $ticker for last $daysBack days with corresponding dates
		$newestCourseChangesWithDates = $select->getNNewestCoursesWithDates($ticker, $daysBack);
		//all ticker symbols from our database
		$tickers = $select->getAllTickerInfo();
		//correct form for crossCorr function
		$newestCourses = array();
		for($i = 0; $i < count($newestCourseChangesWithDates); $i++)
		{
			array_push($newestCourses, $newestCourseChangesWithDates[$i]['change']);
		}
		
		//index for latest date
		$maxIndex = count($newestCourseChangesWithDates) - 1;
		//basically all to one cross-correlation with fixed timeframe
		foreach($tickers as $currentTicker)
		{
			//$currentTicker["ticker"] is tickername
			$currentTickerSymbol = $currentTicker["ticker"];
			$currentTickerData = $select->selectByTicker($currentTickerSymbol, $newestCourseChangesWithDates[$maxIndex]['date']->format('Y-m-d'), $daysBack, 1);
			$currentTickerNewestCourseChanges = array_column($currentTickerData, "change");
			//safe date arrays for all tickers; later used for getting appropriate date for comparison
			$dates[$currentTickerSymbol] = array_column($currentTickerData, "date");
			$result = array();
			//make sure that all datasets are of equal length
			if(count($currentTickerNewestCourseChanges) == $daysBack && count($currentTickerNewestCourseChanges) == count($newestCourses)) 
			{
				//call cross-correlation with lag 1 - 5 for current datasets
				for ($numberOfLags = 1; $numberOfLags <= $lag; $numberOfLags++) 
				{
					$result[0][$numberOfLags] = $crossCorrelation->crossCorr($currentTickerNewestCourseChanges, $newestCourses, $numberOfLags);
				}
			}	
			$cc[$currentTickerSymbol] = $result;
			//print_r($result);
		}
		
		//sort by correlationCoefficient
		$sortedForHighestPositiveCorrelation = $this->getHighestCorrelationWithCorrespondingLag($cc, $lag, 1);
		$sortedForHighestNegativeCorrelation = $this->getHighestCorrelationWithCorrespondingLag($cc, $lag, 0);
		
		$currentChangePositive = array();
		$currentChangeNegative = array();
		//get relevant course change from most influential tickers at date x = lastdate - appropriate lag; safe them in array (length n)
		for($i = 0; $i < $n; $i++)
		{
			$indexPositive = count($dates[$sortedForHighestPositiveCorrelation[$i]['ticker']]) - $sortedForHighestPositiveCorrelation[$i]['lag'];
			$currentDatePositive = $dates[$sortedForHighestPositiveCorrelation[$i]['ticker']][$indexPositive];
			$currentDatePositive = date("Y-m-d",strtotime($currentDatePositive));
			
			$indexNegative = count($dates[$sortedForHighestNegativeCorrelation[$i]['ticker']]) - $sortedForHighestNegativeCorrelation[$i]['lag'];
			$currentDateNegative = $dates[$sortedForHighestNegativeCorrelation[$i]['ticker']][$indexNegative];
			$currentDateNegative = date("Y-m-d",strtotime($currentDateNegative));
			
			if($currentDatePositive != null && $currentDateNegative != null)
			{
				array_push($currentChangePositive, array("course" => array_column(($select->selectByTicker($sortedForHighestPositiveCorrelation[$i]['ticker'], $currentDatePositive, 1, 1)), "change"), "date" => $currentDatePositive));
				array_push($currentChangeNegative, array("course" => array_column(($select->selectByTicker($sortedForHighestNegativeCorrelation[$i]['ticker'], $currentDateNegative, 1, 1)), "change"), "date" => $currentDateNegative));
			}
		}
		
		$countPositiveUp = 0;
		$countPositiveDown = 0;
		$countNegativeUp = 0;
		$countNegativeDown = 0;
		$neutral = 0;

		//count appropriate changes
		for($i = 0; $i < $n; $i++)
		{
			if($currentChangePositive[$i]["course"][0] > 0)
			{
				$countPositiveUp = $countPositiveUp + ($sortedForHighestPositiveCorrelation[$i]["correlationCoefficient"]);
			} elseif($currentChangePositive[$i]["course"][0] < 0)
			{
				$countPositiveDown = $countPositiveDown + ($sortedForHighestPositiveCorrelation[$i]["correlationCoefficient"]);
			} else {
				$neutral++;
			}
			
			if($currentChangeNegative[$i]["course"][0] > 0)
			{
				$countNegativeUp = $countNegativeUp + ($sortedForHighestNegativeCorrelation[$i]["correlationCoefficient"])*(-1);
			} elseif($currentChangeNegative[$i]["course"][0] < 0)
			{
				$countNegativeDown = $countNegativeDown + ($sortedForHighestNegativeCorrelation[$i]["correlationCoefficient"])*(-1);
			} else {
				$neutral++;
			}
		}
		//set values for prediction
		$this->goingUp = $countPositiveUp + $countNegativeDown;
		$this->goingDown = $countPositiveDown + $countNegativeUp;
		$this->all = $this->goingUp + $this->goingDown + $neutral;
		$this->sortedForHighestPositiveCorrelation = $sortedForHighestPositiveCorrelation;
		$this->sortedForHighestNegativeCorrelation = $sortedForHighestNegativeCorrelation;
		$this->cc = $cc;
		$this->currentChangePositive = $currentChangePositive;
		$this->currentChangeNegative = $currentChangeNegative;
	}
	
	/*
	returns an array sorted by the correlationCoefficient (switch = 1 for reverse order)
	entries have the form ("correlationCoefficient" => $correlationCoefficient, "ticker" => tickername, "lag" => lag)
	*/
	function getHighestCorrelationWithCorrespondingLag($compareTickerToAllOthers, $lag, $switch)
	{
		$result = array();
		foreach($compareTickerToAllOthers as $tickername => $correlationArray)
		{
			if(count($correlationArray) > 0)
			{
				for($i = 1; $i <= $lag; $i++)
				{
					$correlationCoefficient = $correlationArray[0][$i];
					$tempArr = array(
					"correlationCoefficient" => $correlationCoefficient,
					"ticker" => $tickername,
					"lag" => $i					
					);
					array_push($result, $tempArr);
				}
			}
		}
		
		sort($result);
		if($switch == 1)
		{
			$result = array_reverse($result);
		}
		return $result;
	}


}

$pred = new prediction();
if(isset($_POST["ticker_prediction"]) && isset($_POST["days_back"]) && isset($_POST["ticker_prediction_n"])){
	
$pred->predictCourseMovement($_POST["ticker_prediction"], $_POST["days_back"], $_POST["ticker_prediction_n"]);

}

?>

<div class="col-md-8">

		<?php 
		if($pred->goingUp > $pred->goingDown)
		{
			echo '<div class="panel panel-success">
					<div class="panel-heading text-center"> 
					<b>Prediction: course of '.strtoupper($pred->ticker).' is going up.</b>
					</div>
				</div>';
		} else if($pred->goingUp < $pred->goingDown)
		{
			echo '<div class="panel panel-danger">
					<div class="panel-heading text-center"> 
					<b>Prediction: course of '.strtoupper($pred->ticker).' is going down.</b>
					</div>
				</div>';
		} else {
			echo '<div class="panel panel-info">
					<div class="panel-heading text-center"> 
					<b>Prediction: course of '.strtoupper($pred->ticker).' is not moving.</b>
					</div>
				</div>';
		}
			 
		?>
		
</div>

<div class="col-md-12">
	
	<div class="col-md-6">
	<div class="panel panel-success">
        <div class="panel-heading"><?php echo "Additional information for the ".$pred->n." highest positive correlated datasets within the last ".$pred->daysBack." days:" ?></div>
        <div class="panel-body">
		
        	<table class="table">
	        		<tbody>
					
					<td><div class="panel-heading">Ticker</div></td>
					<td><div class="panel-heading">Correlation</div></td>
					<td><div class="panel-heading">Date</div></td>
					<td><div class="panel-heading">Change %</div></td>
					<?php
						for($i = 0; $i < $pred->n; $i++)
						{
							echo "<tr><td nowrap>".$pred->sortedForHighestPositiveCorrelation[$i]['ticker']."</td><td nowrap>".$pred->sortedForHighestPositiveCorrelation[$i]["correlationCoefficient"]."</td><td nowrap>".$pred->currentChangePositive[$i]["date"]."</td><td nowrap>".$pred->currentChangePositive[$i]["course"][0]."</td></tr>";
						}
					?>
					
	        		</tbody>
	        </table>
        	
        </div>
		
    </div>
	</div>
	<div class="col-md-6">
	<div class="panel panel-danger">
        <div class="panel-heading"><?php echo "Additional information for the ".$pred->n." highest negative correlated datasets within the last ".$pred->daysBack." days:" ?></div>
        <div class="panel-body">
		
        	<table class="table">
	        		<tbody>
					
					<td><div class="panel-heading">Ticker</div></td>
					<td><div class="panel-heading">Correlation</div></td>
					<td><div class="panel-heading">Date</div></td>
					<td><div class="panel-heading">Change %</div></td>
					<?php
						for($i = 0; $i < $pred->n; $i++)
						{
							echo "<tr><td nowrap>".$pred->sortedForHighestNegativeCorrelation[$i]['ticker']."</td><td nowrap>".$pred->sortedForHighestNegativeCorrelation[$i]["correlationCoefficient"]."</td><td nowrap>".$pred->currentChangeNegative[$i]["date"]."</td><td nowrap>".$pred->currentChangeNegative[$i]["course"][0]."</td></tr>";
						}
					?>
					
	        		</tbody>
	        </table>
        	
        </div>
		
    </div>
	</div>
</div>
 
