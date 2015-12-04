<!DOCTYPE html>
<html lang="en">

<head>

<?php 
ini_set('display_errors', 1);
error_reporting(~0);
	require 'Model/database.php';
	$stuArr = array();
	$stuGroup = array();
	session_start();
	if (!isset($_SESSION['login user'])) 
	{
		header("Location: /login.php");
	}
	else
	{
		print_r($_SESSION['login user']. " is logged in");
		$email = $_SESSION['login user'];
		$obj = new database();
		$stuArr = $obj->getStudent($email);
		$stuGroup = $obj->getGroup($stuArr['hotel']);
		$stuLoc = $obj-> getLocation($stuGroup['location']);
		//$str = implode(" ", $stuGroup);
		//print_r($stuGroup['name']);
		
	}
 ?>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Strategic Marketing</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/logo-nav.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<script type="text/javascript">

function redirect(site) {
	window.location = site
	exit;
}
</script>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
				<img src="/Images/fiu_logo_edit.png" alt=""> 
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <!-- <a class="navbar-brand" href="#">-->
                <!-- <img src="/Images/fiu_logo.png" alt="">    maybe try to make it longer.  let me try something ls to fit Find the image if you can and fix it wait  Let me get you the size--> 
					
               <!-- </a> -->
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#"="a" onclick ="redirect('index.php')"> Home</a>
                    </li>
                    <li>
                        <a href="#"="a" onclick ="redirect('metrics.php')">Metrics</a>
                    </li>
                    <li>
                         <a href="#"="a" onclick ="redirect('stratDecisions.php')">Strategic Decisions</a>
                    </li>
					<li>
						<a href="#"="a" onclick ="redirect('/admin/ManagePage.php')"> Manage</a>
                    </li>
                    <li>
                        <a href="#"="a" onclick ="redirect('news.php')">News</a>
                    </li>
                    <li>
                         <a href="#"="a" onclick ="redirect('login.php')">Login</a>
                    </li>
					
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                
                <!--<p>Note: You may need to adjust some CSS based on the size of your logo. The default logo size is 150x50 pixels.</p>-->
            </div>
			
    </div>
        </div>
		<h1 style = "color:blue" align="center">Strategic Marketing Simulator</h1> 
		
	<div class="bs-example"> 
    <div class="panel panel-default">
        <div class="panel-body"><h2> Scorecard </h2></div> 
        <div class="panel-footer clearfix"> <h4> Group : <?php echo $stuGroup['name'];  ?>  </h4>  <h4> Hotel Type : <?php echo $stuGroup['type'];  ?>  </h4>
		
		<h4> Location :  <?php echo $stuLoc['type'];  ?></h4><h4> Budget : $<?php $budget = $stuGroup['budget']; $budget = number_format($budget); echo $budget;   ?> </h4> <h4> Remaining budget : $<?php $balance = $stuGroup['balance']; $balance = number_format($balance); echo $balance; ?>  </h4>
            
			<form action="commit.php" method="post">
			<div class="pull-right">
                <input type="submit" align = 'right' name="commit" value = "Commit Decisions" class="btn btn-primary" />
            </div>
			
		
			</form>
        </div>
    </div>
	
	
</div>

<div class="bs-example2">
    <div class="panel panel-default">
        <div class="panel-body"><h2> Selected decisions </h2></div> 
        <div class="panel-footer clearfix"> <h4> Decision 1 :  </h4>  <h4> Decision 2 :  </h4>
		<h4> Decision 3 :  </h4><h4> Decision 4 :  </h4><h4> ---  </h4><h4> ---  </h4>
            <div class="pull-right">
                <a href="stratDecisions.php" class="btn btn-primary">Change decisions</a>
                
            </div>
        </div>
    </div>
	
	
</div>
	
	
	
	<div class="panel panel-default">
    <div class="panel-heading"><h2>Leaderboard</h2></div>
    <div class="panel-body">
        <p>See how the other hotels are doing!</p>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hotel</th>
                    <th>Type</th>
                    <th>Location</th>
					<th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Test</td>
                    <td>Test</td>
                    <td>Test</td>
					<td>Test</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
	
	
	
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<script>

</script>

</body>

</html>
