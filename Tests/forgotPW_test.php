<?php
//ini_set("include_path",get_include_path().":/srv/marketsim/www");
ini_set('display_errors', 1);
error_reporting(~0);

	class case_class //extends PHPUnit_Framework_TestCase
	{
		//creating page
		public function case1()
		{
			return "<form action='' method='post' style='height: 300px; width: 300px'><br />".
                "<br />".
                "<h2>Forgot Password</h2>".       
                "<h3> Reset password </h3>".
                "<br />".
                "E-mail or PID: ".
                "<br />".
                "<input type = 'Text' name = 'textbox_txt' required placeholder='abcef012@fiu.edu'>".
				"<br />".
				"<br />".
                "<input type = 'submit' value = 'Find my account' class='btn btn-primary'/>".
				"<br />".
				"<h5>Enter email or Panther ID to reset your password</h5>".
            "</form>";
			//return "<form action='' method='post' style='height: 300px; width: 300px'><br /><br /><h2>Forgot Password</h2><h3>Reset password </h3><br />E-mail or PID:<br /><input type = 'Text' name = 'textbox_txt' required placeholder='abcef012@fiu.edu'><br /><br /><input type = 'submit' value = 'Find my account' class='btn btn-primary'/><br /><h5>Enter email or Panther ID to reset your password</h5></form>";
 
		}
		//account look up
		public function case2($value)
		{
			return " <b><h4>Account: - $value - was not Found</h4></b>";
		}
		
		public function case3($email,$secretQuestion)
		{
			/*return "<form action='' method='post' style='height: 240px; width: 269px'>".
						"<b><h4>Account:</h4></b>".
						"<h4>$email</h4>".
						"<br />".
						"<b><h4>Secret Question:</h4></b>".
						"$secretQuestion".
						"<br />".
						"<br />".
						"<input type = 'Text' name = 'textbox_secretAns' required placeholder='cats'>".
						"<br />".
						"<br />".
						"Please Enter a new password for your account".
						"<br />".
						"<input type = 'password' name = 'textbox_newPass' required pattern='.{8,}' placeholder='abcd1234'>".
						"<br />".
						"<br />".
						"<input type = 'submit' value = 'Reset password' class='btn btn-primary'/>".
						"<br />".
						"<br />".
						"<h5>Please Enter your secret answer to reset your password</h5>".
						"<br />".
						"<br />".
						"<br />".
				"</form>";*/
				
		   return "<form action='' method='post' style='height: 240px; width: 269px'><b><h4>Account:</h4></b><h4>".$email." </h4><br /><b><h4>Secret Question:</h4></b>".$secretQuestion."<br /><br /><input type = 'Text' name = 'textbox_secretAns' required placeholder='cats'><br /><br />Please Enter a new password for your account<br /><input type = 'password' name = 'textbox_newPass' required pattern='.{8,}' placeholder='abcd1234'><br /><br /><input type = 'submit' value = 'Reset password' class='btn btn-primary'  /><br /><br /><h5>Please Enter your secret answer to reset your password</h5><br /><br /><br /></form>";   
 
				
		}
		
		//reset password
		public function case4()
		{
			return "FAILURE TO LOOK UP ENTRY IN THE DATABASE";
		}
		
		public function case5()
		{
			/*return " <tr>
                            <th>secret answer match</th>
                        </tr>
                        <tr>
                            <th>password has been changed</th>
                        </tr>";*/
			$result = "<tr><th>Secret answer matched.</th></tr><tr><th> Password has been changed</th></tr>";		
			return $result;
		}
		
		public function case6()
		{
			return "<tr><th>secret answer did not match. </th><th> Password was not changed</th></tr>";
			
			/*return "<tr>".
                            "<th>secret answer match</th>".
                        "</tr>".
                        "<tr>".
                           "<th>password has been changed</th>".
                        "</tr>";*/
		}
		
	}
	

require 'forgotPW_test_class.php';
$case = new case_class();

$myTest = new forgotPW_test_class();

$content = "";
$myResults = "";
$email ="jandr018@fiu.edu";
$secretQuestion = "What is the name of your pet";
$secretAns = "RYLEE";
$newpassword = "abcd1234";


//create page

$myResults = $myResults.$myTest->test_CreateForgotPage($case->case1(),"Draws content on page. Case1"); // returns page
//
$myResults = $myResults."- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -";
//find account
$myResults = $myResults.$myTest->test_findStudentAccount("85485",$case->case2("85485"),"Account does not exist. case2"); // account not found
$myResults = $myResults.$myTest->test_findStudentAccount("",$case->case2(""),"Empty String. textbox pervents empty string. case2"); // account not found
$myResults = $myResults.$myTest->test_findStudentAccount("_%%@@**",$case->case2("_%%@@**"),"Account does not exist. case2"); // account not found
//
$myResults = $myResults.$myTest->test_findStudentAccount("3578336",$case->case3($email,$secretQuestion),"Account Exist. case3"); // account found
//
$myResults = $myResults."- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -";
//reset password
$myResults = $myResults.$myTest->test_resetPassword("acbhi@fiu.fiu",$secretAns,$newpassword,$case->case4(),"Unable to Find Account. case4"); // unable to lookup user
$myResults = $myResults.$myTest->test_resetPassword("",$secretAns,$newpassword,$case->case4(),"Unable to Find Account. case4"); // unable to lookup user
$myResults = $myResults.$myTest->test_resetPassword("$#!~#",$secretAns,$newpassword,$case->case4(),"Unable to Find Account. case4"); // unable to lookup user
//
//$t = time();

$myResults = $myResults.$myTest->test_resetPassword($email,$secretAns,$newpassword,$case->case5(),"Succesfully changed password. case5"); // verything matched
//

$myResults = $myResults.$myTest->test_resetPassword($email,"123",$newpassword,$case->case6(),"secret Question did not match. case6"); // secretAns did not match
$myResults = $myResults.$myTest->test_resetPassword($email,"",$newpassword,$case->case6(),"secret Question did not match. textBox prevents empty string. case6"); // secretAns did not match
$myResults = $myResults.$myTest->test_resetPassword($email,"@$&*^%",$newpassword,$case->case6(),"secret Question did not match. case6"); // secretAns did not match
//
$myResults = $myResults."- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -";

$title = "Forgot Password Testing";

$content = $myResults;

print_r($content);
//include '../template.php';

?>








