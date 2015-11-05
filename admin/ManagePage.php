<?php
/*
print_r($_POST);
exit;*/
/*created by Javier Andrial
Date Finished: Oct 01 2015*/
ini_set('display_errors', 1);
error_reporting(~0);

require '../Controller/AdminController.php';
$adminController = new AdminController();


$title = "";
$content = "";
$value = "";


//if(isset($_POST['textbox_fname']) )//add admin
if(isset($_POST['button_addAdmin']) )//add admin
{
	$fname = $_POST['textbox_fname'];
	$lname = $_POST['textbox_lname'];
	$email = $_POST['textbox_email'];
	$pwd1 = $_POST['textbox_password1'];
	$pwd2 = $_POST['textbox_password2'];
	$secQuestion = $_POST['textbox_secretQuestion'];
	$secAnswer = $_POST['textbox_secretAnswer'];

	
	$value = $adminController->addAdmin( $fname, $lname, $email, $pwd1, $pwd2,$secQuestion, $secAnswer);
}
else if(isset($_POST['button_addBot']) ) //add bot
{
	$location="";
	$hotelType="";
	$Hname = $_POST['textbox_Hotel_name'];
	$gameID = $_POST['textbox_Hotel_game_id'];
	
	if(isset($_POST['hotelLocation']))
		$location = $_POST['hotelLocation'];
	if(isset($_POST['hotelType']))
		$hotelType = $_POST['hotelType'];
	
	$fname = $_POST['textbox_bot_fname'];
	$lname = $_POST['textbox_bot_lname'];
	$email = $_POST['textbox_bot_email'];
		
	$value = $adminController->addBot($Hname,$gameID,$location,$hotelType,$fname, $lname, $email);
}
else if(isset($_POST['button_createGamePage']))
{
	$value = $adminController->createGamePage();
}
else if(isset($_POST['button_addGame']) ) //add Game
{
	$courseNumber = $_POST['textbox_courseNumber'];
	$courseID = $_POST['textbox_courseID'];
	$section = $_POST['textbox_section'];
	$semester = $_POST['textbox_semester'];
	$schedule = $_POST['textbox_schedule'];
	
	$value = $adminController->createGame($semester,$courseID,$courseNumber,$section,$schedule);
}
else if(isset($_POST['button_activate']))
{
	if(isset($_POST['tableCheckbox']))
		$value = $adminController->activateUsers($_POST['tableCheckbox']);
	else
		$value = "No Users Selected";
}
else if(isset($_POST['button_deactivate']))
{
	if(isset($_POST['tableCheckbox']))
		$value = $adminController->deactivateUsers($_POST['tableCheckbox']);
	else
		$value = "No Users Selected";
}

else if(isset($_GET['addAdminUser'])) // draw admin page
{
	$value = $adminController->addAdminPage();
}
else if(isset($_GET['addBotUser']))
{
	//$value = $adminController->addBotPage();
	$value = $adminController->addBotHotelPage();
}
else if(isset($_GET['viewAllGames']))
{
	$value = $adminController->getAllGames();
}
else if(isset($_GET['viewAllUsers']))
{
	$value = $adminController->getAllUsers();
}
else if(isset($_GET['viewUsersForGame']))
{
	$value = $adminController->viewUsersForGame($_GET['game']);
}
else
{
		//Session checking
		/*if (isset($_SESSION['admin login'])) 
		{

		}
		else
		{
			header('Location: /login.php');
			exit;
		}*/
}


$content = $adminController->CreatePage($value);


$title = "User Accounts Management";
//$content = "<h1 style = 'color:blue' align='center'>Strategic Marketing Simulator</h1> 
//		<p style = 'color:blue' align='center'>The Manage page is still under construction</p>";
		
include '../Styles/ManageTemplate.php';
?>
