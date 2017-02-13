<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

$(function(){
    $("#startDate").datepicker({ dateFormat: 'yy-mm-dd' });
});

$(function(){
    $("#lengthOfPeriod").datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>

<div id="inputValuesDiv" class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="font-size: 1.3em">Choose your values for calculation</div>
        <div class="panel-body">

            <div class="row">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-3">
                            <label>Choose start date:</label0
							><input type="text" id="lengthOfPeriod" value="" class="form-control"
                                   placeholder="2016-02-25">
                            
                        </div>
						<div class="col-lg-3">
                            <label>Choose end date:</label>
                            <input type="text" id="startDate" value="" class="form-control"
                                   placeholder="2016-02-25">
                        </div>
                        <!--<div class="col-lg-3">
                            <label>Select length of period:</label>
                            <input type="text" id="lengthOfPeriod" class="form-control" value="100" min="1" max="24">
                        </div>-->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="calculation_type">Select calculation type:</label>
                                <i class="fa fa-info-circle" rel="tooltip"
                                   title="Real float values: e.g. 0.4378 or &#13; Using only whole numbers"></i>
                                <select class="form-control" id="calculation_type">
                                    <option value="false">Actual course change</option>
                                    <option value="true">Boolean values (-1/0/1)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row top-buffer">
                        <div class="col-lg-3">
                            <label>Select ticker symbol 1:</label>
                            <input type="search" id="search_ticker1" list="livesearch1" value=""
                                   onkeyup="searchTicker1(this.value)" class="form-control"
                                   placeholder="search ticker (e.g. Apple)">
                            <datalist id="livesearch1"></datalist>
                        </div>
                        <div class="col-lg-3">
                            <label>Select ticker symbol 2:</label>
                            <input type="search" id="search_ticker2" list="livesearch2" value=""
                                   onkeyup="searchTicker2(this.value)" class="form-control"
                                   placeholder="search ticker (e.g. Facebook)">
                            <datalist id="livesearch2"></datalist>
                        </div>
                    </div>

                    <div class="row top-buffer">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="lag_value">Select lag:</label>
                                <select class="form-control" id="lag_value">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <label>Select timeframe:</label>
                            <input type="text" class="form-control" id="timeFrame" value="15" min="15"
                                   max="60">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row remove-button">
                <div class="col-lg-1">
                    <button type="button" id="create_table_button" class="btn btn-primary">Calculate</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- after clicking the button, table will appear in this div -->
<div id="resultingTableDiv" class="col-md-12" style="display: none">
    <div class="panel panel-default">
        <div class="panel-heading" style="font-size: 1.1em">Resulting table</div>
        <div class="panel-body">
            <div class="row" style="margin-left:2px">
			<div class="container">
		<!--	<div class="row">
                        <div class="col-lg-3 col-lg-offset-8">
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
                    </div> -->
					<div id="div_for_table" class="top-buffer">
					</div>
                </div>
            </div>
        </div>
    </div>
</div>