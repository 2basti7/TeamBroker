<?php
require('db/Select.php');

session_start();
//unset($_SESSION['favourites']);
if (!isset($_SESSION['favourites'])) {
    $fav = array();
    $_SESSION['favourites'] = $fav;
}
//unset($_SESSION['favouriteCalculations']);
if (!isset($_SESSION['favouriteCalculations'])) {
    $fav = array();
    $_SESSION['favouriteCalculations'] = $fav;
}

$select = new Select();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Team Broker - Stock data analysis</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">


    <!-- Please put all your self defined classes and id's in this file -->
    <link href="css/custom-css.css" rel="stylesheet">


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- file for custom javascript functions -->
    <script src="js/my.js"></script>

    <!-- file for search algorithm functions -->
    <script src="js/DBsearch.js"></script>

    <!-- Chart.js -->
    <script type="text/javascript" src="js/Chart.min.js"></script>


</head>

<body>
<div class="container">
    <div class="row">
        <div class="wrapper">

            <!-- start side bar div-->
            <div class="side-bar">
                <ul>
                    <!-- start menu div: put here all other sites in a list element -->
                    <div class="menu" style="margin-top: 40px;">

                        <!-- getting started -->
                        <li>
                            <a href="index.php?action=gettingStarted">Getting started<span
                                        class="fa fa-play pull-right"></span></a>
                        </li>

                        <!-- find a ticker -->
                        <li>
                            <a href="index.php?action=searchTicker">Find Ticker<span
                                        class="glyphicon glyphicon-search pull-right"></span></a>
                        </li>

                        <!-- insert new ticker -->
                        <li>
                            <a href="index.php?action=insertNewTicker">Insert new Ticker<span
                                        class="glyphicon glyphicon-plus pull-right"></span></a>
                        </li>

                        <!-- collapsable dropdown for calculation sites -->
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01"
                               class="collapsed">Calculation <span class="caret"></span>
                                <span class="fa fa-calculator pull-right"></span></a>
                            </a>
                            <div class="collapse" id="toggleDemo">
                                <ul class="nav nav-list">
                                    <li><a href="index.php?action=compareTwoTickers">Compare two tickers</a></li>
                                    <li><a href="index.php?action=oneAgainstAll">Compare one ticker against all</a></li>
                                    <li><a href="index.php?action=liveData">Live Data</a></li>
                                    <!--<li><a href="index.php?action=predictionForOneTicker">Get prediction for one ticker</a></li>-->
                                </ul>
                            </div>
                        </li>


                    </div>

                </ul>
            </div>
            <!-- end side bar div -->

            <!-- start content div -->
            <div class="content">

                <!-- navbar top -->
                <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                    <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                    data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle    navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a style="color:#fff; margin-top: 12px;" href="index.php?action=home"
                                       class="fa fa-2x"><img src="images/222.png" width="30px" height="27px"
                                                             style="position: relative; top: -3px;"> Team Broker</a>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a style="color:#fff; margin-top: 12px;" class="glyphicon glyphicon-home"
                                       href="index.php?action=home"></a>
                                </li>
                                <li>
                                    <a style="color:#fff; margin-top: 12px;" class="fa fa-users pull-right"
                                       href="index.php?action=aboutUs"></a>
                                </li>
                                <li>
                                    <a style="color:#fff; margin-top: 12px;" class="glyphicon glyphicon-heart-empty"
                                       href="index.php?action=favourites"></a>
                                </li>
                            </ul>

                        </div>
                        <!-- /.navbar-collapse -->
                    </div>
                    <!-- /.container -->
                </nav>
                <!-- end navbar top -->

                <?php
                // get page content
                if (!empty($_GET['action'])) {
                    $action = $_GET['action'];
                    $action = basename($action);
                    if (glob("content/$action.php")) {
                        include("content/$action.php");
                    } else {
                        include("content/error.html");
                    }

                } else {
                    include("content/home.php");
                }
                ?>
                <!--<button class = "btn" style = "position: fixed; right: 15px; bottom: 15px; width">-->
                <a id="#fixed-button" href="#" class="btn btn-dark btn-lg"
                   style="position: fixed; right: 15px; bottom: 15px;"><i class="fa fa-chevron-up fa-fw fa-1x"></i></a>
                <!--</button>-->
            </div>


            <!-- end content div -->
        </div>
    </div>

</div>

</body>
</html>
