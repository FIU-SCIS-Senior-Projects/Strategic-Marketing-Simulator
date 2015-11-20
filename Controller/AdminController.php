<?php
/*created by Javier Andrial*/
ini_set('display_errors', 1);
error_reporting(~0);

require ("/srv/marketsim/www/Model/database.php");

class AdminController 
{
	function CreatePage($value)
	{	
		$result =  "<form action='' method='post'>
					<div class='bs-example'>".
						"<div class='panel panel-default'>".
							"<div class='panel-body' align='center'>".

								"<h2>User Accounts Management</h2>".
								"<a href='http://marketsim-dev.cis.fiu.edu/views/ManagePage.php?addAdminUser=Add+Admistrative+User' class='btn btn-primary'>Add Admistrative User</a>".
								"<a href='http://marketsim-dev.cis.fiu.edu/views/ManagePage.php?addBotUser=Add+Bot+User' class='btn btn-primary'>Add Bot User</a>".
								//"<a href='http://marketsim-dev.cis.fiu.edu/admin/ManagePage.php?addBotUser=Add+Bot+User&textbox_bot_id=&textbox_bot_fname=&textbox_bot_lname=&textbox_bot_email=' class='btn btn-primary'>Add Bot User</a>".
								"<a href='http://marketsim-dev.cis.fiu.edu/views/ManagePage.php?viewAllGames=View+All+Games' class='btn btn-primary'>View All Games</a>".
								"<a href='http://marketsim-dev.cis.fiu.edu/views/ManagePage.php?viewAllUsers=View+All+Users' class='btn btn-primary'>View All Users</a>".
								//"<a href='http://marketsim-dev.cis.fiu.edu/admin/ManagePage.php?viewAllUsers=View+All+Users' class='btn btn-primary'>View All Users</a>".
							"</div>".
							"<div class='' align='center'>".
							"<div class='panel-footer clearfix' style='width: 1060px' >".
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
			"<div class='' align='left'>".
			"<h3>First Name</h3>".
			"<input type = 'Text' name = 'textbox_fname' pattern='.{1,}'  placeholder='Javier' title='Name of the administrator account'>".
			"<h3>Last Name</h3>".
			"<input type = 'Text' name = 'textbox_lname' placeholder = 'Andrial' title='Last name of Admin account. not required' >".
			"<h3>Email</h3>".
			"<input type = 'email' name = 'textbox_email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' placeholder='admin@marketsim.edu'>".
			"<h3>Password</h3>".
			"<input type = 'password' name = 'textbox_password1'  pattern='.{8,}' placeholder='password' title='8 character passowrd minimum'>".
			"<h3>Re-enter Password</h3>".
			"<input type = 'password' name = 'textbox_password2'  pattern='.{8,}' placeholder='password' title='those same 8 characters you just forgot go here'>".
			"<h3>Secret Question</h3>".
			"<input type = 'Text' name = 'textbox_secretQuestion' pattern='.{1,}' placeholder='Whats my favorite website?' title='Used to recover your account incase you forget those 8 characters again'>".
			"<h3>Secret Answer</h3>".
			"<input type = 'Text' name = 'textbox_secretAnswer'  pattern='.{1,}' placeholder='marketsim-dev.cis.fiu.edu'>".
			"<br />".
			"<br />"."<br />".					
			"<input name='button_addAdmin' type = 'submit' value = 'Create Admistrative Account' class='btn btn-primary'/>".
			"</div>"
			;
		
		return $result;
	}
		
	
	function addAdmin( $fname, $lname, $email, $pwd1,$pwd2, $secQuestion, $secAnswer)
	{			
		if($fname == "" || $email == "" || $secQuestion == ""|| $secAnswer == ""|| $pwd1 == ""|| $pwd2 == "")
			return " <b><h4>FAILED<br />you have empty feilds</h4></b>";
		if(!isset($fname) || !isset($email) || !isset($secQuestion) || !isset($secAnswer)|| !isset($pwd1)|| !isset($pwd2))
			return " <b><h4>FAILED<br />you have unset feilds</h4></b>";
		if($pwd1 != $pwd2)
			return "<b><h4>FAILED<br />Passwords did not match</h4></b>";
		
        $mydatabase = new database(); 
		$adminArray = $mydatabase->getAdmin($email);
			
			
		if(!isset($adminArray) || count($adminArray) < 8 )//checks if account not in DB
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
			"<div class='' align='left'>".
			"<h3>ID</h3>".
			"<input type = 'Text' name = 'textbox_bot_id' pattern='^[+-]?\d' placeholder='-1' title='a unique number to identify this user'>".
			"<h3>First Name</h3>".
			"<input type = 'Text' name = 'textbox_bot_fname'  placeholder='Javier' title='first name of the bot'>".
			"<h3>Last Name</h3>".
			"<input type = 'Text' name = 'textbox_bot_lname' placeholder='Andrial' title='lastname, hope you're not running out of creativity! email is coming next'>".
			"<h3>Email</h3>".
			"<input type = 'email' name = 'textbox_bot_email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' placeholder='bot@marketsim.edu' title='doesnt have to be real'>".
			"<br />".
			"<br />"."<br />".
			"<input type = 'submit' value = 'Create Bot Account' class='btn btn-primary' title='only works if pressed with both eyes closed'/>".
			"</div>";
			
		return $result;
	}
	
	function addBotHotelPage()
	{
		$mydatabase = new database();
		$locationArray = $mydatabase->getAllLocation();
		$locations = "";
		$result="";
		
		
		$hotelTypes = "<input type='radio' name='hotelType' value ='economy' id='eco'> Economic".
					"<label class='radio-inline' for 'eco'>".
					"</label>".
					"<input type='radio' name='hotelType' value ='midrange' id='mid'> Midrange".
					"<label class='radio-inline' for 'mid'>".
					"</label>".	
					"<input type='radio' name='hotelType' value ='luxury' id='lux'> Luxury".	 						
					"<label class='radio-inline' for 'lux'>".
					"</label>";

		
		foreach($locationArray as $key => $temp )
		{
			$locations .="<input type='radio' name='hotelLocation' value =".$temp['id']." id=".$temp['id']."> ".$temp['type'].
						"<label class='radio-inline' for ".$temp['id'].">".
						"</label>";
		}
		
		$result = 	"<table class='table'>".
					"<tbody>".
					"<tr>".
					"<th>".
					"<h2>Create the Bot's Hotel</h2>".
					"<h3>Name of Hotel</h3>".
					"<input type = 'Text' name = 'textbox_Hotel_name' pattern='{5,}' placeholder='FIU inn'>".

					"<h3>Which Game to Assign bot to?</h3>".
					"<input type = 'Text' name = 'textbox_Hotel_game_id' require pattern='[0-9]{1,}'>".

					"<h3>Hotel Type</h3>".
					$hotelTypes.

					"<h3>Location</h3>".
					$locations.

					"<h3>First Name</h3>".
					"<input type = 'Text' name = 'textbox_bot_fname'  placeholder='Short ' title='first name of the bot'>".
					"<h3>Last Name (optional)</h3>".
					"<input type = 'Text' name = 'textbox_bot_lname' placeholder='Circuit' title='lastname of the bot'>".
					"<h3>Email</h3>".
					"<input type = 'email' name = 'textbox_bot_email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' placeholder='bot@marketsim.edu' title='doesnt have to be real'>".
					
					"<br />"."<br />".
					"<input type = 'submit' name='button_addBot' value = 'Create Bot Account' class='btn btn-primary' title='only works if pressed with both eyes closed'/>".
					"</th>".

					"<th>".
					$this->getGameList2().
					"</th>".
					"</tbody>".
					""
					;

					
		return $result;	
	}

	
	function addBot_old( $id,$fname, $lname, $email, $hotel)
	{		
		if($fname == "" || $email == "" )
			return " <b><h4>FAILED<br />you have empty fields</h4></b>";
		if(!isset($id) || !isset($fname) || !isset($lname) || !isset($email))//|| !isset($hotel))
			return " <b><h4>FAILED<br />you have unset feilds</h4></b>";
		
		if($id > 0)
			$id=$id*-1;
		
	
        $mydatabase = new database(); 
		$botArray = $mydatabase->getStudent($email);
		$botArray2 = $mydatabase->getStudent($id);
		
		if(isset($botArray) || count($botArray) > 0 )
			return "FAILED<br />Account: $email already in database";
		else if(isset($botArray2) || count($botArray2) > 0 )
			return "FAILED<br />Account ID: $id already in database";
		else
		{			   //addStudent($id, $fname, $lname, $email, $bot,$hotel, $pwd, $secQuestion, $secAnswer, $isActive)
			$mydatabase->addStudent( $id, $fname, $lname, $email, 1   , "" , ""          ,""         , 1);
			return "SUCCESS<br />$email was added to the database";
		}	
	}
	
	function addBot($Hname,$gameID,$location,$hotelType,$fname, $lname, $email)
	{		
		if($fname == "" || $email == ""|| $Hname == ""|| $gameID == ""|| $location == ""|| $hotelType == ""|| $location == "" )
			return " <b><h4>FAILED<br />you have empty fields</h4></b>";
		if(!isset($fname) || !isset($email) || !isset($Hname) || !isset($gameID) || !isset($location) || !isset($hotelType) || !isset($location) )
			return " <b><h4>FAILED<br />you have unset fields</h4></b>";
		$int = 0;
	
        $mydatabase = new database();
		$gameArray1 = $mydatabase->getGame($gameID);
		$gameArray2 = $mydatabase->getGameByCourseNumber($gameID);
		$studentArray = $mydatabase->getAllBotStudents();
	
		
		foreach($studentArray as $key => $temp )
		{
			if($int > intval($temp['id']))
				$int = intval($temp['id']);
		}
		--$int;
			
		if(!isset($gameArray1) || count($gameArray1) == 0 ) // not found, ID
		{
			if(!isset($gameArray2) || count($gameArray2) == 0 )//not found, courseNumber
				return "FAILED<br />Game: $gameID does not exist in database";
			else
			{
				$gameID = $gameArray2['id'];
			}
		}
		else
		{
			$gameID = $gameArray1['id'];
		}
		
		$myHotel = $mydatabase->newHotel($Hname, $location, $hotelType, $gameID, "", "", "", 1);	
				
		foreach($myHotel as $key => $temp )
		{
			$hotelID=$temp;
		}

		
				   //addBotStudent($id		   , $fname, $lname, $email, $bot, $hotel	 	   ,$pwd   , $secQuestion				 , $secAnswer , $isActive)
		$mydatabase->addBotStudent(strval($int), $fname, $lname, $email, 1   , intval($hotelID),"B0T20", "what are you trying to do?", "MARKETSIM", 1);
		
		return "SUCCESS<br />$email was added to the database";
	}
	
	
	
	
	function getAllUsers()
	{
        $mydatabase = new database(); 
		$adminArray = $mydatabase->getAllAdmin();
        $studentArray = $mydatabase->getAllStudent();
		$hotelArray = $mydatabase->getAllHotel();
	
		$result = '<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th></th>
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
			."<td>"."<input type='checkbox' name ='tableCheckbox[]' value='".$temp['email']."'>"."</td>"
			."<td>"."Administrator"."</td>"
			."<td>".$temp["id"]."</td>"
			."<td>".$temp["fname"]."</td>"
			."<td>".$temp["lname"]."</td>"
			."<td>".$temp["email"]."</td>"
			."<td>"."&lt;Not Set&gt;"."</td>"
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
			
			foreach($hotelArray as $key => $hotel )
			{
				if($hotel['id'] == $temp['hotel'])
				{
					$temp['hotel']=$hotel['name'];
					break;
				}
			}
			
			if($temp["hotel"] == "" || !isset($temp["hotel"]) || $temp['hotel'] == NULL)
				$temp["hotel"] = "&lt;Not Set&gt;";

			$result = $result
			."<tbody>"
			."<tr>"
			."<td>"."<input type='checkbox' name ='tableCheckbox[]' value='".$temp['email']."'>"."</td>"
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
		$result = $result."<div align='right'><input name='button_activate' type = 'submit' value = 'Activate users' class='btn btn-primary' title='Checked Accounts will be acctivated' /></div>";
		$result = $result."<div align='right'><input name='button_deactivate' type = 'submit' value = 'De-activate users' class='btn btn-primary' title='Checked Accounts will be unable to login'/></div>";
		return $result;
	}

	
	function getAllGames()
	{
		$result = $this->getGameList();
		return $result .= "</table><input name='button_createGamePage' type = 'submit' value = 'Create A Game' class='btn btn-primary'/></div>";
	}
		
	function getGameList()
	{
		$mydatabase = new database(); 
		$gamesArray = $mydatabase->getGameAllGames();
			
		$result = '<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>id</th>
								<th>Course #</th>
								<th>Course</th>
								<th>Semester</th>
								<th>Section</th>
								<th>Schedule</th>
								<th>is Active</th>
								<th>View Users</th>
							</tr>
					</thead>';
		
		foreach($gamesArray as $key => $temp )
		{
			$result = $result
			."<tbody>"
			."<tr>"
			
			."<td>".$temp["id"]."</td>"
			."<td>".$temp["courseNumber"]."</td>"
			."<td>".$temp["course"]."</td>"
			."<td>".$temp["semester"]."</td>"
			."<td>".$temp["section"]."</td>"
			."<td>".$temp["schedule"]."</td>"
			."<td>".$temp["isActive"]."</td>"
			."<td> <a href='http://marketsim-dev.cis.fiu.edu/views/ManagePage.php?viewUsersForGame=true&game=".$temp["id"]."'>Users</a></td>"
			."</tr>"
			."</tbody>";
		}
		
		return $result;
	}

	function getGameList2()
	{
		$mydatabase = new database(); 
		$gamesArray = $mydatabase->getGameAllGames();

	
		$result = //'<div class="table-responsive">.
					'<table class="table table-bordered">
						<thead>
							<tr>
								<th>id</th>
								<th>Course #</th>
								<th>Course</th>
								<th>Semester</th>
								<th>Section</th>
								<th>Schedule</th>
								<th>is Active</th>
							</tr>
					</thead>';
		
		foreach($gamesArray as $key => $temp )
		{
			$result = $result
			."<tbody>"
			."<tr>"
			
			."<td>".$temp["id"]."</td>"
			."<td>".$temp["courseNumber"]."</td>"
			."<td>".$temp["course"]."</td>"
			."<td>".$temp["semester"]."</td>"
			."<td>".$temp["section"]."</td>"
			."<td>".$temp["schedule"]."</td>"
			."<td>".$temp["isActive"]."</td>"
			."</tr>"
			."</tbody>";
		}
		
		return $result."</table>";
	}
	
	
	function createGamePage()
	{
			$result = 
			"<div class='' align='left'>".
			"<h2>Game Creation Page</h2>".
			
			"<h3>Course Number</h3>".
			"<input type = 'text' name = 'textbox_courseNumber' pattern='[0-9]{5}' placeholder = '88529' title='5 digit number'>".
			
			"<h3>Course ID</h3>".
			"<input type = 'text' name = 'textbox_courseID' placeholder = 'MAR2015'>".
			
			"<h3>Section</h3>".
			"<input type = 'text' name = 'textbox_section' placeholder='U02'>".
			
			"<h3>Semester of Game</h3>".
			"<input type = 'text' name = 'textbox_semester' placeholder='FALL 2016'>".
			
			"<h3>Course Meeting time</h3>".
			"<input type = 'text' name = 'textbox_schedule' placeholder='mwf 12pm-1:30pm'>".

			"<br />".
			"<br />"."<br />".			
			"<input name='button_addGame' type = 'submit' value = 'Create Game' class='btn btn-primary'/>".
			"</div>"
			;	
		return $result;
	}
	
	
	function createGame($semester,$courseID,$courseNumber,$section,$schedule)
	{
		if($semester == "" || $courseID == "" || $section == ""|| $schedule == "" || $courseNumber == "")
			return " <b><h4>FAILED<br />you have empty fields</h4></b>";
		if(!isset($semester) || !isset($courseID) || !isset($courseNumber) || !isset($section)|| !isset($schedule))
			return " <b><h4>FAILED<br />you have unset feilds</h4></b>";
		
		$mydatabase = new database(); 
		$gameArray = $mydatabase->getGameByCourseNumber($courseNumber);
		
		
		if(!isset($gameArray) || count($gameArray) == 0 )
		{					   
			$mydatabase->addGame($semester,$courseID,$section,$schedule,1,$courseNumber);
			$gameArray = $mydatabase->getGameByCourseNumber($courseNumber);
			$mydatabase->addNews($gameArray['id'],"This Article Has Not Yet Been Set.",$gameArray['periodNum']);
			$startDate =  date("Y")."-".date("m")."-".date("d");
			$endDate = date("Y")."-".strval((intval( date("m"))+4)%12)."-".date("d");
			print_r("endDate: ".$endDate);
			$gameArray = $mydatabase->addGame_period( $gameArray['id'], $startDate ,  $endDate, 1);
		}
		else
			return "<b><h4>FAILED<br />Game: $courseNumber already in database";
		

		return "<b><h4>SUCCESS<br />Game was added to the database";
	}
	
	function setActivateUsers($emails,$isActive)
	{
		if(!isset($emails) || !isset($isActive) || !is_int($isActive))
			return "Fail: Fields not set";
		
		if(count($emails) <1)
			return "No Users Selected";
		$mydatabase = new database();
		$output = "";
		$i = 1;
		
		foreach($emails as $temp )
		{
			if($mydatabase->setStudentActive($temp,$isActive) == "fail")
				if($temp == "admin@marketsim.com")
					$output.="<br /> ".$i.". ".$temp.": fail";
				else
					$output.="<br /> ".$i.". ".$temp.": ".$mydatabase->setAdminActive($temp,$isActive);
			else
				$output.="<br /> ".$i.". ".$temp.": pass";
			$i++;
		}
		
		return $output;
	}
	
	function deactivateUsers($emails)
	{
		return $this->setActivateUsers($emails,0);
	}
	function activateUsers($emails)
	{
		return $this->setActivateUsers($emails,1);
	}
	
	function viewUsersForGame($game)
	{	
		if(!isset($game) || $game == '')
			return "Failed: An Error occured";
	
	
	    $mydatabase = new database(); 
        $studentArray = $mydatabase->getAllStudentinGame($game);
		$hotelArray = $mydatabase->getAllHotel();
	
		$result = '<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th></th>
								<th>Role</th>
								<th>Id</th>
								<th>First name</th>
								<th>Last name</th>
								<th>Email</th>
								<th>Group</th>
								<th>is Active</th>
							</tr>
					</thead>';
	

		$role ="";

		foreach($studentArray as $key => $temp )
		{
			if($temp["bot"] == 0)
				$role = "Student";
			else
				$role = "Bot";

			foreach($hotelArray as $key => $hotel )
			{
				if($hotel['id'] == $temp['hotel'])
				{
					$temp['hotel']=$hotel['name'];
					break;
				}

			}

			$result = $result
			."<tbody>"
			."<tr>"
			."<td>"."<input type='checkbox' name ='tableCheckbox[]' value='".$temp['email']."'>"."</td>"
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
		
		$result .="</table></div>";
		$result .="<div align='right'><input name='button_activate' type = 'submit' value = 'Activate users' class='btn btn-primary'/></div>";
		$result .="<div align='right'><input name='button_deactivate' type = 'submit' value = 'De-activate users' class='btn btn-primary'/></div>";
		
		
		return $result;
	}

}







?>






