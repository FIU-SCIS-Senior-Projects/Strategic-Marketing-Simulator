<?php
/*created by Javier Andrial*/
ini_set('display_errors', 1);
error_reporting(~0);

require '../Controller/AdminController2.php';
$adminController2 = new AdminController2();

$title = "";
$content = "";

$value = "notset";
$method = 'post';

if(isset($_POST['textbox_fname']) )
{
	$fname = $_POST['textbox_fname'];
	$lname = $_POST['textbox_lname'];
	$email = $_POST['textbox_email'];
	$pwd1 = $_POST['textbox_password1'];
	$pwd2 = $_POST['textbox_password2'];
	$secQuestion = $_POST['textbox_secretQuestion'];
	$secAnswer = $_POST['textbox_secretAnswer'];

	/*print_r($fname);
	print_r($lname);
	print_r($email);
	print_r($pwd1);
	print_r($pwd2);
	print_r($secQuestion);
	print_r($secAnswer);*/
	
	$value = $adminController2->addAdmin( $fname, $lname, $email, $pwd1, $pwd2,$secQuestion, $secAnswer);
}
if(isset($_POST['textbox_bot_fname']) )
{
	$id = $_POST['textbox_bot_id'];
	$fname = $_POST['textbox_bot_fname'];
	$lname = $_POST['textbox_bot_lname'];
	$email = $_POST['textbox_bot_email'];
	//$hotel = $_POST['textbox_bot_hotel'];

	/*print_r($fname);
	print_r($lname);
	print_r($email);
	print_r($pwd1);
	print_r($pwd2);
	print_r($secQuestion);
	print_r($secAnswer);*/
	
	$value = $adminController2->addBot( $id,$fname, $lname, $email, null);
}
else if(isset($_GET['addAdminUser']))
{
	$value = $adminController2->addAdminPage();
	//$method = 'post';
}
else if(isset($_GET['addBotUser']))
{
	$value = $adminController2->addBotPage();
}
else if(isset($_GET['viewAllGames']))
{
	$value = $adminController2->getAllGames();
}
else if(isset($_GET['viewAllUsers']))
{
	$value = $adminController2->getAllUsers();
}




$content = $adminController2->CreatePage($value,$method);








$title = "User Accounts Management";
//$content = "<h1 style = 'color:blue' align='center'>Strategic Marketing Simulator</h1> 
//		<p style = 'color:blue' align='center'>The Manage page is still under construction</p>";
		
include '../Styles/ManageTemplate.php';
?>