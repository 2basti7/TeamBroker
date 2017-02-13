// jquery ajax post call for php file with function for calculation of cross correlation


$(document).ready(function () {

    $('#highLowValues').insertBefore($('#tableWithValues'));

    $("[rel=tooltip]").tooltip({placement: 'bottom'});

    $('#button_table_legend').click(function () {
        $('#table_legend').show();
    });

    $('#create_table_button').click(function () {


        var ticker1 = $('#search_ticker1').val();
        var ticker2 = $('#search_ticker2').val();
        var calculation_type = $('#calculation_type').val();
        var startDate = $('#startDate').val();
        var lag_value = $('#lag_value').val();
        var lengthOfPeriod = $('#lengthOfPeriod').val();
        var timeFrame = $('#timeFrame').val();

        if (ticker1 !== "" && ticker2 !== "" && startDate !== "" && lengthOfPeriod !== "" && timeFrame !== "") {
            this.disabled = true;
            this.innerHTML = '<x class="fa fa-spinner fa-spin remove-it"></x> Calculating ...';
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

    $('#calc_one_against_all').click(function () {
        var ticker1 = $('#search_ticker').val();

        var startDate = $('#startDate').val();
        var lengthOfPeriod = $('#lengthOfPeriod').val();
        var lag_value = $('#lag_value').val();
        var timeFrame = $('#timeFrame').val();
        var calculation_type = $('#calculation_type').val();
        if (ticker1 !== "" && startDate !== "" && lengthOfPeriod !== "" && timeFrame !== "") {
            this.disabled = true;
            this.innerHTML = '<x class="fa fa-spinner fa-spin remove-it"></x> Calculating ...';

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
            }).done(function (table_content) {
                $('#div_for_table').empty().append(table_content);

                $('#calc_one_against_all').prop('disabled', false).text('Calculate');

                $('.addTooltip').tooltip();
            });
        } else {
            alert("Please fill in all fields!");
        }

    });


    $('#insert_new_ticker').click(function () {

        var ticker = $('#ticker').val();
        var company = $('#company').val();
        var exchange = $('#exchange').val();
        var country = $('#country').val();
        var marketCap = $('#marketCap').val();
        var ipoYear = $('#ipoYear').val();
        var category = $('#category').val();
        var infoLink = $('#link').val();
        if (ticker !== "") {
            $.ajax({
                type: 'POST',
                url: "db/InsertNewTicker.php",
                data: {
                    ticker: ticker, company: company, exchange: exchange, country: country,
                    marketCap: marketCap, ipoYear: ipoYear, category: category, infoLink: infoLink
                }
            }).done(function (table_content) {
                $('#insert_ticker_result').append(table_content);
                $('#insert_new_ticker').prop("disabled", true);
            });
        } else {
            alert("You have to specify a ticker!!");
        }

    });

    //create prediction
    $('#create_prediction').click(function () {

        var ticker1 = $('#search_ticker').val();

        if (ticker1 !== "") {
            this.disabled = true;
            this.innerHTML = '<x class="fa fa-spinner fa-spin remove-it"></x> Calculating ...';

            $('#prediction_id').html("");
            this.disabled = true;
            $.ajax({
                type: 'POST',
                url: "calculations/predictions.php",
                data: {ticker1: ticker1}
            }).done(function (data) {
                $('#test').html("Live data prediction for " + ticker1 + "<br>");
                $('#prediction_id').empty().append(data);
                $('#create_prediction').prop('disabled', false).text('Get prediction');
            });
        } else {
            alert("You have to specify a ticker!");
        }
    });

    $('#prediction').click(function () {

        var ticker_prediction = $('#ticker_prediction').val();
        var days_back = $('#days_back').val();
        var ticker_prediction_n = $('#ticker_prediction_n').val();

        if (ticker_prediction !== "" && days_back !== "" && ticker_prediction_n !== "") {
            this.disabled = true;
            this.innerHTML = '<x class="fa fa-spinner fa-spin remove-it"></x> Calculating ...';
            $.ajax({
                type: 'POST',
                url: "calculations/predictionForOne.php",
                data: {
                    ticker_prediction: ticker_prediction,
                    days_back: days_back,
                    ticker_prediction_n: ticker_prediction_n
                }
            }).done(function (table_content) {
                $('#div_for_prediction').empty().append(table_content);
                $('#prediction').prop('disabled', false).text('Prediction');
            });
        } else {
            alert("Please fill in all fields!");
        }


    });

    /*$('a[href*=#]:not([href=#])').click(function() {
     if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname) {
     var target = $(this.hash);
     target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
     if (target.length) {
     $('html,body').animate({
     scrollTop: target.offset().top
     }, 1);
     return false;
     }
     }
     });*/

    $('.iphone-toggle').on('change', function () {
        var toggle_data = $(this).data('no-uniform')
        toggle_value = $(this).val();

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

        $.ajax({
            type: "POST",
            url: 'charts/compareTwoTickerChart.php',
            data: {
                toggle: toggle_data, value: toggle_value, ticker1: ticker1, ticker2: ticker2, date: date, delay: delay,
                days: days, change: change, calculation_type: calculation_type, company: company
            }
        }).done(function (table_content) {
            $('#chart').empty().append(table_content);
            $('#prediction').prop('disabled', false).text('Prediction');
        });
    });
});

// function for toggling the button event (alex)
function toggler(divId) {
    $("#" + divId).toggle();
}
