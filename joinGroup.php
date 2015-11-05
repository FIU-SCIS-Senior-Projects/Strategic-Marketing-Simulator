<?php
include("connection.php");
ini_set('display_errors', 1);
error_reporting(~0);



	require 'Model/database.php';
	session_start();
	$groupRes = Array();
	if (isset($_SESSION['login user'])) 
	{
		
		echo "<div style = 'text-align: left; padding-left: 25px'>".$_SESSION['login user'] . " is not you? login 
			<a href='/login.php'> here</a>
		</div>";

	}
	else
	{
		header('Location: /login.php');
		
	}
	
	


?>
<script type="text/javascript">

function redirect(site) {
	window.location = site
	exit;
}
</script>

<!DOCTYPE html>
<html>
<head>
<title>Strategic Marketing Simulator</title>
<link rel="stylesheet" href="/Styles/style.css" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
 <!-- Custom CSS -->
 <link href="css/logo-nav.css" rel="stylesheet">
</head>
<body>
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


<h1 style = "color:blue; padding-left: 20px" align="left">Join a group</h1> 
<div id="container">
  <div id="body">
  
	<form id="savecascade" style = " padding-left: 20px" javascript="false">
	<div id="dropdowns">
       <div id="center" class="cascade">
          <?php
		$sql = "SELECT * FROM game";
		$sql2 = "Select type, id from location";
		$query = mysqli_query($con, $sql);
		$query2 = mysqli_query($con, $sql2);
		?>
            <label>Please select a Game:
            <select name="game" id = "drop1">
              <option value="">Please Select</option>
              <?php while ($rs = mysqli_fetch_array($query, MYSQLI_ASSOC )) { ?>
              <option name= "gameID" value="<?php echo $rs["id"]; ?>"><?php echo $rs["semester"]. " | ". $rs['course']; ?></option>
              <?php } ?>
            </select>
            </label>
          </div>
         <div id= "group" class= "cascade"></div> 
		
		 <input type="submit" name="submit" action="submitValues()" value = "submit" class="btn btn-primary" /> <br /><br />
		 <a href='/createGroup.php'>Click me to create a new group</a>
        </div><br />
				
			
          </div> <br />
		
		</form>
		
    </div>
  </div>
   
  
<script src="jquery-1.9.0.min.js"></script>
<script>
$(document).ready(function(){
$("#savecascade").submit(function(){
var get_data=$("#savecascade").serialize();
$.ajax({
			type: "POST",
			url: "insertGroup.php",
			data: {"csc":get_data},
			cache: false,
			success: function(html) {    
				//alert(html); 
				if(html == true)
				{
					alert("You successfully joined a group")
				window.location.href= "/index.php";
				}
			}
		});
return false;
});

$("select#drop1").change(function(){
	
	var game_id =  $("select#drop1 option:selected").attr('value'); 
    //alert(game_id);	
	$("#group").html( "" );
	//$("#city").html( "" );
	if (game_id.length > 0 ) { 
		
	 $.ajax({
			type: "POST",
			url: "fetch_group.php",
			data: "game_id="+ game_id,
			cache: false,
			beforeSend: function () { 
				
				$('#group').html('<img src="loader.gif" alt="" width="24" height="24">');
			},
			success: function(html) {    
				$("#group").html( html );
			}
		});
	} 
});
}
);
</script>
</body>
</html>
