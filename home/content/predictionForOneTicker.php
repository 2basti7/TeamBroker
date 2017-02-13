<div class="col-md-12">

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" href="#collapse_explanation">Explanation</a>
			</h4>
		</div>
        <div class="collapse" id="collapse_explanation">
		<h4>Parameters:</h4>
		<b>Timeframe:</b> length of the datasets, which are used for calculating cross-correlation (number of days backwards from today)</br>
		<b>N:</b> highest N positive correlated datasets and highest N negative correlated datasets (within the timeframe), which are looked at for the prediction</br>
		</br>
		<h4>Algorithm:</h4>
		The prediction algorithm iterates over all tickers in our database and uses cross-correlation with a maximum lag of 5 to get N datasets, which have the highest positive correlation with the dataset of the specified ticker within the given timeframe, and N datasets, which have the highest negative correlation with the dataset of the specified ticker within the given timeframe, together with the corresponding lag.</br> 
		Now the assumtion is made, that these datasets are still somewhat good correlated, when one more day of course change is added.</br>
		Under this assumtion it looks at the next course changes, which come directly after the high correlated datasets, and uses these values to get an estimation for the specified ticker's course change direction.</br>
		If the number of positive course changes, which come after the good positive correlated datasets, plus the number of negative course changes, which come after the good negative correlated datasets is greater than
		the number of negative course changes, which come after the good positive correlated datasets, plus the number of positive course changes, which come after the good negative correlated datasets, 
		the algorithm would predict a positive course change for the specified ticker for today.
		Otherwise it would predict a negative course change, if its the other way around, or no course movement, if the numbers are equal.</br>
		</br>
		This prediction algorithm only uses cross-corelation for its calculations and doesn't consider external factors.</br>
		A good correlation between two datasets of course changes doesn't mean that the behavior of the course changes has to be dependent.</br>
		</br>
		<h4>Additional informations</h4>
		The two tables below the prediction result will show the values used for making the prediction.
		The left table has the values for the high positive correlated datasets and the right table for high negative correlated datasets.</br>
		The tickers in the table are ordered by their correlationcoefficient and show the date which would come after the good correlated datasets and the corresponding course change on that date.
		</div>
    </div>
	<div class="panel panel-default">
        <div class="panel-heading"><h4>Here you can get a prediction of the course movement for a specific ticker for todays closing course</h4>
			<p>(the calculation may take a while, depending on the size of the timeframe and N)</p>
		</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-3 col-lg-offset-4">
					<p>Ticker symbol:</p>
					<input class="form-control" id="ticker_prediction" type="text" size="30" placeholder="eg. AAPL">
					</br>
                </div>
				<div class="col-lg-3 col-lg-offset-4">
					<p>Timeframe:</p>
					<input class="form-control" id="days_back" type="number" size="30" placeholder="suggested value: 5-7">
					</br>
                </div>
				<div class="col-lg-3 col-lg-offset-4">
					<p>N:</p>
					<input class="form-control" id="ticker_prediction_n" type="number" size="30" placeholder="suggested value: 3-5">
                </div>
           </div>
			</br>
			<div class="row remove-button">
					<div class="col-lg-1 col-lg-offset-5">
						<button type="button" id="prediction" class="btn btn-info">Calculate prediction</button>
					</div>
				</div>
		</div>
	</div>
	
	<div id="div_for_prediction" class="row top-buffer"></div>

</div>