<?php

	/*created by Javier Andrial
	Date Finished: Nov  2015*/
	ini_set('display_errors', 1);
	error_reporting(~0);

	require '../Controller/AccountController.php';
	
	
class accountManageTest extends \PHPUnit_Framework_TestCase
{
	/**
     * @covers a
     */
	public function test__AccountControllerconstructInvalidPar()
    {
        $m = new AccountController('aaa');
        $this->assertInstanceOf(AccountController::class, $m);
        return $m;
    }
	 /**
     * @covers a
     */
	public function test__construcValidPar()
    {
        $m = new AccountController();
        $this->assertInstanceOf(AccountController::class, $m);
        return $m;
    }
	 /**
     * @covers a
     */
	function test_CreatePage()
	{
		 $a = new AccountController();
		 $value = $a->changeRecoveryPage();
		 $result =  "<form action='' method='post'>".
						"<div class='' align='center'>".
							"<div class='panel-footer clearfix' style='margin:auto; width:30%;' >".
							
							$value.
							"</div>".
						"</div>".
					"</form>";
		
		return $this->assertEquals($a->CreatePage($value), $result);
	}

	  /**
     * @covers a
     */
	function test_UserInfoPage()
	{
		$a = new AccountController();
		$user = $a->getUserInfo("jandr018@fiu,edu");
		 
						
			
		$result = "<h3>My Account</h3><br /><br />".
				  "<div class='table-responsive'>".
				  "<table class='table table-bordered'>";
		$result .= "<tbody>".
					"<tr>".
						"<td>"."<strong>Role: </strong>"."</td>".
						"<td>".($user['isAdmin']?"Admin":"Student")."</td>".
					"</tr>".
					"<tr>".
						"<td>"."<strong>PID: </strong>"."</td>".
						"<td>".$user['id']."</td>".
					"</tr>".
					"<tr>".
						"<td>"."<strong>Name: </strong>"."</td>".
						"<td>".$user['fname']." ".$user['lname']."</td>".
					"</tr>".
					"<tr>".
						"<td>"."<strong>Email: </strong>"."</td>".
						"<td>".$user['email']."</td>".
					"</tr>".
					"<tr>".
						"<td>"."<strong>Recovery Question: </strong>"."</td>".
						"<td>".$user['secQuestion']."</td>".
					"</tr>".
				"</tbody></table>".
				"</div>";			
			$result .= "<br />".
				"<br />".
				"<br />".
				"<a href='http://marketsim-dev.cis.fiu.edu/Account%20Manage/accountManage.php?button_ChangeMyRecovery=Change+My+Recovery+Quest%2FAns' class='btn btn-primary'>Change My Recovery Quest/Ans</a>".
				" ".
				"<a href='http://marketsim-dev.cis.fiu.edu/Account%20Manage/accountManage.php?button_ChangeMyPassword=Change+My+Password' class='btn btn-primary'>Change My Password</a>";
				
		return $this->assertEquals($a->UserInfoPage($user), $result);
	 }

	 
	  /**
     * @covers a
     */
	 function test_getUserInfo()
	 {
		$m = new AccountController();
		$email = "jandr018@fiu";
		$t_user = $m->getUserInfo($email);
		 

	    $mydatabase = new database();     
        $user = $mydatabase->getStudent($email);
		$isAdmin = false;
        if(!isset($user) || count($user) < 10 )
        {          
			$isAdmin = true;
			$user = $mydatabase->getAdmin($email);
	        if(!isset($user) || count($user) < 8 )
				return "<b><h4>Account: - ".$value." - was not Found</h4></b>";
        }
		$user['isAdmin'] = $isAdmin;
		 
		 
		      
        $this->assertInstanceOf($user, $t_user);
        return $m;
	 }

	 /**
     * @covers a
     */
	 function test_addBotHotelPage()
	 { 
		$a = new AccountController();

		$result = 
			"<h3>Change My Password</h3>".
			"<br /><br />".
				"<div class='' style='margin:auto; width:30%;'>".
					"<div class='' align='left'>".
						"<h4>Current Password</h4>".
						"<input type = 'password' name = 'textbox_CurrentPass1' required pattern='.{8,}' >".
						"<h4>New Password</h4>".
						"<input type = 'password' name = 'textbox_NewPass' required pattern='.{8,}' >".
					"</div>".
				"</div>".
			"<br />".
			"<br />"."<br />".
			"<input name='button_ChangedPassword' type = 'submit' class='btn btn-primary' value = 'Change Password'/>";
			
		 return $this->assertEquals($a->changePasswordPage(), $result);
	 }

	 
	 /**
     * @covers a
     */
	 function test_changeRecoveryPage()
	 {
		 $a = new AccountController();
			$result = "<h3>Change My Recovery Question/Answer</h3><br /><br />".
			"<div class='' style='margin:auto; width:30%;'>".
			"<div class='' align='left'>".
			"<h5>Current Password</h5>".
			"<input type = 'password' name = 'textbox_CurrentPass2' required pattern='.{8,}' >".
			"<h5>New Recovery Question</h5>".
			"<input type = 'text' name = 'textbox_NewQestion' required >".
			"<h5>Recovery Answer</h5>".
			"<input type = 'text' name = 'textbox_NewAnswer' required >".
			"</div>".
			"</div>".
			"<br />".
			"<br />".
			"<br />".
			"<input type = 'submit' name='button_ChangedRecovery' class='btn btn-primary' value = 'Change Recovery Quest/Ans' />";
		 return $this->assertEquals($a->changeRecoveryPage(), $result);
	 }
 	  /**
     * @covers a
     */
 	 function test_updateRecovery()
	 {
		 $a = new AccountController();
		 $result = "";
		 $user =$a->getUserInfo("jandr018@fiu");
		 $currentPS = "x12penpw";
		 $newQuestion = "what is the name of your pet?";
		 $newAns = "Rylee";
		 
		 
		if($user['email'] == "" || $currentPS == "" || $newQuestion == "" || $newAns == "" )
		{
			$result = "You have unset values";
			return $this->assertEquals(updateRecovery($user,$currentPS,$newQuestion,$newAns), $result);
		}
	
        $mydatabase = new database();     

		if($mydatabase->genPass($currentPS,$user['email']) != $user['password'])
		{
			$result = "Incorrect Password";
			return $this->assertEquals(updateRecovery($user,$currentPS,$newQuestion,$newAns), $result);
		}
		
		if(!$user['isAdmin'])
		{
			$mydatabase->updateStudentQuestion($user['email'], $newQuestion, $user['id']);
			$mydatabase->updateStudentAnswer($user['email'], $newAns, $user['id']);
		}
		else if($user['isAdmin'])
		{
			$mydatabase->updateAdminQuestion($user['email'], $newQuestion, $user['id']);
			$mydatabase->updateAdminAnswer($user['email'], $newAns, $user['id']);
		}
		else
		{
			$result = "An error occured";
			return $this->assertEquals($a->updateRecovery($user,$currentPS,$newQuestion,$newAns), $result);
		}
		
		$result = "pass";
		return $this->assertEquals($a->updateRecovery($user,$currentPS,$newQuestion,$newAns), $result);
	 }
 
	  /**
     * @covers a
     */
	 function test_updatePassword()
	 {
		$a = new AccountController();
		$result = "";
		$user = $a->getUserInfo("jandr018@fiu");
		$currentPS = "x12penpw";
		$newPass = "x12penpw";
		 

		if($user['email'] == "" || $currentPS == "" || $newPass == "" )
		{
			$result = "You have unset values";
			return $this->assertEquals($a->updatePassword($user,$currentPS,$newPass), $result);
		}
	
        $mydatabase = new database();

		
		if($mydatabase->genPass($currentPS,$user['email']) != $user['password'])
		{
			$result = "Incorrect Password";
			return $this->assertEquals($a->updatePassword($user,$currentPS,$newPass), $result);
		}
		
		if(!$user['isAdmin'])
		{
			$mydatabase->updateStudentPassword_by_id($user['email'], $newPass, $user['id']);
		}
		else if($user['isAdmin'])
		{
			$mydatabase->updateAdminPassword_by_id($user['email'], $newPass, $user['id']);
		}
		else
		{

			$result = "An error occured";
			return $this->assertEquals($a->updatePassword($user,$currentPS,$newPass), $result);
		}
		

		$result = "pass";
		return $this->assertEquals($a->updatePassword($user,$currentPS,$newPass), $result);
	 }
	

}
?>
