<?php
$best = $select->getHighestCourses('10', '0');
$worst= $select->getHighestCourses('10', '1');

$allTickers = $select->getCurrentValues();
shuffle($allTickers);

?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body" style = "padding: 2px;">

            <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="5000" id="bs-carousel">
                <!-- Overlay -->
                <div class="overlay"></div>

                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#bs-carousel" data-slide-to="1"></li>
                    <li data-target="#bs-carousel" data-slide-to="2"></li>
                    <li data-target="#bs-carousel" data-slide-to="3"></li>
                    <li data-target="#bs-carousel" data-slide-to="4"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item slides active">
                        <div class="slide-1"></div>
                        <div class="hero">
                            <hgroup>
                                <h1>Become a smart broker</h1>
                                <h3>Customize your own portfolio of correlating stocks</h3>
                            </hgroup>
                        </div>
                    </div>
                    <div class="item slides">
                        <div class="slide-2"></div>
                        <div class="hero">
                            <hgroup>
                                <h1>Large amount of data</h1>
                                <h3>Get access to more than 5000 tickers</h3>
                            </hgroup>
                        </div>
                    </div>
                    <div class="item slides">
                        <div class="slide-3"></div>
                        <div class="hero">
                            <hgroup>
                                <h1>Cross correlation</h1>
                                <h3>One of the most common and most useful statistics</h3>
                            </hgroup>
                        </div>
                    </div>
                    <div class="item slides">
                        <div class="slide-4"></div>
                        <div class="hero">
                            <hgroup>
                                <h1>Be always one step ahead</h1>
                                <h3>Compare two specific tickers of your interest</h3>
                            </hgroup>
                        </div>
                    </div>
                    <div class="item slides">
                        <div class="slide-5"></div>
                        <div class="hero">
                            <hgroup>
                                <h1>Be independent</h1>
                                <h3>There is no need for a stock consultant anymore</h3>
                            </hgroup>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
<div class = "row">
	<div class="col-md-6">
	<div class="panel panel-success">
        <div class="panel-heading">Top 10: Best tickers last trading day</div>
        <div class="panel-body">
        	<table class="table">
	        		<tbody>
					<?php
						for($i = 0; $i<10; $i++){
							echo "<tr>";
							echo '<td><span class="fa fa-arrow-up"></span></td>';
							echo '<td><a href="index.php?action=displayTicker&ticker='.$best[$i]['Ticker'].'">'.$best[$i]['Ticker'].'</td>';
							echo '<td style="color: green">+'.round($best[$i]['Change']).'%</td>';
						}
					?>
	        		</tbody>
	        	</table>
        	
        </div>
    </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-danger">
	        <div class="panel-heading">Top 10: Lowest tickers last trading day</div>
	        <div class="panel-body">
	        	<table class="table">
	        		<tbody>
	        			<?php
						for($i = 0; $i<10; $i++){
							echo "<tr>";
							echo '<td><span class="fa fa-arrow-down"></span></td>';
							echo '<td><a href="index.php?action=displayTicker&ticker='.$worst[$i]['Ticker'].'">'.$worst[$i]['Ticker'].'</td>';
							echo '<td style="color: red">'.round($worst[$i]['Change']).'%</td>';
						}
					?>
	        		</tbody>
	        	</table>
	        </div>
	    </div>
	</div>
	</div>
</div>
<div class="col-md-12">
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-info">
        <div class="panel-heading">Current data</div>
        <div class="panel-body">
		<marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
		<table class="table">
			
			<tbody>
				<?php
					for ($row = 0; $row < 2; $row ++) {
						echo "<tr>";
						for ($col = 0; $col < count($allTickers); $col ++) {
							if($row === 0){
								echo '<td><a href="index.php?action=displayTicker&ticker='.$allTickers[$col]["ticker"].'">'.$allTickers[$col]["ticker"]. '</a></td>';
							} else {
								$value = $allTickers[$col]["change"];
								if($value > 0){
									echo '<td style="color: green">+'.round($value, 2).' %</td>';
								} else if ($value < 0){
									echo '<td style="color: red">'.round($value, 2).' %</td>';
								}
							}
						}
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
		</marquee>
		</div>
    </div>
</div>
</div>
</div>