<?php
/*Script for inserting a new ticker with all informations into database and updating historical data*/
require_once 'Connect.php';
$con = new Connect();

/*Values that are neccesarry to insert into database*/
$conn = $con->con();
$ticker = $_POST["ticker"];
$company = $_POST["company"];
$exchange = $_POST["exchange"];
$country = $_POST["country"];
$marketCap = $_POST["marketCap"];
$ipoYear = $_POST["ipoYear"];
$link = $_POST["infoLink"];
$category = $_POST["category"];

/*Try to insert ticker into database and get data from yahoo*/
if (testIfTickerExistingInDatabase()) {
    echo '<div class="alert alert-danger">Sorry, ticker already existing!</div>';
} else {
    if (testIfTickerExistingAtYahoo()) {
        if (insertIntoTickerInfoDB()) {
            echo "<div class='alert alert-success'><strong>Inserted ticker!</strong> You are now able to use your new ticker!</div><br>";
        } else {
            echo "<label>Tickerinfo insert failed!</label><br>";
        }
    } else {
        echo "<div class='alert alert-danger'><strong>Tickerdata not inserted.</strong> Ticker not existing in Yahoo finance database!</div><br>";
    }
}

/*
*test if ticker is already existing in database
*@Return true if already existing in database, false if not existing
*/
function testIfTickerExistingInDatabase()
{
    global $conn;
    global $ticker;
    $sql = "SELECT * FROM dbo.table_tickerInfo WHERE TICKER = '$ticker'";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt) {
        $rows = sqlsrv_has_rows($stmt);
        if ($rows === true) {
            return true;
        } else {
            return false;
        }
    }
}

/*
*Getting maxdate from database to know until which date to insert the historical data
*@Return maxdate from database
*/
function selectMaxDate()
{
    global $conn;
    $sql = "SELECT convert(varchar, MAX(DATE), 120) FROM dbo.table_historical";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt) {
        $rows = sqlsrv_has_rows($stmt);
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $date = $row[""];
        return $date;
    }
}

/*
*tests if ticker is existing at the yahoo database
*if it exists, table_historical will be updated for new ticker
*@Return false if ticker is not existing, true if ticker is existing
*/
function testIfTickerExistingAtYahoo()
{

    $maxDate = selectMaxDate();
    $date = DateTime::createFromFormat("Y-m-d", $maxDate);
    $month = $date->format('m');
    $year = $date->format('Y');
    $day = $date->format('d');
    if ($month == 00) {
        $month = 11;
    } else {
        $month = $month - 1;
    }

    global $ticker;
    global $conn;
    $url = "http://ichart.finance.yahoo.com/table.csv?s=" . $ticker . "&a=00&b=01&c=2015&d=" . ($month) . "&e=" . $day . "&f=" . $year . "&g=d&ignore=.csv";
    if (testUrl($url) == 200) {
        //echo "Existing at yahoo";
        $file = fopen($url, "r");
        $csvAsArray = reverseCsv($file);
        $oldclose = 00.000000;
        foreach ($csvAsArray as $value) {
            if ($value == FALSE) {
                echo("error in currentRow; ticker: " . $ticker . " <br/>");
            } else if (sizeof($value) == 7) {
                $date = $value[0];
                $open = $value[1];
                $high = $value[2];
                $low = $value[3];
                $close = $value[4];
                $volume = $value[5];
                $change = $close - $oldclose;
                $change = $change / $close;
                $change = $change * 100;

                $insert = "INSERT INTO dbo.table_historical(Ticker, Date, OpenCourse, High, Low, CloseCourse, Volume, Change) VALUES('" . $ticker . "', '" . $date . "', '" . $open . "', '" . $high . "', '" . $low . "', '" . $close . "', '" . $volume . "', '" . $change . "')";
                $query = sqlsrv_query($conn, $insert);
                if ($query == FALSE)
                    var_dump(sqlsrv_errors());
                sqlsrv_free_stmt($query);
                $oldclose = $close;
            } else {
                //echo("wrong size <br/>");
                //echo("size is: ".sizeof($dataCurrentRow)."<br/>");
            }
        }
        fclose($file);
        return true;
    } else {
        //echo("could not load file from url <br/>");
        return false;
    }
}

function testUrl($url)
{
    $header = get_headers($url);
    return substr($header[0], 9, 3);
}

function reverseCsv($file)
{
    $rows = array();
    fgetcsv($file);
    while (($data = fgetcsv($file)) != FALSE) {
        array_push($rows, $data);
    }
    return array_reverse($rows);
}

/*
*insert tickerinfo into table_tickerInfo
*/
function insertIntoTickerInfoDB()
{
    global $conn;
    global $ticker;
    global $company;
    global $exchange;
    global $country;
    global $marketCap;
    global $ipoYear;
    global $link;
    global $category;
    $insert = "INSERT INTO dbo.table_tickerInfo(Ticker, Exchange, Country, Company, MarketCapacity, IPOYear, Link, Category) VALUES
				('" . $ticker . "', '" . $exchange . "', '" . $country . "', '" . $company . "', '" . $marketCap . "', '" . $ipoYear . "', '" . $link . "', '" . $category . "')";
    $query = sqlsrv_query($conn, $insert);
    if ($query == FALSE)
        return false;
    sqlsrv_free_stmt($query);
    return true;
}

?>