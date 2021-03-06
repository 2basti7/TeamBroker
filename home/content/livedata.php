<!-- content page for display the result of the live data analysis --> 
<div class="col-md-12">
    <div class="panel panel-info">
        <div class="panel-heading">Find your Ticker</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
                    <!-- input field to find a Ticker and calculate with these -->
                    <input type="search" id="search_ticker" list="livesearch1" value=""
                           onkeyup="searchTicker1(this.value)" class="form-control"
                           placeholder="search ticker (e.g. Apple)">
                    <datalist id="livesearch1"></datalist>
                </div>
                <!-- Button to start the calculation. Functionality is called in 'js/my.js' -->
                <button type="button" id="create_prediction" class="btn btn-primary remove-it">Get prediction</button>
            </div>
            </table>
        </div>
    </div>
</div>
<div class="col-md-12" id="prediction_id">
</div>