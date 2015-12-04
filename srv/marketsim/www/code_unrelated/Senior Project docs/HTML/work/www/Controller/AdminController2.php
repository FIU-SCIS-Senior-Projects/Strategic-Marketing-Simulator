


<link rel="stylesheet" href="../Styles/styleForMan.css" type="text/css" />
<link href="../css/bootstrap.min.css" rel="stylesheet"/>



<script type="text/javascript" src="/bootstrap.min.js"></script>


 <!-- Custom CSS -->
 <link href="css/logo-nav.css" rel="stylesheet">
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>



<?php


/*created by Javier Andrial*/
ini_set('display_errors', 1);
error_reporting(~0);

require ("/srv/marketsim/www/Model/database.php");
class AdminController2 
{
	
	function CreatePage($value,$method)
	{	
		$result=   "<form action='' method='post'>
					<div class='bs-example'>".
						"<div class='panel panel-default'>".
							"<div class='panel-body' align='center'>".

								"<h2>User Accounts Management</h2>".
								"<a href='http://marketsim-dev.cis.fiu.edu/admin%20shit/adminUsers2.php?addAdminUser=Add+Admistrative+User' class='btn btn-primary'>Add Admistrative User</a>".
								"<a href='http://marketsim-dev.cis.fiu.edu/admin%20shit/adminUsers2.php?addBotUser=Add+Bot+User&textbox_bot_id=&textbox_bot_fname=&textbox_bot_lname=&textbox_bot_email=' class='btn btn-primary'>Add Bot User</a>".
								"<a href='http://marketsim-dev.cis.fiu.edu/admin%20shit/adminUsers2.php?viewAllGames=View+All+Games' class='btn btn-primary'>View All Games</a>".
								"<a href='http://marketsim-dev.cis.fiu.edu/admin%20shit/adminUsers2.php?viewAllUsers=View+All+Users' class='btn btn-primary'>View All Users</a>".
							//	"<input name = 'addAdminUser' type = 'submit' value = 'Add Admistrative User' class='btn btn-primary'/>".
							//	"<input name = 'addBotUser' type = 'submit' value = 'Add Bot User' class='btn btn-primary'/>".
						//		"<input name = 'viewAllGames' type = 'submit' value = 'View All Games' class='btn btn-primary'/>".
							//	"<input name = 'viewAllUsers' type = 'submit' value = 'View All Users' class='btn btn-primary'/>".
							"</div>".
							"<div class='' align='center'>".
							"<div class='panel-footer clearfix' style='height: 900px; width: 1060px' >".
							$value.
						   "</div>".
						"</div>".
					"</div>".
					"</div>".
					"</form>";			
		
		return $result;
	}
	
	function addAdminPage()
	{
			$result = 
			//"<form action='' method='post'>".
			"<div class='' align='left'>".
			"<h3>First Name</h3>".
			"<input type = 'Text' name = 'textbox_fname'  pattern='.{1,}'  placeholder='Javier'>".
			"<h3>Last Name</h3>".
			"<input type = 'Text' name = 'textbox_lname' method='post' placeholder = 'Andrial' >".
			"<h3>Email</h3>".
			"<input type = 'email' name = 'textbox_email' pattern='.{1,}'  placeholder='admin@marketsim.edu'>".
			"<h3>Password</h3>".
			"<input type = 'password' name = 'textbox_password1'  pattern='.{8,}' placeholder='password'>".
			"<h3>Re-enter Password</h3>".
			"<input type = 'password' name = 'textbox_password2'  pattern='.{8,}' placeholder='password'>".
			"<h3>Secret Question</h3>".
			"<input type = 'Text' name = 'textbox_secretQuestion' pattern='.{1,}' placeholder='Whats my favorite website?'>".
			"<h3>Secret Answer</h3>".
			"<input type = 'Text' name = 'textbox_secretAnswer'  pattern='.{1,}' placeholder='marketsim-dev.cis.fiu.edu'>".
			"<br />".
			"<br />"."<br />".
			//"<a href='http://marketsim-dev.cis.fiu.edu/admin%20shit/adminUsers.php?textbox_fname=&textbox_lname=&textbox_email=&textbox_password1=&textbox_password2=&textbox_secretQuestion=&textbox_secretAnswer=&button_addAdmin=Create+Admistrative+Account' class='btn btn-primary'>View All Users</a>".
						
			"<input name='button_addAdmin' type = 'submit' value = 'Create Admistrative Account' class='btn btn-primary'/>".
			"</div>"
			//."</form>"
			;
		
		
		return $result;
	}
		
	
	function addAdmin( $fname, $lname, $email, $pwd1, $pwd2, $secQuestion, $secAnswer)
	{			
		if($fname == "" || $email == "" || $secQuestion == ""|| $secAnswer == ""|| $pwd1 == ""|| $pwd2 == "")
			return " <b><h4>FAILED<br />you have empty feilds</h4></b>";
		if($pwd1 != $pwd2)
			return "<b><h4>FAILED<br />Passwords did not match</h4></b>";

        $mydatabase = new database(); 
		$adminArray = $mydatabase->getAdmin($email);
			
		print_r("outside DB");
			
		if(!isset($adminArray) || count($adminArray) < 8 )
		{					   //( $fname, $lname, $email, $pwd, $secQuestion, $secAnswer, $isActive);
			$mydatabase->addAdmin( $fname, $lname, $email, $pwd1, $secQuestion, $secAnswer, 1);
		}
		else
			return "<b><h4>FAILED<br />Account: $email already in database";

		return "<b><h4>SUCCESS<br />$email was added to the database";
	}
	
	
	function addBotPage()
	{
			$result = 
			//"<form action='' method='post'>".
			"<div class='' align='left'>".
			"<h3>ID</h3>".
			"<input type = 'Text' name = 'textbox_bot_id' pattern='[-9-0]' placeholder='-1'>".
			"<h3>First Name</h3>".
			"<input type = 'Text' name = 'textbox_bot_fname'  placeholder='Javier'>".
			"<h3>Last Name</h3>".
			"<input type = 'Text' name = 'textbox_bot_lname' placeholder='Andrial'>".
			"<h3>Email</h3>".
			"<input type = 'email' name = 'textbox_bot_email'  placeholder='bot@marketsim.edu'>".
			"<br />".
			"<br />"."<br />".
			"<input type = 'submit' value = 'Create Bot Account' class='btn btn-primary'/>".
			"</div>";
		//	"</form>";
			
		return $result;
	}
	
	
	
	function addBot( $id,$fname, $lname, $email, $hotel)
	{		
		if($fname == "" || $email == "" )
			return " <b><h4>FAILED<br />you have empty feilds</h4></b>";
		if($id > 0)
			$id=$id*-1;
		
	
        $mydatabase = new database(); 
		$botArray = $mydatabase->getStudent($email);
		$botArray2 = $mydatabase->getStudent($id);
		
		if(isset($botArray) || isset($botArray2) || count($botArray) > 0 || count($botArray2) > 0)
			return "FAILED<br />Account: $email already in database";
		else
		{			   //addStudent($id, $fname, $lname, $email, $bot,$hotel, $pwd, $secQuestion, $secAnswer, $isActive)
			$mydatabase->addStudent( $id, $fname, $lname, $email, 1   , "" , ""          ,""         , 1);
			return "SUCCESS<br />$email was added to the database";
		}

		return "unreachable line";
	}
	
	
	function getAllUsers()
	{
        $mydatabase = new database(); 
		$adminArray = $mydatabase->getAllAdmin();
        $studentArray = $mydatabase->getAllStudent();
	
		$result = '<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Role</th>
								<th>Id</th>
								<th>First name</th>
								<th>Last name</th>
								<th>Email</th>
								<th>Group</th>
								<th>is Active</th>
							</tr>
					</thead>';
		

		
		foreach($adminArray as $key => $temp )
		{
			$result = $result
			."<tbody>"
			."<tr>"
			."<td>"."Administrator"."</td>"
			."<td>".$temp["id"]."</td>"
			."<td>".$temp["fname"]."</td>"
			."<td>".$temp["lname"]."</td>"
			."<td>".$temp["email"]."</td>"
			."<td>"."null"."</td>"
			."<td>".$temp["isActive"]."</td>"
			."</tr>"
			."</tbody>";
		}

		$role ="";
		foreach($studentArray as $key => $temp )
		{
			if($temp["bot"] == 0)
				$role = "Student";
			else
				$role = "Bot";
			
			$result = $result
			."<tbody>"
			."<tr>"
			."<td>".$role."</td>"
			."<td>".$temp["id"]."</td>"
			."<td>".$temp["fname"]."</td>"
			."<td>".$temp["lname"]."</td>"
			."<td>".$temp["email"]."</td>"
			."<td>".$temp["hotel"]."</td>"
			."<td>".$temp["isActive"]."</td>"
			."</tr>"
			."</tbody>";
		}

		
        $result = $result."</table></div>";
		return $result;
	}

		
	function getAllGames()
	{
		$mydatabase = new database(); 
		$gamesArray = $mydatabase->getGameAllGames();

	
				
	
		$result = 	"<div id='container' >
						<div id='body'>
							<form id='savecascade' javascript='false' role = 'form'>
								<div id='dropdowns'>
									<div id='center' class='cascade'>
										<!--<h3>Games</h3> -->
										<div class='row'>
											<div class='col-md-8'><h3 class='alert bg-primary'>Games</h3></div>
										</div>
										<!--<select name='game' id = 'drop1'>-->
										<!--<option>Please select a game</option>-->
										<select id = 'drop1'> 
										<optgroup>										
										<!--<option value='Select a game' selected>Select a game</option>-->" ;
										foreach($gamesArray as $games) 
										{
				    			$result.= "<option value = '" .$games['id'] ."'selected>".$games['id'] ."   |   ".$games['semester'] ."   |   ".$games['course'] ."</option>";
									//$result.= "<a  href='javascript:void(0)' class='list-group-item'>" . $games['id'] . " | " . $games['semester'] . " | " . $games['course'] ."</a>";
										} 
							  $result.= "</optgroup></select> 
										
										<div class='panel-body' align='left'>
											<input name = 'new game' type = 'submit' value = 'new game' class='btn btn-primary'/>
											<input name = 'deactivate game' type = 'submit' value = 'deactivate game' class='btn btn-primary'/>
										</div>
										<div  class= 'cascade' id= 'group'></div>
										<div  class= 'cascade' id= 'student'></div>
									</div>
								<div id= 'student' class= 'cascade'></div>
								</div>
								  <!--<input type='submit' align = 'left' name='submit' value = 'New Game' class='btn btn-primary' />-->
							</form>
						</div>
					</div>";
					
		
		
		
		
		
		/*$result = 	"<div id='container' >
						<div id='body'>
							<form id='savecascade' javascript='false' role = 'form'>
								<div id='dropdowns'>
									<div id='center' class='cascade'>
										<h3>Games</h3> 
										<select name='game' id = 'drop1'>
										<option>Please select a game</option>
										
										";
										
												foreach($gamesArray as $games) 
												{
									
									//$result.= "<select><a href='#' id = 'soMcgarryShutsup'class='list-group-item' value ='" .$games['id']. "'>" .$games['id']. $games['semester'].$games['course']. $games['schedule'].$games['isActive'];
									$result.= "<option name = 'gameID' value ='". $games['id'] . "'>" .$games['id']. $games['semester'].$games['course']. $games['schedule'].$games['isActive']. "</option>";
												} 
									$result.= "</select>
									
									<div class='panel-body' align='left'>.

							
							
								<input name = 'new game' type = 'submit' value = 'new game' class='btn btn-primary'/>
								<input name = 'deactivate game' type = 'submit' value = 'deactivate game' class='btn btn-primary'/>
							
								</div>
									
									
									</div>
									<div  class= 'cascade' id= 'group'></div>
									<div id= 'student' class= 'cascade'></div>
									
									
									
									
									
									
									
										
									</div><br />
								</div> <br /> <!--<input type='submit' align = 'left' name='submit' value = 'New Game' class='btn btn-primary' />-->
							</form>
					</div></div>";
					*/
		return $result;
	}

}

?>

<script src="../jquery-1.9.0.min.js"></script>
<script>

$(document).ready(function(){
$("#savecascade").submit(function(){
var get_data=$("#savecascade").serialize();
$.ajax({
			type: "POST",
			url: "",
			data: {"csc":get_data},
			cache: false,
			success: function(html) {    
				alert(html); 
				if(html == true)
				{
				window.location.href= "/index.php";
				}
			}
		});
return false;
});

$("select#drop1").change(function(){
	
	var game_id =  $("select#drop1 option:selected").attr('value'); 
	//var game_id = document.getElementById("game id").text;
    alert(game_id);	
	$("#group").html( "" );
	$("#student").html( "" );
	if (game_id.length > 0 ) { 
		
	 $.ajax({
			type: "POST",
			url: "../fetch_group_man.php",
			data: "game_id="+ game_id,
			cache: false,
			beforeSend: function () { 
				
				$('#group').html('<img src="../loader.gif" alt="" width="24" height="24">');
			},
			success: function(html) {    
				$("#group").html( html );
				//alert(html);
			}
		});
	} 
});
}
);
</script>














