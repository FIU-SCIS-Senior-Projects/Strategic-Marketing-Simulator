<?php


require '../Controller/AdminController.php';
//require '../Model/database.php';

class AdminControllerTest extends \PHPUnit_Framework_TestCase
{ 
	/**
     * @covers a
     */
	
	  public function test__AdminControllerconstructInvalidPar()
    {
        $m = new AdminController('aaa');
        $this->assertInstanceOf(AdminController::class, $m);
        return $m;
    }
	 /**
     * @covers a
     */
	 public function test__construcValidPar()
    {
        $m = new AdminController();
        $this->assertInstanceOf(AdminController::class, $m);
        return $m;
    }
	 /**
     * @covers a
     */
	 function test_CreatePage()
	 {
		 $a = new AdminController();
		 $value = $a->viewUsersForGame(3);
		 $return = "<form action='' method='post'>
					<div class='bs-example'>".
						"<div class='panel panel-default'>".
							"<div class='panel-body' align='center'>".

								"<h2>User Accounts Management</h2>".
								"<a href='http://marketsim-dev.cis.fiu.edu/admin/ManagePage.php?addAdminUser=Add+Admistrative+User' class='btn btn-primary'>Add Admistrative User</a>".
								"<a href='http://marketsim-dev.cis.fiu.edu/admin/ManagePage.php?addBotUser=Add+Bot+User' class='btn btn-primary'>Add Bot User</a>".
								//"<a href='http://marketsim-dev.cis.fiu.edu/admin/ManagePage.php?addBotUser=Add+Bot+User&textbox_bot_id=&textbox_bot_fname=&textbox_bot_lname=&textbox_bot_email=' class='btn btn-primary'>Add Bot User</a>".
								"<a href='http://marketsim-dev.cis.fiu.edu/admin/ManagePage.php?viewAllGames=View+All+Games' class='btn btn-primary'>View All Games</a>".
								"<a href='http://marketsim-dev.cis.fiu.edu/admin/ManagePage.php?viewAllUsers=View+All+Users' class='btn btn-primary'>View All Users</a>".
							"</div>".
							"<div class='' align='center'>".
							"<div class='panel-footer clearfix' style='width: 1060px' >".
							$value.
						   "</div>".
						"</div>".
					"</div>".
					"</div>".
					"</form>";	
		
		return $this->assertEquals($a->CreatePage($value), $return);
					
		 
	 }
	  /**
     * @covers a
     */
	 
	 
	 function test_addAdminPage()
	 {
		 $a = new AdminController();
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
			//"<a href='http://marketsim-dev.cis.fiu.edu/admin%20shit/adminUsers.php?textbox_fname=&textbox_lname=&textbox_email=&textbox_password1=&textbox_password2=&textbox_secretQuestion=&textbox_secretAnswer=&button_addAdmin=Create+Admistrative+Account' class='btn btn-primary'>View All Users</a>".
						
			"<input name='button_addAdmin' type = 'submit' value = 'Create Admistrative Account' class='btn btn-primary'/>".
			"</div>"
			;
		 return $this->assertEquals($a->addAdminPage(), $result);
	 }
	  /**
     * @covers a
     */
	 function test_addBotPage()
	 {
		 $a = new AdminController();
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
		 return $this->assertEquals($a->addBotPage(), $result);
	 }
	   /**
     * @covers a
     */
	 function test_addBotHotelPage()
	 { //addBotHotelPage($botId,$botFname, $botLname, $botEmail)
		$a = new AdminController();
		 $db = new database();
		 $db->newHotel("bot Hotel Test", 12345, "economy", 1, 50000.00, 50000, 50, -1);
		 $this->assertGreaterThan(0,count($db->newHotel("bot Hotel Test", 12345, "economy", 1, 50000.00, 50000, 50, -1)));
		 $result = 
			"<div class='' align='left'>".
			"<h2>Create the Bot's Hotel</h2>".
			
			"<h3>Which Game to Assign bot to?</h3>".
			"<input type = 'Text' name = 'textbox_Hotel_game_id' require>".
			
			
			"<h3>Name of Hotel</h3>".
			"<input type = 'Text' name = 'textbox_Hotel_name' pattern='^[+-]\d' placeholder='FIU inn'>".
			"<h3>Location</h3>".
			"<input type = 'Text' name = 'textbox_Hotel_fname'  placeholder='Florida'>".
			"<h3>Hotel Type</h3>".
			
			"<label class='radio-inline' >".
			"<input type='radio' name='optradio' value ='economic'>Economic".
			"</label>".
			"<label class='radio-inline' for 'mid'>".
			"<input type='radio' name='optradio'  value ='midrange'>Midrange".
			"</label>".
			"<label class='radio-inline' for 'lux'>".
			"<input type='radio' name='optradio' value ='luxury'>Luxury".
			"</label>".
			
			

			
			

			"<br />".
			"<br />"."<br />".
			"<input type = 'submit' value = 'Create Bot Account' class='btn btn-primary'/>".
			"</div>";	
		 return $this->assertEquals($a->addBotHotelPage(-4,"bot4", "bot4","bot4@marketsim.com"), $result);
	 }
	   /**
     * @covers a
     */
	 function test_createGamePage()
	 {
		 $a = new AdminController();
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
		 return $this->assertEquals($a->createGamePage(), $result);
	 }
	 
}
?>