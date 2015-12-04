<?php

//require '../Model/database.php';
require '../Controller/AccountController.php';

class databasetest extends \PHPUnit_Framework_testCase
{
	/**
     * @covers a
     */

function test_CreatePage()
	{	
		$obj = new AccountController;
		$value = "someValue";
		$result =  "<form action='' method='post'>".
						"<div class='' align='center'>".
							"<div class='panel-footer clearfix' style='margin:auto; width:30%;' >".
							
							$value.
							"</div>".
						"</div>".
					"</form>";

		return $this->assertEquals($result, $obj->CreatePage($value));
		
		
	}
	/**
     * @covers a
     */
	function test_changePasswordPage()
	{
			$obj = new AccountController();
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
			//"</div>".
			"<input name='button_ChangedPassword' type = 'submit' class='btn btn-primary' value = 'Change Password'/>";
			//"<a href='http://marketsim-dev.cis.fiu.edu/Account%20Manage/accountManage.php?button_ChangedPassword=Change+Password' class='btn btn-primary'>Change My Password</a>";
					
		return $this->assertEquals($result, $obj->changePasswordPage());
	}
	/**
     * @covers a
     */
		function test_changeRecoveryPage()//style='margin:auto; width:30%;'
	{
			$obj = new AccountController();
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
			//"<a href='http://marketsim-dev.cis.fiu.edu/Account%20Manage/accountManage.php?button_ChangedRecovery=Change+Recovery+Quest%2FAns' class='btn btn-primary'>Change My Password</a>";
			
		return $this->assertEquals($result, $obj->changeRecoveryPage());
	}
	
	/**
     * @covers a
     */
	
	
	
	
}


?>