/* custom javascript file with a few functions to handle ajax calls and update some additional properties of html tags */

// execute javascript functions when DOM is ready/loaded
$(document).ready(function () {


    // replace small table in front of bigger table in CallTwoTickerCrossCorr.php
    $('#highLowValues').insertBefore($('#tableWithValues'));

    // activate bootstrap tooltips
    $("[rel=tooltip]").tooltip({placement: 'bottom'});

    // start calculation of CompareTwoTickers
    $('#create_table_button').click(function () {


        // fetch all necessary parameters
        var ticker1 = $('#search_ticker1').val();
        var ticker2 = $('#search_ticker2').val();
        var calculation_type = $('#calculation_type').val();
        var startDate = $('#startDate').val();
        var lag_value = $('#lag_value').val();
        var lengthOfPeriod = $('#lengthOfPeriod').val();
        var timeFrame = $('#timeFrame').val();

        // only send request if all mandatory parameters are selected
        if (ticker1 !== "" && ticker2 !== "" && startDate !== "" && lengthOfPeriod !== "" && timeFrame !== "") {
            this.disabled = true;
            this.innerHTML = '<x class="fa fa-spinner fa-spin remove-it"></x> Calculating ...';

            // send ajax post request with parameters to CallTwoTickerCrossCorr.php
            $.ajax({
                type: 'POST',
                url: "calculations/callTwoTickerCrossCorr.php",
                data: {
                    ticker1: ticker1,
                    ticker2: ticker2,
                    startDate: startDate,
                    lengthOfPeriod: lengthOfPeriod,
                    lag: lag_value,
                    timeFrame: timeFrame,
                    calculation_type: calculation_type
                }
                // append result of calculation in specified div
            }).done(function (table_content) {
                $('#inputValuesDiv').remove();
                $('#resultingTableDiv').show();
                $('#div_for_table').append(table_content);

                $('#highLowValues').insertBefore($('#tableWithValues'));

                $('x').remove('.remove-it');
                $('#create_table_button').prop('disabled', false).text('Calculate');

                $('.addTooltip').tooltip();
            });
        } else {
            alert("Please fill in all fields!");
        }
    });


    // start calculation of OneTickerAgainstAll
    $('#calc_one_against_all').click(function () {

        // fetch all necessary parameters
        var ticker1 = $('#search_ticker').val();
        var startDate = $('#startDate').val();
        var lengthOfPeriod = $('#lengthOfPeriod').val();
        var lag_value = $('#lag_value').val();
        var timeFrame = $('#timeFrame').val();
        var calculation_type = $('#calculation_type').val();

        // only send request if all mandatory parameters are selected
        if (ticker1 !== "" && startDate !== "" && lengthOfPeriod !== "" && timeFrame !== "") {
            this.disabled = true;
            this.innerHTML = '<x class="fa fa-spinner fa-spin remove-it"></x> Calculating ...';

            // send ajax post request with parameters to CalculateOneToAll.php
            $.ajax({
                type: 'POST',
                url: "calculations/calculateOneToAll.php",
                data: {
                    ticker1: ticker1,
                    startDate: startDate,
                    lengthOfPeriod: lengthOfPeriod,
                    lag: lag_value,
                    timeFrame: timeFrame,
                    calculation_type: calculation_type
                }
                // append result of calculation in specified div
            }).done(function (table_content) {
                $('#div_for_table').empty().append(table_content);

                $('#calc_one_against_all').prop('disabled', false).text('Calculate');

                $('.addTooltip').tooltip();
            });
        } else {
            alert("Please fill in all fields!");
        }

    });


    // function to insert a new ticker
    $('#insert_new_ticker').click(function () {

        // fetch all necessary parameters
        var ticker = $('#ticker').val();
        var company = $('#company').val();
        var exchange = $('#exchange').val();
        var country = $('#country').val();
        var marketCap = $('#marketCap').val();
        var ipoYear = $('#ipoYear').val();
        var category = $('#category').val();
        var infoLink = $('#link').val();

        // ticker is a mandatory field
        if (ticker !== "") {

            // send ajax post request with parameters to InsertNewTicker.php
            $.ajax({
                type: 'POST',
                url: "db/InsertNewTicker.php",
                data: {
                    ticker: ticker, company: company, exchange: exchange, country: country,
                    marketCap: marketCap, ipoYear: ipoYear, category: category, infoLink: infoLink
                }
                // append result of calculation in specified div
            }).done(function (result) {
                $('#insert_ticker_result').append(result);
                $('#insert_new_ticker').prop("disabled", true);
            });
        } else {
            alert("You have to specify a ticker!!");
        }

    });


    // start calculation to get a prediction
    $('#create_prediction').click(function () {

        // fetch all necessary parameters
        var ticker1 = $('#search_ticker').val();

        // ticker is a mandatory field
        if (ticker1 !== "") {
            this.disabled = true;
            this.innerHTML = '<x class="fa fa-spinner fa-spin remove-it"></x> Calculating ...';

            $('#prediction_id').html("");
            this.disabled = true;

            // send ajax post request with parameters to Predictions.php
            $.ajax({
                type: 'POST',
                url: "calculations/predictions.php",
                data: {ticker1: ticker1}
                // append result of calculation in specified div
            }).done(function (data) {
                $('#test').html("Live data prediction for " + ticker1 + "<br>");
                $('#prediction_id').empty().append(data);
                $('#create_prediction').prop('disabled', false).text('Get prediction');
            });
        } else {
            alert("You have to specify a ticker!");
        }
    });

    // iphone function to calculate the cross correlation between two tickers
    $('.iphone-toggle').on('change', function () {
        var toggle_data = $(this).data('no-uniform')
        toggle_value = $(this).val();

        // fetch all necessary parameters
        var ticker1 = $('#ticker1').val();
        var ticker2 = $('#ticker2').val();
        var date = $('#date').val();
        var delay = $('#delay').val();
        var days = $('#days').val();
        var company = $('#company').val();
        var change = "true";
        if (this.checked) {
            var calculation_type = true;
        } else {
            var calculation_type = false;
        }

        // send ajax post request with parameters to CompareTwoTickerChart.php
        $.ajax({
            type: "POST",
            url: 'charts/compareTwoTickerChart.php',
            data: {
                toggle: toggle_data, value: toggle_value, ticker1: ticker1, ticker2: ticker2, date: date, delay: delay,
                days: days, change: change, calculation_type: calculation_type, company: company
            }
            // append result of calculation in specified div
        }).done(function (table_content) {
            $('#chart').empty().append(table_content);
            $('#prediction').prop('disabled', false).text('Prediction');
        });
    });
});
