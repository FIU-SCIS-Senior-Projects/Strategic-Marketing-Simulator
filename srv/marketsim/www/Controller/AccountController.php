<?php
/*created by Javier Andrial*/
ini_set('display_errors', 1);
error_reporting(~0);

require ("/srv/marketsim/www/Model/database.php");

class AccountController 
{
	function CreatePage($value)
	{	
		$result =  "<form action='' method='post'>".
						"<div class='' align='center'>".
							"<div class='panel-footer clearfix' style='margin:auto; width:30%;' >".
							
							$value.
							"</div>".
						"</div>".
					"</form>";				
		
		return $result;
	}
	
	function UserInfoPage($user)
	{
		if(!isset($user) || count($user) == 0)
		{
			return " <b><h4>Account was not Found</h4></b>";
		}
	
       /* $mydatabase = new database();     
        $user = $mydatabase->getStudent($email);*/


     /*   if(!isset($user) || count($user) < 10 )
        {          
			$user = $mydatabase->getAdmin($email);
	        if(!isset($user) || count($user) < 8 )
				return "<b><h4>Account: - ".$value." - was not Found</h4></b>";
        }*/
				
			
		$result = 	"<h3>My Account</h3><br /><br />".
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
				//"<input name='button_ChangeMyRecovery' type = 'submit' value = 'Change My Recovery Quest/Ans' class='btn btn-primary'/>".
				//"<a href='http://marketsim-dev.cis.fiu.edu/Account%20Manage/accountManage.php?button_ChangeMyRecovery=Change+My+Recovery+Quest%2FAns' class='btn btn-primary'>Change My Recovery Quest/Ans</a>".
				"<a href='http://marketsim-dev.cis.fiu.edu/views/accountManage.php?button_ChangeMyRecovery=Change+My+Recovery+Quest%2FAns' class='btn btn-primary'>Change My Recovery Quest/Ans</a>".
				" ".
				//"<input name='button_ChangeMyPassword' type = 'submit' value = 'Change My Password' class='btn btn-primary'/> ".
				"<a href='http://marketsim-dev.cis.fiu.edu/views/accountManage.php?button_ChangeMyPassword=Change+My+Password' class='btn btn-primary'>Change My Password</a>";
			
			
			
		return $result;
	}
	
	function getUserInfo($email)
	{
		if($email == "")
			return "no current email";
		
		
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
		return $user;
	}
	
		
	
	function changePasswordPage()
	{
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
					
		return $result;
	}
	
	
	function changeRecoveryPage()//style='margin:auto; width:30%;'
	{
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
			
		return $result;
	}
	
	function updateRecovery($user,$currentPS,$newQuestion,$newAns)
	{
		if($user['email'] == "" || $currentPS == "" || $newQuestion == "" || $newAns == "" )
		{
			return "You have unset values";
		}
	
        $mydatabase = new database();     

		
		if($mydatabase->genPass($currentPS,$user['email']) != $user['password'])
			return "Incorrect Password";
		
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
			return "An error occured";
		
		return "pass";
	}
	
	function updatePassword($user,$currentPS,$newPass)
	{
		if($user['email'] == "" || $currentPS == "" || $newPass == "" )
		{
			return "You have unset values";
		}
	
        $mydatabase = new database();     

		
		if($mydatabase->genPass($currentPS,$user['email']) != $user['password'])
			return "Incorrect Password";
		
		if(!$user['isAdmin'])
		{
			$mydatabase->updateStudentPassword_by_id($user['email'], $newPass, $user['id']);
		}
		else if($user['isAdmin'])
		{
			$mydatabase->updateAdminPassword_by_id($user['email'], $newPass, $user['id']);
		}
		else
			return "An error occured";
		
		return "pass";
	}
	
	
	
	

}

?>






