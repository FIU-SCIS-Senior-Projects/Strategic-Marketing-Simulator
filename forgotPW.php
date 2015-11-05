<?php
/*created by Javier Andrial*/
ini_set('display_errors', 1);
error_reporting(~0);

require 'Controller/StudentController.php';
$studentController = new StudentController();


session_start();

if(isset($_POST['textbox_newPass']) || isset($_POST['textbox_secretAns']))
{
    if(isset($_POST['textbox_newPass']) && isset($_POST['textbox_secretAns']))
    {
		$email = $_SESSION['forgotPassword'];
        $found = $studentController->resetPassword($email, $_POST['textbox_secretAns'], $_POST['textbox_newPass']);
    }
    else
	{
        $found = "You must fill both Secret Answer and New Password feilds before proceeding";
	}
	
		
	if (isset($_SESSION['forgotPassword'])) 
	{
		unset($_SESSION['forgotPassword']);
	}
}
else if(isset($_POST['textbox_txt']))
{
    $found = $studentController->findStudentAccount($_POST['textbox_txt']); 
}
else
{
    $found = $studentController->CreateForgotPage();
}



$title = "Forgot Password";
$content = $found;

//include 'Styles/ManageTemplate.php';
include 'template.php';
?>










