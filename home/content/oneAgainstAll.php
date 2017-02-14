<!-- used for entering values for one against all / all against one calculation -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

    $(function () {
        $("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
    });
    $(function () {
        $("#lengthOfPeriod").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="font-size: 1.3em">Choose your values for calculation</div>
        <div class="panel-body">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <label>Choose start date:</label>
                                ><input type="text" id="lengthOfPeriod" value="" class="form-control"
                                        placeholder="2016-02-25">

                        </div>
                        <div class="col-lg-3">
                            <label>Choose end date:</label>
                            <input type="text" id="startDate" value="" class="form-control"
                                   placeholder="2016-02-25">
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="calculation_type">Select calculation type:</label>
                                <select class="form-control" id="calculation_type">
                                    <option value="0">Ticker against all</option>
                                    <option value="1">All against ticker</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row top-buffer">
                        <div class="col-lg-3">
                            <label>Select ticker symbol:</label>
                            <input type="search" id="search_ticker" list="livesearch1" value=""
                                   onkeyup="searchTicker1(this.value)" class="form-control"
                                   placeholder="search ticker (e.g. Apple)">
                            <datalist id="livesearch1"></datalist>
                        </div>
                    </div>

                    <div class="row top-buffer">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="lag_value">Select lag:</label>
                                <select class="form-control" name="lag_value" id="lag_value">
                                    <?php
                                    for ($i = 1; $i < 6; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
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
			<!-- button for starting the calculation -->
            <div class="row remove-button">
                <div class="col-lg-1">
                    <button type="button" id="calc_one_against_all" class="btn btn-primary">Calculate</button>
                </div>
            </div>
        </div>

        <!-- after clicking the button, table will appear in this div -->
        <div id="div_for_table" class="row top-buffer">

        </div>
    </div>
</div>