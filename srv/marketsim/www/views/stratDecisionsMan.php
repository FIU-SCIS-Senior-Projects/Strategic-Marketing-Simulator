<!DOCTYPE html>

<html lang="en">





<?php 
ini_set('memory_limit', '-1');
/*
Created by Jeffrey Carman
To items: 		Update database with new values for strategic decisions
				
				
*/


ini_set('display_errors', 1);
error_reporting(~0);
	require '../Model/database.php';
	$stuArr = array();
	$stuGroup = array();
	session_start();
	if (!isset($_SESSION['admin login'])) 
	{
		header("Location: /views/login.php");
	}

	//else
	//{
		echo "<div style = 'text-align: right; padding-right: 15px'>".$_SESSION['admin login'] . " is not you? login 
			<a href='/login.php'> here</a>
		</div>";
		
		
		
		
		
		//$email = $_SESSION['login user'];
		$obj = new database();
	//	$stuArr = $obj->getStudent($email);
	//	$stuGroup = $obj->getGroup($stuArr['hotel']);
		
		
		
	//	$groupType = $stuGroup['type'];
	//	$gameNum = $stuGroup['game'];
		
		
		
	//	$allGroup = $obj-> getGroupsforGame($stuGroup['game']);
	//	$stuLoc = $obj-> getLocation($stuGroup['location']);
		
		$personnel = $obj->getPersonnel();
		
		$reSearch = $obj->getResearch();
		
		$ota = $obj->getOTA();
		
		
		
		
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
		
		
		$dir_markI = $advert[0]['impact'];
		$pub_relI = $advert[1]['impact'];
		$printI = $advert[2]['impact'];
		$billBoardI = $advert[3]['impact'];
		$faceBookI = $advert[4]['impact'];
		$googleI = $advert[5]['impact'];
		$radioI = $advert[6]['impact'];
		$tvI = $advert[7]['impact'];
		$promoI = $advert[8]['impact'];
		$eMarketingI = $advert[8]['impact'];
		$cityBusI = $advert[9]['impact'];
		
		
		$entryLev = $personnel[0]['cost'];
		$manTrain = $personnel[1]['cost'];
		$expProf = $personnel[2]['cost'];
		
		
		$entryLevI = $personnel[0]['impact'];
		$manTrainI = $personnel[1]['impact'];
		$expProfI = $personnel[2]['impact'];
		
		
		
		$research = $reSearch[0]['cost'];
		
		
		
		
		
		/*$dir_mark = number_format($dir_mark); 
		$pub_rel = number_format($pub_rel); 
		$print = 	number_format($print); 
		$billBoard  = number_format($billBoard); 
		$faceBook = number_format($faceBook); 
		$google = number_format($google); 
		$radio = number_format($radio); 
		$tv = number_format($tv); 
		$promo = number_format($promo); 
		$eMarketing = number_format($eMarketing); 
		$cityBus = number_format($cityBus); */
		
		
		
		
		
		//$studentGroup = $stuGroup['name']; // used for check on Market Research so ones own group isn't displayed
	//	$groupBal  = $stuGroup['balance']; 
		//$groupBal = number_format($groupBal);  
		
		
		if(isset($_POST['commit']))
		{
			$obj2 = new database();
			
			if(isset($_POST['ATOs']))
			{
				$rr = $obj2->updateOTA($_POST['ATOs']);		
			
			}
			
			if(isset($_POST['research']))
			{
				$tt = $obj2->updateAdvPerOrResearch('research', 1, $_POST['research'], 'NULL');
				//print_r($tt);
				//unset($_POST);
			}
			var_dump($_POST);
			if(isset($_POST['decisionsImpArr']))
			{
				$decs = $_POST['decisionsImpArr'];
				$ct = 1;
				
					foreach($decs as $d)
					{
					//print_r(" this is d : " . $d. "and thid is ct : " . $ct . " ");
						$r = $obj2->updateAdvPerOrResearch('advertising', $ct, 'NULL', $d);
						$ct++;
						//print($r);
						if($ct%3==0)
						{
							echo "<br/>";
						}
				//header("Location: stratDecisionsMan.php");
					}
			}	
				
			if(isset($_POST['decisionsCostArr']))
			{
					
				$cnt = 1;
				$Dcost = $_POST['decisionsCostArr'];
				foreach($Dcost as $p)
				{
					$k = $obj2->updateAdvPerOrResearch('advertising', $cnt, $p, 'NULL');
					$cnt++;
					//print($cnt);
					//print($k);
					if($cnt%3==0)
					{
						echo "<br/>";
					}
				}
				
			}
			

			

			if(isset($_POST['perImp']))
			{
				$pimp = $_POST['perImp'];
				$ct = 1;
				
					foreach($pimp as $d)
					{
					//print_r(" this is d : " . $d. "and thid is ct : " . $ct . " ");
						$r = $obj2->updateAdvPerOrResearch('personnel', $ct, 'NULL', $d);
						$ct++;
						//print($r);
						if($ct%3==0)
						{
							echo "<br/>";
						}
				//header("Location: stratDecisionsMan.php");
					}
			}	
				
			if(isset($_POST['perCost']))
			{
					
				$cnt = 1;
				$pCost = $_POST['perCost'];
				foreach($pCost as $p)
				{
					$k = $obj2->updateAdvPerOrResearch('personnel', $cnt, $p, 'NULL');
					$cnt++;
					//print($cnt);
					//print($k);
					if($cnt%3==0)
					{
						echo "<br/>";
					}
				}
				
			
			}
			
			
			//unset($_POST);
				
			
			
			
				header("Location: ManagePage.php");
		
		}
		
	//}
 ?>


<head>



    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Strategic Decisions</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/grid.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/logo-nav.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	
	
	
	
	<script type="text/javascript">
	
	

function redirect(site) {
	window.location = site
	exit;
	} 
	////// Research checkboxes
	function getResearch(id, res)
	
	{
		if($("#" + id).is(':checked'))
		{
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$" +(y - res) ).css('color','green');
			//alert(id + " is checked");
		}
		else 
		{
			
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$" + (y + res)).css('color','green') ;
			//alert(id + " is not checked");
	
		}
		
		
	}
	
	

</script>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
        <div class="container" >
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
                        <a href="#"="a" onclick ="redirect('../index.php')"> Home</a>
                    </li>
                 
                    <li>
                         <a href="/views/stratDecisions.php"="a" onclick ="redirect('stratDecisions.php')">Strategic Decisions</a>
                    </li>
				
                    <li>
                        <a href="/views/News.php"="a" onclick ="redirect('News.php')">News</a>
                    </li>
					<li>
                         <a href="/views/reportingPage.php"="a" onclick ="redirect('reportingPage.php')">Reporting</a>
                    </li>
					<li>
                         <a href="/views/accountManage.php"="a" onclick ="redirect('accountManage.php')">My Account</a>
                    </li>					
                    <li>
                         <a href="/views/signout.php"="a" onclick ="redirect('signout.php')">Sign Out</a>
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
		<h1 style = "color:blue" align="center">Manage Strategic decisions</h1> 
		
	
	<div class="container-fluid" style="padding-left:100px; padding-right:100px">
		<div class="row">
		<form role= 'form' method = 'post'>
		
		
			
			
			<div class="col-sm-3" style="" method = "post"><h3>Advertising</h3>
			<p>Change the cost and impact<p>
			
			
				<div class="textbox">
					<label>Direct Marketing : &nbsp<input name ="decisionsCostArr[]" align ="" id = "dirMarkID" type="textbox" size="4" required value="<?php echo $dir_mark; ?>" >
					<input method= "post" name ="decisionsImpArr[]" align ="right" id = "" type="textbox" size="4" value="<?php echo $dir_markI; ?> "required></label>
				</div>
				<div class="textbox">
					<label>Public Relations Firm : &nbsp<input name = "decisionsCostArr[]" id = "publicRel" type="textbox" size="4" required value="<?php echo $pub_rel; ?>">
					<input name ="decisionsImpArr[]" align ="right" id = "" type="textbox" size="4" value="<?php echo $pub_relI; ?>" required></label>
				</div>
				<div class="textbox">
					<label>Print Advertising :&nbsp<input name = "decisionsCostArr[]" id ="PrintAdv" required  type="textbox" size="4" value="<?php echo $print; ?>">
					<input name ="decisionsImpArr[]" align ="right" id = "" type="textbox" size="4" value="<?php echo $printI; ?>" required></label>
				</div>
				<div class="textbox">
					<label>Billboards : &nbsp<input name ="decisionsCostArr[]" id = "billBoard" required type="textbox" size="4" value="<?php echo $billBoard; ?>">
					<input name ="decisionsImpArr[]" align ="right" id = "" type="textbox" size="4" value="<?php echo $billBoardI; ?>" required></label>
				</div>
				<div class="textbox">
					<label>Facebook Ads : &nbsp<input name = "decisionsCostArr[]" id = "FacebookAds" required size="4" type="textbox" value="<?php echo $faceBook; ?>">
					<input name ="decisionsImpArr[]" align ="right" id = "" type="textbox" size="4" value="<?php echo $faceBookI; ?>" required></label>
				</div>
				<div class="textbox">
					<label>Google Ads :&nbsp<input name = "decisionsCostArr[]" id = "googleAds" required size="4" type="textbox" value="<?php echo $google; ?>">
					<input name ="decisionsImpArr[]" align ="right" id = "" type="textbox" size="4" value="<?php echo $googleI; ?>" required></label>
				</div>
				<div class="textbox">
					<label>Radio Spot : &nbsp<input name ="decisionsCostArr[]" id = "RadioSpto"  required size="4" type="textbox" value="<?php echo $radio; ?>">
					<input name ="decisionsImpArr[]" align ="right" id = "" type="textbox" size="4" value="<?php echo $radioI; ?>" required ></label>
				</div>
				<div class="textbox">
					<label>TV Spot : &nbsp<input name = "decisionsCostArr[]" id = "TVSpot" required type="textbox" size="4" value="<?php echo $tv; ?>">
					<input name ="decisionsImpArr[]" align ="right" id = "" type="textbox" size="4" value="<?php echo $tvI; ?>" required></label>
				</div>
				<div class="textbox">
					<label>Promotional Gifts : &nbsp<input name = "decisionsCostArr[]" required id = "promoGifts"  size="4" type="textbox" value="<?php echo $promo; ?>">
					<input name ="decisionsImpArr[]" align ="right" id = "" type="textbox" size="4" value="<?php echo $promoI; ?>" required></label>
				</div>
				<div class="textbox">
					<label>eMarketing :&nbsp<input name ="decisionsCostArr[]" id ="eMarket" required size="4"  type="textbox" value="<?php echo $eMarketing; ?>">
					<input name ="decisionsImpArr[]" align ="right" id = "" type="textbox" size="4" value="<?php echo $eMarketingI; ?>" required></label>
				</div>
				<div class="textbox">
					 <label>City Bus ads :&nbsp<input name = "decisionsCostArr[]" id = "CityBus" required size="4" type="textbox" value="<?php echo $cityBus; ?>">
					 <input name ="decisionsImpArr[]" align ="right" id = "" type="textbox" size="4" value="<?php echo $cityBusI; ?>" required></label>
				</div>
					
			</div> 
			
			<div class="col-sm-3" style=""><h3>Marketing Personnel</h3>
				<br />
				<h5>Change the price and impact<h5>
				<br />
					
					
					<h4>Entry Level</h4>
					<div class="textbox">
					<label>Cost/Impact :&nbsp<input size ="4"  type="textbox" required value = "<?php echo $entryLev;?>"method = "post" name = "perCost[]" size= "2" id = "">
					<input type="textbox" align ="right" name = "perImp[]"size ="4" value= "<?php echo $entryLevI;?>" required  id=""></label>
					<br/>
					
					<br/>
					<h4>Manager in Traning</h4> 
					</div>
					
					<div class="textbox" >
					<label>Cost/Impact :&nbsp<input type="textbox" size ="4" name= "perCost[]" required value = "<?php echo $manTrain;?>" id="">
					<input type="textbox" size ="4" align = "right" name= "perImp[]"  required value= "<?php echo $manTrainI;?>"   ></label>
					<br/>
					<br/>
					</div>
					
					<h4>Experienced Professional</h4>
					<div class ="textbox">
					
					
					<label>Cost/Impact :&nbsp <input name = "perCost[]" type="textbox" required id = "professional" size="4" value= "<?php echo $expProf;?>">
					<input name = "perImp[]" type="textbox" align="right"  id = "professional" required value= "<?php echo $expProfI;?>" size="4"  id=""></label>

					<br/>
					</div>
					
					
			</div>
		
			<div class="col-sm-3" style=""><h3>OTA Allocations</h3>
				<br />
				<label for="AllAto">Discount for Rooms (written as decimal):</label>
				<input type="text" name = "ATOs" required style="font-weight: bold;" value ="<?php echo $ota[0]['discount'];?>" class="form-control" id="AllAto">
			
			
			</div>
    
	

			<div class="col-sm-3" style="" ><h3>Market Research</h3>
			<br />
				<label for="AllAto">Cost to do research :</label>
				<input type="text" name = "research" required placeholder = "" style="font-weight: bold;" value ="<?php echo $reSearch[0]['cost'] ;?>" class="form-control" id="AllAto">
			
	
	
  
				<div class="pull-right" style ="padding-top:100px; padding-right: 100px">
                <input type="submit" id = "submitButt" method = "post" align = 'right' name="commit" value = "Update Values" class="btn btn-primary" />
				</div>
			</div>
				
				</form>
				</div>
				</div> 
	

	
	
	
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
