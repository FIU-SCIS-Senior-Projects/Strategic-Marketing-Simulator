<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>

<?php 
ini_set('display_errors', 1);
error_reporting(~0);
	require 'Model/database.php';
	require ('/srv/marketsim/www/Controller/periodController.php');
	$stuArr = array();
	$stuGroup = array();
	session_start();
	
	
	if (isset($_SESSION['admin login'])) 
	{
		header("Location: /views/ManagePage.php");
		exit;
	}
	else if (!isset($_SESSION['login user'])) 
	{
		header("Location: /views/login.php");
		exit;
	}
	
	else
	{
		echo "<div style = 'text-align: left; padding-left: 25px'>".$_SESSION['login user'] . " is not you? login 
			<a href='/views/login.php'> here</a>
		</div>";
		$email = $_SESSION['login user'];
		
		
		$periodDecs = new periodController();
		$displayArr = $periodDecs->getDisplay($email);

		
		//$decisions, $stuArr, $stuGroup, $stuLoc,  $advertising, $personnel, $period, $makertshare, $groups, $rev, $leaderboard, $researchDisplay, $researchDisplay2
		$obj = new database();
		$decisions = $displayArr[0];
		$stuArr = $displayArr[1];
		$stuGroup = $displayArr[2];
		$stuLoc = $displayArr[3];
		if($decisions!=false)
		{
			$aveRate = $decisions[0]['aveRate'];
		}
		else
		{
			$aveRate = "Not yet selected";
		}
		
		$advertising = $displayArr[4];  

		$personnel = $displayArr[5];
		$periodNum = $displayArr[6];
		$marketshare =  $displayArr[7];
	
		$groups =   $displayArr[8];
		
		
		$groupNum = $stuGroup['id'];
		$groupNum = "group" . $groupNum;
		$groupMarketShare  =  $displayArr[13];
		if($groupMarketShare != false)
		{
			$groupRooms = $groupMarketShare[0]['groupSold'];
			$rooms = $groupMarketShare[0]['totalRooms'];
			$roomsSold = $groupMarketShare[0]['roomsSold'];
		}
		else
		{
			$groupRooms = false;
			$rooms = false;
			$roomsSold = false;
		
		}
		
		$revenue = $displayArr[9];
		$leaderBoard = $displayArr[10];
		$researched = $displayArr[11];
		$researched2 = $displayArr[12];
		$bar = "";
		$kk = 0;
		foreach($leaderBoard as $led)
		{
	
			if($kk + 1 < count($leaderBoard))
			{
				$bar.= "['" . str_replace("'", "", $led['name']) . "', " . $led['revenue'] . "], ";
			}
			else
			{
				$bar.= "['" . str_replace("'", "", $led['name']) . "', " . $led['revenue'] . "] ";
			}
			$kk++;
		}
		
		$pie = "";
		$ii = 0;
	
	
		if($marketshare != false)
		{
		
			foreach($groups as $g)
			{
			$name = $obj->gethotelname($marketshare[$ii]['hotel']);
			
				if ($ii + 1 < count($marketshare))
				{//$str = str_replace("'", '', $str)
			
					$pie .= "['" . str_replace("'", "", $name[0]['name']) . "', " . str_replace("'", '', $marketshare[$ii]['groupSold']) . "], ";
				}
				else
				{
					$pie .= "['" . str_replace("'", "", $name[0]['name']) . "', " . str_replace("'", '', $marketshare[$ii]['groupSold']) . "] ";
				}
				$ii++;
			}
		}
		
				
		
		
		
		
	}
 ?>


 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      google.load("visualization", "1", {packages:["corechart", "bar"]});
      google.setOnLoadCallback(drawChart);
		
			
			
	
///TableData.shift();  // first row is the table header - so remove
      function drawChart() {

	 //create a php loop here to print arraytodatatable
	  
        var data = google.visualization.arrayToDataTable([
		
          ['group', 'share'],
		  <?php echo $pie;?>
     
        ]);

        var options = {
          title: 'Marketshare by group',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
	  
	   google.setOnLoadCallback(drawBasic);

	   function drawBasic() {

      var data = google.visualization.arrayToDataTable([
        ['group', 'Revenue',],
        
		<?php echo $bar; ?>
		
      ]);

      var options = {
        title: 'Leaderboard Rankings',
        chartArea: {width: '50%'},
        hAxis: {
          title: 'Revenue',
          minValue: 0
        },
        vAxis: {
          title: 'Groups'
        }
      };

      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
    </script>
	
	 

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

</script>

</head>

<body>

    <!-- Navigation -->
	<form action= "/views/commit.php" method="post">
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
                         <a href="/views/stratDecisions.php"="a" onclick ="redirect('/views/stratDecisions.php')">Strategic Decisions</a>
                    </li>
					<li>
						<a href="/views/ManagePage.php"="a" onclick ="redirect('/views/ManagePage.php')"> Manage</a>
                    </li>
                    <li>
                        <a href="/views/News.php"="a" onclick ="redirect('/views/News.php')">News</a>
                    </li>
                    <li>
                         <a href="/views/signout.php"="a" onclick ="redirect('/views/signout.php')">Sign Out</a>
                    </li>
					<li>
                         <a href="/views/accountManage.php"="a" onclick ="redirect('/views/accountManage.php')">My Account</a>
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
		
	<div class="bs-example" style = "padding-left: 30px; padding-right: 30px;"> 
    <div class="panel panel-default" style = "padding-left: 15px; padding-right: 15px; padding-bottom:15px;">
			
			
			
		
			
				
				<div class="pull-right" style = 'padding-top:30px'>
                <input type="submit" align = 'right' name="commit" value = "Commit Period"  class="btn btn-primary" />
				</div>
				
        <div class="panel-body" ><h2> Scorecard - Period <?php echo " ". $periodNum+1;?> </h2></div> 
        <div class="panel-footer clearfix" style = "background-color:white"> 
		<div class="col-sm-3" style=""><h3 style='font-weight: bold'>Group info</h3><h4> Group : <?php echo $stuGroup['name'];  ?>  </h4>  <h4> Hotel Type : <?php echo $stuGroup['type'];  ?>  </h4>
		
		<h4> Location :  <?php echo $stuLoc['type'];  ?></h4><h4> Budget : $<?php $budget = $stuGroup['budget']; $budget = number_format($budget); echo $budget;   ?> </h4> <h4> Remaining budget : $<?php $balance = $stuGroup['balance']; $balance = number_format($balance); echo $balance; ?>  </h4>
         </div>   
		 
		 <div class="col-sm-3" style=""><h3 style='font-weight: bold'>Status</h3>
		 <h4><?php  if($groupRooms == false) {echo "no market status available";} else {echo "Number of rooms booked : "  . $groupRooms; }/*Here I need to put the number of rooms sold*/  ?></h4>
		 <h4><?php  if($groupRooms == false) {} else{ echo " My market Share: ". intval(($groupRooms / $roomsSold) *100). '%'/*I need to add groups market share heres*/;}?></h3>
		 <h4>Revenue : $<?php echo $revenue[0]['revenue'];?><h4> 
		 
		 </div>
		 
		 <div class="col-sm-2" style=""><h3 style='font-weight: bold'>Market Share</h3>
		 <?php
			//here I need a loop displaying the other groups shares
			if($marketshare != false)
			{
			echo "<table class='table' id ='sampleTbl' >
    <thead>
      <tr>
        <th>Group</th>
        <th>Share</th>
        </tr>
    </thead>";
			
			$i =  0;
			
				foreach($marketshare as $share)
				{
				$name = $obj->gethotelname($marketshare[$i]['hotel']);
					if($groups[$i]['name'] != $stuGroup['name'])
					{
						echo "<tr>";
						echo "<td>" . $name[0]['name']."</td>";
						echo "<td>" .  round(100 * floatval(($share['groupSold']/$roomsSold)*100))/100  ."% </td>";
						echo "</tr>";
					}
					$i = $i+1;
				}
			
			echo "</tbody></table>";
			}
			else
			{
				echo "<h4>Market Share has not yet been determined</h4>";
			}
			
		 ?>
	
		</div>
		 <div class="col-sm-4" style="">
		 
		 <?php 
		if($marketshare != false)
		{
			echo "<div id='piechart_3d' style='width: 630px; height: 350px;'></div>";
		}
		?>
			
		</div>
		
		  <div class="col-sm-4" style="">
			
		
		</div>
	</div>
</div>
		
</div>		
	
	


<div class="bs-example2" style = "padding-left: 30px; padding-right: 30px;">
    <div class="panel panel-default " style = "padding-left: 15px; padding-right: 15px; padding-bottom:15px;">
				<div class="pull-right" style = "padding-top:30px">
                <a href="/views/stratDecisions.php" class="btn btn-primary">Change decisions</a>
                </div>
        <div class="panel-body" ><h2> Selected decisions </h2></div> 
        <div class="panel-footer clearfix" style = "background-color:white"> 
			<div class="col-sm-2" style=""><h3 style='font-weight: bold'>Average Daily Rate</h3>
			<?php if($decisions != false)
			{
			echo "<P>Average rate is $" .$aveRate;
			
			}
			else
			{
				echo "<p>You have not yet  chosen an average rate<p>";
			}?>
			
			
		
			</div>
			
			<div class="col-sm-2" style=""><h3 style='font-weight: bold'>Advertising</h3>
			<?PHP 
	
				foreach($advertising as $ADVERT)
				{ ?>
				
					<p><?php ;echo str_replace('_', ' ', $ADVERT[0]['type']) ." $" . $ADVERT[0]['cost'] ;?><p>
					
				
				<?php	}			
			
			
			?>
			
			</div>
			
			
			<div class="col-sm-2" style=""><h3 style='font-weight: bold'>Marketing Personnel</h3>
			<?php
				/*foreach($personnel as $per)
				{
					
					echo $per;
				}*/
				echo "<p> 1 Manager in Training</p><p>2 Experienced professionals</p> ";
			
			?>
			
			</div>
			<div class="col-sm-2" style="" ><h3 style='font-weight: bold'>Allocations</h3>
			<?php echo "OTA :" .$decisions[0]['OTA']?>
			
			</div>
			
			<div class="col-sm-2" style="" ><h3 style='font-weight: bold'>Market Research</h3>
			<?php echo $researched?>
			
			</div>
			<div class="col-sm-2" style="" >
			<?php echo $researched2?>
			
			</div>
		
           
        </div>
    </div>
	
	
</div>
	
	
	<div class="bs-example2" style = "padding-left: 30px; padding-right: 30px;">
	<div class="panel panel-default" >
    <div class="panel-heading"><h2>Leaderboard</h2></div>
    <div class="panel-body" >
	        <p>See how the other hotels are doing!</p>
    </div>
	
    <div class="table-responsive" style = "padding-top:15px; padding-right:15px" >
		<div class="col-sm-6" style="">
        <table class="table table-bordered" >
            <thead>
                <tr>
                   <td>#</td>
				   <td>Group</td>
				   <td>Type</td>
				   <td>Purpose</td>
				   <td>Location</td>
				   <td>Revenue</td>
				   
				   
                </tr>
            </thead>
            <tbody>
			<?php
			$i = 0;
               
				
				
				foreach($leaderBoard as $g) // I need to sort this
				{
					echo  "<tr>";
                    echo "<td>" . ($i+1) . "</td>";
					echo "<td>" .$g['name'] ."</td>";
					echo "<td>" .$g['type'] ."</td>";
					echo"<td>" .$g['purpose'] ."</td>";
					echo "<td>" .$g['ltype'] ."</td>";
					echo "<td>$" .$g['revenue'] ."</td>";
					echo "</tr>";
					$i++;
				}	
					
               
				
				?>
            </tbody>
        </table>
		</div>
		<div class="col-sm-5" style="">
			
			<div id="chart_div" style = "padding-top: 20px;"></div>
		</div>
    </div>
	
</div>
</div>
</form>
	
	
	
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<script>

</script>

</body>

</html>
