<!-- after clicking the button, table will appear in this div -->
<div id="resultingTableDiv" class="col-md-12" >
    <div class="panel panel-default">
        <div class="panel-heading" style="font-size: 1.1em">Resulting table</div>
        <div class="panel-body">
            <div class="row" style="margin-left:2px">
                <div id="div_for_table" class="top-buffer">
                    <div class="row" style="margin-left:1px">

                        <!--<div class="alert alert-success col-lg-1" style="width:280px">
                            <strong>Success!</strong> Calculation completed.
                        </div>-->
                        <div class="col-lg-3 col-lg-offset-5">
                            <button class="btn btn-primary" type="button" onclick="toggler('myContent');">
                                Explanation for table colors
                                <span class="caret"></span>
                            </button>
                            <div id="myContent" style="display: none; position:absolute;">
                                <table class="table table-bordered"
                                       style="border-collapse: collapse;border: 1px solid black; width: 200px">
                                    <thead>
                                    <tr>
                                        <th style="border: 1px solid black">Color</th>
                                        <th style="border: 1px solid black">Explanation</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td bgcolor="#009900" style="border: 1px solid black"></td>
                                        <td style="border: 1px solid black">Significant</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#00CC33" style="border: 1px solid black"></td>
                                        <td style="border: 1px solid black">Weak</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#A0C544" style="border: 1px solid black"></td>
                                        <td style="border: 1px solid black">Very Weak</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ADA96E" style="border: 1px solid black"></td>
                                        <td style="border: 1px solid black">Very Weak</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#EE9A4D" style="border: 1px solid black"></td>
                                        <td style="border: 1px solid black">Insignificant</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#F88017" style="border: 1px solid black"></td>
                                        <td style="border: 1px solid black">Insignificant</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#a52a2a" style="border: 1px solid black"></td>
                                        <td style="border: 1px solid black">Insignificant</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            
        
    


			<?php 
				$_POST["ticker1"] = $_GET["ticker1"];//"AAPL";
				$_POST["ticker2"] = $_GET["ticker2"];//"GOOG";
				$_POST["startDate"] = $_GET["startDate"];//"2016-02-12";
				$_POST["lengthOfPeriod"] = $_GET["lengthOfPeriod"];//"30";
				$_POST["lag"] = $_GET["lag_value"];//"5";
				$_POST["timeFrame"] = $_GET["timeFrame"];
				$_POST["oneToAll"] = "true";
				if(isset($_GET['calculation_type'])){
					$_POST['calculation_type'] = $_GET['calculation_type'];
				}
				include('calculations/callTwoTickerCrossCorr.php"');
			?>
			</div>
		</div>
	</div>
</div>