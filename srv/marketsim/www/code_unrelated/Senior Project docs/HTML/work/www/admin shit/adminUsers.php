<?php
/*
print_r($_POST);
exit;*/
/*created by Javier Andrial*/
ini_set('display_errors', 1);
error_reporting(~0);

require '../Controller/AdminController.php';
$adminController = new AdminController();


$title = "";
$content = "";

$value = "notset";
$method = 'post';




if(isset($_POST['textbox_fname']) )//add admin
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
else if(isset($_POST['textbox_bot_fname']) ) //add bot
{
	$id = $_POST['textbox_bot_id'];
	$fname = $_POST['textbox_bot_fname'];
	$lname = $_POST['textbox_bot_lname'];
	$email = $_POST['textbox_bot_email'];
	
	$value = $adminController->addBot( $id,$fname, $lname, $email, null);
}


else if(isset($_POST['button_activate']))
{
	$value = $adminController->activateUsers($_POST['tableCheckbox']);
}
else if(isset($_POST['button_deactivate']))
{
	//$value = $adminController->activateUsers($_POST['tableCheckbox']);
	$value = $adminController->deactivateUsers($_POST['tableCheckbox']);
}

else if(isset($_GET['addAdminUser'])) // draw admin page
{
	$value = $adminController->addAdminPage();
}
else if(isset($_GET['addBotUser']))
{
	$value = $adminController->addBotPage();
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



$content = $adminController->CreatePage($value,$method);


$title = "User Accounts Management";
//$content = "<h1 style = 'color:blue' align='center'>Strategic Marketing Simulator</h1> 
//		<p style = 'color:blue' align='center'>The Manage page is still under construction</p>";
		
include '../Styles/ManageTemplate.php';
?>






















