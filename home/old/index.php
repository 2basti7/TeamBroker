<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="css/my.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div id="wrapper">
         <!-- Navigation Up -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle    navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                   <a href="#menu-toggle" class="navbar-brand fa fa-bar-chart fa-2x" id="menu-toggle"> TeamBrocker</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a class="glyphicon glyphicon-cog" href="#"></a>
                        </li>
                        <li>
                            <a class="glyphicon glyphicon-blackboard" href="#"></a>
                        </li>
                        <li>
                            <a class="glyphicon glyphicon-stats" href="#"></a>
                        </li>
                        <li>
                            <a class="glyphicon glyphicon-heart-empty" href="#"></a>
                        </li>
                    </ul>
                        
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li>
                    <a class="fa fa-signal fa-2x" aria-hidden="true" href="#"> Dashboard</a>
                </li>
                <li>
                    <a class="fa fa-share-alt fa-2x" href="#"> Tickers</a>
                </li>
                <li>
                    <a class="fa fa-heartbeat fa-2x"href="#"> Favorite</a> 
                </li>
                <li>
                    <a href="#">Events</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
        <!-- second navbar -->
        <nav class="navbar navbar-default navbar-lower" role="navigation">
          <div class="container 2ndbar">
            <div class="collapse navbar-collapse">
              <div class="row">
<!--                   <button class="btn btn-success highticker">APPLE</button>
                  bbbbbbbbbbbbbbbbb
                  <button class="btn btn-success highticker">Microsoft</button>
                  bbbbbbbbbbbbbbbbb
                  <button class="btn btn-danger lowticker">BVB</button>
                  bbbbbbbbbbbbbbbbb
                  <button class="btn btn-danger lowticker">GM</button>
                  bbbbbbbbbbbbbbbbb -->

                </div>
            </div>
          </div>
        </nav>


        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Line charts are great!</h1>
                        <?php 
                        include 'phpchart.php';
                         ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
