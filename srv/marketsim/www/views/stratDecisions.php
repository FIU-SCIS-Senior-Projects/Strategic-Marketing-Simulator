<!DOCTYPE html>

<html lang="en">

<?php 
ini_set('memory_limit', '-1');
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
	require '../Model/database.php';
	$stuArr = array();
	$stuGroup = array();
	session_start();
	
	if (isset($_SESSION['admin login'])) 
	{
		header("Location: /views/stratDecisionsMan.php");
	}
	else if (!isset($_SESSION['login user'])) 
	{
		header("Location: /views/login.php");
	}
	else
	{
	//var_dump($_POST);
		print_r($_SESSION['login user']. " is not you? login "); 
		echo " <a href='/login.php'>here</a>";
		
		
		
		
		$email = $_SESSION['login user'];
		$obj = new database();
		$stuArr = $obj->getStudent($email);
		$stuGroup = $obj->getGroup($stuArr['hotel']);
		
		
		
		$groupType = $stuGroup['type'];
		$gameNum = $stuGroup['game'];
		
		
		
		$allGroup = $obj-> getGroupsforGame($stuGroup['game']);
		$stuLoc = $obj-> getLocation($stuGroup['location']);
		
		$personnel = $obj->getPersonnel();
		$reSearch = $obj->getResearch();
		
		
		
		
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
		
		$entryLev = $personnel[0]['cost'];
		$manTrain = $personnel[1]['cost'];
		$expProf = $personnel[2]['cost'];
		$research = $reSearch[0]['cost'];
		
		
		
		
		$studentGroup = $stuGroup['name']; // used for check on Market Research so ones own group isn't displayed
		$groupBal  = $stuGroup['balance']; 
		//$groupBal = number_format($groupBal);  
		
		if(isset($_POST['commit']))
		{
		
			$obj2 = new database();
			$currentPeriod = $obj2->getCurrentPeriod($gameNum); // getting current period array
			$periodNum = $currentPeriod[0]['periodNum']; // getting current period number
			$spending = $stuGroup['budget'];
			print_r($spending);
			//$isDec = $obj2->isDecisionTable($gameNum, $periodNum);
		//print_r("is dec : ". $isDec);
			$advertising = $obj2->getAdvertising();
			$adCount = count($advertising);
		//print_r("size of advertising array ". $adCount );
			$OTA = 3;  // this doesnt do anything
			$researchCount = 0;
		//print_r("ZERO IS NO TABLE.  1 IS TABLE EXISTS : ".$isDec); 
			$hotel = $stuGroup['id'];
		
		
			$selectedResearch = array();
					foreach($allGroup as $g) //used to grab size of research entries
					{
						if($g['name'] != $studentGroup)
						{
							$researchCount = $researchCount + 1;
							array_push($selectedResearch, $g['name']);
						}
					}
		$researchCount = count($selectedResearch);
		
		/*	if($isDec===0) // if the table doesn't exist, create it
			{
				//if the 
				$strTest = $obj2->addNewPeriodDecisions($decisionsTableName, 'NULL',$periodNum,$advertising,'NULL',$OTA,$selectedResearch);
				//print_r($strTest);// this works
				
			}*/
		
				//print_r("else of if table");
				//dirMarket publicRel PrintAdv billBoard FacebookAds RadioSpto TVSpot promoGifts eMarket CityBus
				
				$arrDecisions = array(); /* array for table update bellow.  index matches one:one with advertising table in db
											e.g.; $arrDecisions[5] is the id number for facebook from the table */
				if(isset($_POST['dirMarket']))
				{
					//print_r("index 1 ");
					array_push($arrDecisions, 1);
					
					$spending = $spending - $advertising[0]['cost'];
					
				}
				if(isset($_POST['publicRel']))
				{
					//print_r("index 2 ");
					array_push($arrDecisions, 2);
					$spending = $spending - $advertising[1]['cost'];
				}
				if(isset($_POST['PrintAdv']))
				{
					//print_r("index 3 ");
					array_push($arrDecisions, 3);
					$spending = $spending - $advertising[2]['cost'];
					
				}
				if(isset($_POST['billBoard']))
				{
					//print_r("index 4 ");
					array_push($arrDecisions, 4);
					$spending = $spending - $advertising[3]['cost'];
				}
				if(isset($_POST['FacebookAds']))
				{
					//print_r("index 5 ");
					array_push($arrDecisions, 5);
					$spending = $spending - $advertising[4]['cost'];
					
				}
				if(isset($_POST['googleAds']))
				{
					//print_r("index 6 ");
					array_push($arrDecisions, 6);
					$spending = $spending - $advertising[5]['cost'];
				}
				if(isset($_POST['RadioSpto']))
				{
					//print_r("index 7 ");
					array_push($arrDecisions, 7);
					$spending = $spending - $advertising[6]['cost'];
				}
				if(isset($_POST['TVSpot']))
				{
					//print_r("index 8 ");
					array_push($arrDecisions, 8);
					$spending = $spending - $advertising[7]['cost'];
				}
				if(isset($_POST['promoGifts']))
				{
					//print_r("index 9 ");
					array_push($arrDecisions, 9);
					$spending = $spending - $advertising[8]['cost'];
				}
				if(isset($_POST['eMarket']))
				{
					//print_r("index 10 ");
					array_push($arrDecisions, 10);
					$spending = $spending - $advertising[9]['cost'];
				}
				if(isset($_POST['CityBus']))
				{
					//print_r("index 11 ");
					array_push($arrDecisions, 11);
					$spending = $spending - $advertising[10]['cost'];
				}
				
				
				
				
				////PRIMARY KEY SHOULD BE HOTEL/////
				
				
				/*for ($r = 0; $r < count($arrDecisions); $r++)
				{
					print_r($arrDecisions[$r]);  // testing array
				}*/
						/* personnel posts - get an array of three values  */  
				
				
				$personArr = array(); // array of personnell
				
				$roomRate = 0.0;
				//var_dump($_POST);	
				//print_r($entryLev);
				if(!empty($_POST['roomPR']) && isset($_POST['roomPR']))
				{
					$roomRate = floatval($_POST['roomPR']);
				//	print_r("Average room price set ");
					//print_r($_POST['roomPR']);
				}
				
				//print_r($_POST['entryLev']);
				
				if(!empty($_POST[intval($entryLev)]) && isset($_POST[intval($entryLev)]))	
				{
					//print_r("entry lev is set with " . $_POST[intval($entryLev)]);
					array_push($personArr, $_POST[intval($entryLev)]);
					$spending = $spending - $personnel[0]['cost'];
					
				}
				else
				{
				//	print_r("EntryLev is not set");
					array_push($personArr,0);
					
				}	
				
				if(!empty($_POST[intval($manTrain)]) && isset($_POST[intval($manTrain)]))	
				{
					//print_r("manager in training is set with " . $_POST[intval($manTrain)]);
					array_push($personArr, $_POST[intval($manTrain)]);
					$spending = $spending - $personnel[1]['cost'];
					
				}
				else
				{
					//print_r("manager in training is not set");
					array_push($personArr,0);
					
				}
				if(!empty($_POST[intval($expProf)]) && isset($_POST[intval($expProf)]))	
				{
					//print_r("experienced professional is set with " . $_POST[intval($expProf)]);
					array_push($personArr, $_POST[intval($expProf)]);
					$spending = $spending - $personnel[2]['cost'];
					
				}
				else
				{
					//print_r("experienced professional is not set");
					array_push($personArr,0);
					
				}
				//print_r("personnel array is of size " . count($personArr));
				/*for($p = 0; $p< 3; $p++)
				{
					
					print_r("index " . $p . " of personnel array has " .$personArr[$p]);
				}*/
				
				/*  GETTING OTA ALLOCATIONS  -  This is working well now  */ 
				
				//var_dump($_POST);
				if(isset($_POST['ATOs']) && !empty($_POST['ATOs']))
				{
					
					$ATONumber = intval($_POST['ATOs']);
					//print_r("You have selected otas: " . $ATONumber);
				}
				else
				{
					$ATONumber = 0.00;
					//print_r("you didn't select an OTA");
					
				}
				
				/* selected research array -- this is working*/
				
				//var_dump($_POST);
				$researchArr = array();
				
				
				if(isset($_POST['researched']))
				{
					$o = 0;
					foreach ($_POST['researched'] as $item)
					{
						array_push($researchArr, $item);
						$spending = $spending - $reSearch[$o]['cost'];
						$o++;
					}
					print_r($spending);
					
				}
				//print_r("size of research array" . count($researchArr) );
				for ($w = 0; $w < count($researchArr); $w++)
				{
					//print_r(" here is the index number ".$w. " : ". $researchArr[$w]);
					
				}
				//print_r("anything");]
				
				//add if hotel not in db else update
				 $obj2->insertDecisions($gameNum ,$periodNum, $roomRate, $hotel,  $arrDecisions, $personArr, $ATONumber,  $researchArr);
				
				
				header("Location: ../index.php");
			/*	if(isset($_SESSION['FIRST PERIOD']))
				{
					unset($_SESSION['FIRST PERIOD']);
					header("Location: /index.php");
				}
				else
				{
					print_r ("it is not set");
				}*/
			
		}
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
	<script>
	
	
	$(document).ready(function(){
	
	
	//global variables//
	var BALANCE = parseInt($("#Group_Balance").html().replace("$",""));
	var ENTRY= 0;
	var TRAINING =0;
	var PROFESSIONAL  = 0;
	
	
	////Advertising checkboxes////
	
		$("#dirMarkID").click(function(){
		if(document.getElementById('dirMarkID').checked)
			{
			var x = parseInt($('#dirMarkID').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y-x)).css('color','green');
		
			}
		else{
			var x = parseInt($('#dirMarkID').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y+x)).css('color','green');
						
			}
			
			 });
			$("#publicRel").click(function(){
		if(document.getElementById('publicRel').checked)
			{
			var x = parseInt($('#publicRel').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
		
			
			
			$("#Group_Balance").html("$"+ (y-x)).css('color','green');
		
			}
		else{
			var x = parseInt($('#publicRel').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y+x)).css('color','green');
			}
			});
			
			$("#PrintAdv").click(function(){
		if(document.getElementById('PrintAdv').checked)
			{
			var x = parseInt($('#PrintAdv').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
		
			
			
			$("#Group_Balance").html("$"+ (y-x));
		
			}
		else{
			var x = parseInt($('#PrintAdv').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y+x)).css('color','green');
			}
			});
			
			
			$("#billBoard").click(function(){
		if(document.getElementById('billBoard').checked)
			{
			var x = parseInt($('#billBoard').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
		
			
			
			$("#Group_Balance").html("$"+ (y-x)).css('color','green');
		
			}
		else{
			var x = parseInt($('#billBoard').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y+x)).css('color','green');
			}
			});
			
			$("#FacebookAds").click(function(){
		if(document.getElementById('FacebookAds').checked)
			{
			var x = parseInt($('#FacebookAds').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
		
			
			
			$("#Group_Balance").html("$"+ (y-x)).css('color','green');
		
			}
		else{
			var x = parseInt($('#FacebookAds').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y+x)).css('color','green');
			}
			});
			
			
			$("#googleAds").click(function(){
		if(document.getElementById('googleAds').checked)
			{
			var x = parseInt($('#googleAds').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
		
			
			
			$("#Group_Balance").html("$"+ (y-x)).css('color','green');
		
			}
		else{
			var x = parseInt($('#googleAds').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y+x)).css('color','green');
			}
			});
			
			
			$("#RadioSpto").click(function(){
		if(document.getElementById('RadioSpto').checked)
			{
			var x = parseInt($('#RadioSpto').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
		
			
			
			$("#Group_Balance").html("$"+ (y-x));
		
			}
		else{
			var x = parseInt($('#RadioSpto').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y+x)).css('color','green');
			}
			});
			
			
			$("#TVSpot").click(function(){
		if(document.getElementById('TVSpot').checked)
			{
			var x = parseInt($('#TVSpot').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
		
			
			
			$("#Group_Balance").html("$"+ (y-x)).css('color','green');
		
			}
		else{
			var x = parseInt($('#TVSpot').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y+x)).css('color','green');
			}
			});
			
			
			$("#promoGifts").click(function(){
		if(document.getElementById('promoGifts').checked)
			{
			var x = parseInt($('#promoGifts').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
		
			
			
			$("#Group_Balance").html("$"+ (y-x)).css('color','green');
		
			}
		else{
			var x = parseInt($('#promoGifts').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y+x)).css('color','green');
			}
			});
			
			$("#eMarket").click(function(){
		if(document.getElementById('eMarket').checked)
			{
			var x = parseInt($('#eMarket').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
		
			
			
			$("#Group_Balance").html("$"+ (y-x)).css('color','green');
		
			}
		else{
			var x = parseInt($('#eMarket').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y+x)).css('color','green');
			}
			});
			
			$("#CityBus").click(function(){
		if(document.getElementById('CityBus').checked)
			{
			var x = parseInt($('#CityBus').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
		
			
			
			$("#Group_Balance").html("$"+ (y-x)).css('color','green');
		
			}
		else{
			var x = parseInt($('#CityBus').val());
			var y = parseInt($('#Group_Balance').html().replace("$",""));
			$("#Group_Balance").html("$"+ (y+x)).css('color','green');
			}
			});
			
			
			//for personnel 
			
			
			$('#entry').blur(function() 
				{
			
					if($('#entry').val())
					{
						var DIFF;
						var x = parseInt($('#entry').val());
						var y = parseInt($('#entry').attr('name'));
						var z;
						var newBal = parseInt($("#Group_Balance").html().replace("$",""));
						
						if(x > ENTRY)
						{
							DIFF = x - ENTRY;
							z = DIFF * y;
							newBal = parseInt($("#Group_Balance").html().replace("$","")) - z;
						
						}
						else if (x < ENTRY)
						{
							DIFF = ENTRY - x;
							z = DIFF * y;
							newBal = parseInt($("#Group_Balance").html().replace("$","")) + z;
						}
						
						//ENTRY = parseInt($('#entry').val());
			
					
						$("#Group_Balance").html("$" + newBal).css('color','green');
						ENTRY = parseInt(x);
					}
					else
					
					{
						
						
						var y = parseInt($('#entry').attr('name'));
						z = ENTRY * y;
						newBal = parseInt($("#Group_Balance").html().replace("$","")) + z;
						$("#Group_Balance").html("$" + newBal).css('color','green');
						ENTRY = 0; // resetting entry here
					}
				});
				
				
				$('#training').blur(function() 
				{
					
					if($('#training').val())
					{
						var DIFF;
						var x = parseInt($('#training').val());
						var y = parseInt($('#training').attr('name'));
						var z;
						var newBal = parseInt($("#Group_Balance").html().replace("$",""));
						
						if(x > TRAINING)
						{
							DIFF = x - TRAINING;
							z = DIFF * y;
							newBal = parseInt($("#Group_Balance").html().replace("$","")) - z;
						
						}
						else if (x < TRAINING)
						{
							DIFF = TRAINING - x;
							z = DIFF * y;
							newBal = parseInt($("#Group_Balance").html().replace("$","")) + z;
						}
						
					
			
					
						$("#Group_Balance").html("$"+ newBal).css('color','green');
						TRAINING = parseInt(x);
					}
					else
					
					{
						
						
						var y = parseInt($('#training').attr('name'));
						z = TRAINING * y;
						newBal = parseInt($("#Group_Balance").html().replace("$","")) + z;
						$("#Group_Balance").html("$"+newBal).css('color','green');
						TRAINING = 0; // resetting training here
					}
				});
				
				
				$('#professional').blur(function() 
				{
			
					if($('#professional').val())
					{
						var DIFF;
						var x = parseInt($('#professional').val());
						var y = parseInt($('#professional').attr('name'));
						var z;
						var newBal = parseInt($("#Group_Balance").html().replace("$",""));
						
						if(x > PROFESSIONAL)
						{
							DIFF = x - PROFESSIONAL;
							z = DIFF * y;
							newBal = parseInt($("#Group_Balance").html().replace("$","")) - z;
						
						}
						else if (x < PROFESSIONAL)
						{
							DIFF = PROFESSIONAL - x;
							z = DIFF * y;
							newBal = parseInt($("#Group_Balance").html().replace("$","")) + z;
						}
						
					
			
					
						$("#Group_Balance").html("$"+newBal).css('color','green');
						PROFESSIONAL = parseInt(x);
					}
					else
					
					{
						
						
						var y = parseInt($('#professional').attr('name'));
						z = PROFESSIONAL * y;
						newBal = parseInt($("#Group_Balance").html().replace("$","")) + z;
						
						$("#Group_Balance").html("$" +newBal).css('color','green');
						PROFESSIONAL = 0; // resetting professional here
					}
				});
				
				
				
				//check if student selected at least 3 advertising
				 $('#submitButt').click(function() {
				checked = $("input[type=checkbox]:checked").length;

				if(checked < 3) {
				alert("Please select at least 3 advertising");
				return false;
				}

				});
				
				//make sure it doesn't go into the negatives
				$('.container').change(function() 
				{
					var test = newBal = parseInt($("#Group_Balance").html().replace("$",""));
					if(test<1)
					{
						alert("Your budget wont allow for any more investments");
						
						
					}
					
					});
	
	
		
});
			
	

				
   
   

	
	</script>
	
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
			$("#Group_Balance").html("$" + (y +res)).css('color','green') ;
			//alert(id + " is not checked");
	
		}
		
		
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
                        <a href="#"="a" onclick ="redirect('../index.php')"> Home</a>
                    </li>
                 
                    <li>
                         <a href="#"="a" onclick ="redirect('stratDecisions.php')">Strategic Decisions</a>
                    </li>
				
                    <li>
                        <a href="#"="a" onclick ="redirect('News.php')">News</a>
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
		<h1 style = "color:blue" align="center">Strategic Marketing Simulator</h1> 
		 <h2  id ="Group_Balance" style = "color: green" align="center">$<?php echo intval($groupBal); ?></h2> 
	
	<div class="container-fluid">
		<div class="row">
		<form role= 'form' method = 'post'>
		
		<!--  insert php if statement here to add disabled once group already selects market sector-->
			<div class="col-sm-2" id = "radz"style=""><h3> Market Segment</h3>
			<?php
			
			if($groupType)
			{
				echo "<p style = 'color:green'>You already selected ".$groupType. " as a Market Segment</p>
				<div class='radio disabled' id = 'rad1'>
				<label><input type='radio'  name='optradio' disabled>Economic Hotel</label>
				</div>
				<div class='radio disabled' id ='rad2'>
				<label><input type='radio'  name='optradio' disabled>Midrange Hotel</label>
				</div>
				<div class='radio disabled' id = 'rad3'> <!-- radio disabled here for red cirlce with line-->
				<label><input type='radio'  name='optradio' disabled>Luxury Hotel</label>  <!-- add radio disabled here to gray out -->
				</div>";
				
			}
			
			else
			
			{
				echo "<div class='radio' id = 'rad1'>
				<label><input type='radio'  name='optradio'>Economic Hotel</label>
				</div>
				<div class='radio' id ='rad2'>
				<label><input type='radio'  name='optradio'>Midrange Hotel</label>
				</div>
				<div class='radio' id = 'rad3'> <!-- radio disabled here for red cirlce with line-->
				<label><input type='radio'  name='optradio' >Luxury Hotel</label>  <!-- add radio disabled here to gray out -->
				</div>";
				
			}

?>			
					
			
			</div>
    	
			<div class="col-sm-2" style=""><h3>Average Daily Rate</h3>
			    <br /><label for="roomPrice">Room price :</label>
				<input type="text" name = "roomPR" required placeholder = "55.00" class="form-control" id="roomPrice">
			</div>
			
			<div class="col-sm-2" style=""><h3>Advertising</h3>
			<p> Minimum of 3, no max<p>
			
				<div class="checkbox">
					<label><input name ="dirMarket" id = "dirMarkID" type="checkbox" value="<?php echo $dir_mark; ?>" >Direct Marketing $<?php echo $dir_mark; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "publicRel" id = "publicRel" type="checkbox" value="<?php echo $pub_rel; ?>">Public Relations Firm $<?php echo $pub_rel; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "PrintAdv" id ="PrintAdv"  type="checkbox" value="<?php echo $print; ?>">Print Advertising $<?php echo $print; ?></label>
				</div>
				<div class="checkbox">
					<label><input name ="billBoard" id = "billBoard" type="checkbox" value="<?php echo $billBoard; ?>">Billboards $<?php echo $billBoard; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "FacebookAds" id = "FacebookAds" type="checkbox" value="<?php echo $faceBook; ?>">Facebook Ads $<?php echo $faceBook; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "googleAds" id = "googleAds" type="checkbox" value="<?php echo $google; ?>">Google Ads $<?php echo $google; ?></label>
				</div>
				<div class="checkbox">
					<label><input name ="RadioSpto" id = "RadioSpto"  type="checkbox" value="<?php echo $radio; ?>">Radio Spot $<?php echo $radio; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "TVSpot" id = "TVSpot" type="checkbox" value="<?php echo $tv; ?>">TV Spot $<?php echo $tv; ?></label>
				</div>
				<div class="checkbox">
					<label><input name = "promoGifts" id = "promoGifts"  type="checkbox" value="<?php echo $promo; ?>">Promotional Gifts $<?php echo $promo; ?></label>
				</div>
				<div class="checkbox">
					<label><input name ="eMarket" id ="eMarket"  type="checkbox" value="<?php echo $eMarketing; ?>">eMarketing $<?php echo $eMarketing; ?></label>
				</div>
				<div class="checkbox">
					 <label><input name = "CityBus" id = "CityBus" type="checkbox" value="<?php echo $cityBus; ?>">City Bus ads $<?php echo $cityBus; ?></label>
				</div>
					
			</div> 
			
			<div class="col-sm-2" style=""><h3>Marketing Personnel</h3>
				<h5>Select the number of personnel you want<h5>
				<br />
				
				    <label for="<?php echo $entryLev;?>" id = "entryLevCost" value = "<?php echo $entryLev;?>" >Entry Level $<?php echo $entryLev;?> :</label>
					<input type="text" method = "post" name = "<?php echo intval($entryLev);?>" id = "entry" placeholder = "2" class="form-control">
					
					
					<br /><label for="<?php echo $manTrain;?>" value ="<?php echo $manTrain;?>" id = "manTraining">Manager in Traning $<?php echo $manTrain;?> :</label>
					<input type="text" name= "<?php echo intval($manTrain);?>" id = "training" placeholder = "0" class="form-control" id="ManTrain">
					
					
					<br /><label for="<?php echo $expProf;?>" id = "ExpProfess" value = "<?php echo $expProf;?>">Experienced Professional $<?php echo $expProf;?> :</label>
					<input type="text" name = "<?php echo intval($expProf);?>" id = "professional" placeholder = "3" class="form-control" id="ExpProf">
			</div>
		
			<div class="col-sm-2" style=""><h3>OTA Allocations</h3>
				<br />
				<label for="AllAto"># of Rooms :</label>
				<input type="text" name = "ATOs" placeholder = "10" class="form-control" id="AllAto">
			
			
			</div>
    
	

			<div class="col-sm-2" style="" ><h3>Market Research</h3>
			
	<?php	echo "<p = id = 'reasearchCost' name ='". $research ."'>Research other groups at a cost of $". $research . ":</p>";		
				//var_dump($allGroup);
				$count = 1;
				foreach($allGroup as $group) {
					
					
								if($group['name'] != $studentGroup) {?>
				
	
				<div class="checkbox"  > 
					<label><input id = "<?php echo str_replace("'", "", str_replace(' ', '', $group['name'])) . $count; $count = $count+1;?>" onchange = "getResearch(this.id,<?php echo $research; ?>);" class = "chk"  name ="researched[]" type="checkbox" value="<?php echo $group['name']; ?>"><?php echo $group['name']; ?></label>
				</div>
				
				<?php }}?>
	
			
	</div>
	
	
  </div>
				<div class="pull-right">
                <input type="submit" id = "submitButt" method = "post" align = 'right' name="commit" value = "Select decisions" class="btn btn-primary" />
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
