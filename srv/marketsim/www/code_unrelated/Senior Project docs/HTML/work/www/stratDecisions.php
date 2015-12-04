<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<?php 

/*
Created by Jeffrey Carman
To items: 		update database for advertising with costs and impact
				update database with marketing personnel
				Update database for OTA allocations
				set remaining budget jquery 
				setup advertising check box tally
				
				
*/
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
		print_r($_SESSION['login user']. " is not you? login here "); 
		echo " <a href='/login.php'>login</a>";
		
		
		
		
		$email = $_SESSION['login user'];
		$obj = new database();
		$stuArr = $obj->getStudent($email);
		$stuGroup = $obj->getGroup($stuArr['hotel']);
		$allGroup = $obj-> getGroupsforGame($stuGroup['game']);
		$stuLoc = $obj-> getLocation($stuGroup['location']);
		
		/*
		advertising block - admin manage page to change values in database
		
		*/
		$advert = $obj->getAdvertising();
		$dir_mark = $advert[0]['cost'];
		$pub_rel = $advert[1]['cost'];
		$print = $advert[2]['cost'];
		$billBoard = $advert[3]['cost'];
		$faceBook = $advert[4]['cost'];
		$google = $advert[5]['cost'];
		$radio = $advert[6]['cost'];
		$tv = $advert[7]['cost'];
		$promo = $advert[8]['cost'];
		$eMarketing = $advert[8]['cost'];
		$cityBus = $advert[9]['cost'];
		
		
		
		
		
		$dir_mark = number_format($dir_mark); 
		$pub_rel = number_format($pub_rel); 
		$print = 	number_format($print); 
		$billBoard  = number_format($billBoard); 
		$faceBook = number_format($faceBook); 
		$google = number_format($google); 
		$radio = number_format($radio); 
		$tv = number_format($tv); 
		$promo = number_format($promo); 
		$eMarketing = number_format($eMarketing); 
		$cityBus = number_format($cityBus); 
		
		
		
		
		
		$studentGroup = $stuGroup['name']; // used for check on Market Research so ones own group isn't displayed
		$groupBal  = $stuGroup['balance']; 
		$groupBal = number_format($groupBal);  
		
		
		
		
		
		//$str = implode(" ", $stuGroup);
		//print_r($stuGroup['name']);
		
	}
 ?>


<head>



    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Strategic Decisions</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	 <link href="css/grid.css" rel="stylesheet">

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
                <!-- class="navbar-brand" href="#">
                    <img src="/Images/FIU logo.jpg" alt="">  
					
                </a-->
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
                        <a href="#"="a" onclick ="redirect('manage.php')"> Manage</a>
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
		<h2 style = "color:green" align="center">$<?php echo $groupBal; ?></h2> 
	
	<div class="container-fluid">
		<div class="row">
		<form role= 'form' method = 'post'>
		
		<!--  insert php if statement here to add disabled once group already selects market sector-->
			<div class="col-sm-2" style=""><h3> Market Segment</h3>
				 <div class="radio">
      <label><input type="radio" name="optradio">Economic Hotel</label>
    </div>
    <div class="radio">
      <label><input type="radio" name="optradio">Midrange Hotel</label>
    </div>
    <div class="radio"> <!-- radio disabled here for red cirlce with line-->
      <label><input type="radio" name="optradio" >Luxury Hotel</label>  <!-- add radio disabled here to gray out -->
    </div>
			</div>
    	
			<div class="col-sm-2" style=""><h3>Average Daily Rate</h3>
			    <br /><label for="roomPrice">Room price :</label>
				<input type="text" name = "roomPR" class="form-control" id="roomPrice">
			</div>
			
			<div class="col-sm-2" style=""><h3>Advertising</h3>
			<p> Minimum of 3, no max<p>
				<div class="checkbox">
					<label><input name ="dirMarket"  type="checkbox" value="">Direct Marketing $<?php echo $dir_mark; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "publicRel" type="checkbox" value="">Public Relations Firm $<?php echo $pub_rel; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "PrintAdv" type="checkbox" value="">Print Advertising $<?php echo $print; ?></label>
				</div>
				<div class="checkbox">
					<label><input name ="billBoard"  type="checkbox" value="">Billboards $<?php echo $billBoard; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "FacebookAds" type="checkbox" value="">Facebook Ads $<?php echo $faceBook; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "googleAds" type="checkbox" value="">Google Ads $<?php echo $google; ?></label>
				</div>
				<div class="checkbox">
					<label><input name ="RadioSpto"  type="checkbox" value="">Radio Spot $<?php echo $radio; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "TVSpot" type="checkbox" value="">TV Spot $<?php echo $tv; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "promoGifts" type="checkbox" value="">Promotional Gifts $<?php echo $promo; ?></label>
				</div>
				<div class="checkbox">
					<label><input name ="eMarket"  type="checkbox" value="">eMarketing $<?php echo $eMarketing; ?></label>
				</div>
				<div class="checkbox">
					 <label><input name = "CityBus" type="checkbox" value="">City Bus ads $<?php echo $cityBus; ?></label>
				</div>
			</div>
			<div class="col-sm-2" style=""><h3>Marketing Personnel</h3>
				<h5>Select the number of personnel you want<h5>
				<br />
				<label for="EntryLev">Entry Level $3,000 :</label>
					<input type="text" name = "entry" placeholder = "2 = $6,000" class="form-control" id="EntryLev">
					<br /><label for="ManTrain">Manager in Traning $5,000 :</label>
					<input type="text" name = "training" placeholder = "0 = $0" class="form-control" id="ManTrain">
					<br /><label for="ExpProf">Manager in Traning $5,000 :</label>
					<input type="text" name = "professional" placeholder = "1 = $5,000" class="form-control" id="ExpProf">
			</div>
		
			<div class="col-sm-2" style=""><h3>OTA Allocations</h3>
				<br />
				<label for="AllAto"># of Rooms :</label>
				<input type="text" name = "ATOs" placeholder = "10" class="form-control" id="AllAto">
			
			
			</div>
    
	
	
	
			<div class="col-sm-2" style=""><h3>Market Research</h3>
	
	<?php		
				foreach($allGroup as $group) {
					
					
								if($group['name'] != $studentGroup) {?>
				
	
				<div class="checkbox">
					<label><input name ="<?php echo $group['id'];?>" type="checkbox" value=""><?php echo $group['name']; ?></label>
				</div>
				
				<?php }}?>
	
	
	</div>
	
	
  </div>
				<div class="pull-right">
                <input type="submit" align = 'right' name="commit" value = "Select decisions" class="btn btn-primary" />
				</div>

				
				</form>
				</div>
	
	
	
	
	
	
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
