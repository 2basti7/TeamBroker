<?php
$exchanges = $select->getExchanges();
?>

<div class="col-md-12">
    <!--<div class="panel panel-default">
        <div class="panel-heading">
			<h4 class="panel-title">
				<a class="panel_font_size_small" data-toggle="collapse" data-parent="#accordion1"
                                       href="#collapsea">
                                        Explanation</a>
			</h4>
		</div>
        <div id="collapsea" class="panel-collapse collapse out">
			<div class="panel-body">
            Insert a new tickersymbol with information. <br>
			The historical data will be inserted automatically and the current data will be collected.
			</div>
        </div>
    </div>-->


    <div class="panel panel-default">
        <div class="panel-heading" style="font-size: 1.3em">Choose your values for inserting</div>
        <div class="panel-body">

            <div class="row">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-3">
                            <label>Tickersymbol:</label>
                            <input type="text" name="ticker" id="ticker" class="form-control"
                                   placeholder="e.g. AAPL">
                        </div>

                        <div class="col-lg-3">
                        </div>

                        <div class="col-lg-3">
                            <label>Company:</label>
                            <input type="text" name="company" id="company" class="form-control"
                                   placeholder="e.g. Apple Inc.">
                        </div>
                    </div>

                    <div class="row top-buffer">
                        <div class="col-lg-3">
                            <label>Exchange:</label>
                            <select class="form-control" name="exchange" id="exchange">
                                <option value="">Select...</option>
                                <?php
                                foreach ($exchanges AS $exchange) {
                                    echo '<option value="' . $exchange . '">' . $exchange . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-lg-3">
                        </div>

                        <div class="col-lg-3">
                            <label>Country:</label>
                            <input type="text" name="country" id="country" class="form-control"
                                   placeholder="e.g. USA">
                        </div>
                    </div>

                    <div class="row top-buffer">
                        <div class="col-lg-3">
                            <label>Market Capacity:</label>
                            <input type="text" name="marketCap" id="marketCap" class="form-control"
                                   placeholder="in USD (e.g. 634540000000)">
                        </div>

                        <div class="col-lg-3">
                        </div>

                        <div class="col-lg-3">
                            <label>IPOYear:</label>
                            <input type="text" name="ipoYear" id="ipoYear" class="form-control"
                                   placeholder="e.g. 1980">
                        </div>
                    </div>

                    <div class="row top-buffer">
                        <div class="col-lg-3">
                            <label>Category:</label>
                            <input type="text" name="category" id="category" class="form-control"
                                   placeholder="e.g. Technology">
                        </div>

                        <div class="col-lg-3">
                        </div>

                        <div class="col-lg-3">
                            <label>Link for further information:</label>
                            <input type="text" name="link" id="link" class="form-control"
                                   placeholder="">
                        </div>
                    </div>

                </div>
            </div>
            <div class="row top-buffer">
                <div class="col-lg-1">
                    <button type="button" id="insert_new_ticker" class="btn btn-primary">Insert</button>
                </div>
            </div>

            <div id="insert_ticker_result" class="row top-buffer">
            </div>
        </div>
    </div>
</div>