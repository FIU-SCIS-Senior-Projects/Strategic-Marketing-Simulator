<?php
	/*
	print_r($_POST);
	exit;*/
	/*created by Javier Andrial
	Date Finished: Oct  2015*/
	ini_set('display_errors', 1);
	error_reporting(~0);

	require '../Controller/AccountController.php';
	$accountController = new AccountController();

	$email = "";
	$title = "";
	$content = "";
	$value = "5";
	$user = null;

		session_start();
		if (isset($_SESSION['admin login'])) 
		{
			$email = $_SESSION['admin login'];
			$user = $accountController->getUserInfo($email);
			//print_r("im an admin: ".$email);
		}
		else if (isset($_SESSION['login user'])) 
		{
			$email = $_SESSION['login user'];
			$user = $accountController->getUserInfo($email);
		}
		//else
		//	print_r("im neither: ".$email);;//print("You're currently not logged in");
		
		
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	if(isset($_POST['button_ChangedRecovery']))//http://marketsim-dev.cis.fiu.edu/Account%20Manage/accountManage.php?button_ChangedRecovery=Change+Recovery+Quest%2FAns 
	{
		if(!isset($_POST['textbox_CurrentPass2']) && !isset($_POST['textbox_NewQestion']) && !isset($_POST['textbox_NewAnswer']))
		{
			$value = "<b>FAILED:</b> you had unset values<br />";
		}	
		else
		{
			$currentPS = $_POST['textbox_CurrentPass2'];
			$newQuestion = $_POST['textbox_NewQestion'];
			$newAns = $_POST['textbox_NewAnswer'];
			
			$temp = $accountController->updateRecovery($user,$currentPS,$newQuestion,$newAns);
			if($temp == "pass")
				$value = "<b>Success:</b> your recovery question and answer has been changed.<br />";
			else
				$value = "<b>Failed:</b> ".$temp."<br />";;
		}
		unset($_POST['button_ChangedRecovery']);
		unset($_POST['textbox_CurrentPass2']);
		unset($_POST['textbox_NewQestion']);
		unset($_POST['textbox_NewAnswer']);
		
		$user = $accountController->getUserInfo($email);
		$value .= $accountController->UserInfoPage($user);
		
	}
	else if(isset($_POST['button_ChangedPassword']))//http://marketsim-dev.cis.fiu.edu/Account%20Manage/accountManage.php?button_ChangedRecovery=Change+Recovery+Quest%2FAns 
	{
		if(!isset($_POST['textbox_CurrentPass1']) && !isset($_POST['textbox_NewPass']))
		{
			$value = "<b>FAILED:</b> you had unset values<br />";
		}	
		else
		{
			$currentPS = $_POST['textbox_CurrentPass1'];
			$newPass = $_POST['textbox_NewPass'];
			
			$temp = $accountController->updatePassword($user,$currentPS,$newPass);
			if($temp == "pass")
				$value = "<b>Success:</b> your recovery question and answer has been changed.<br />";
			else
				$value = "<b>Failed:</b> ".$temp."<br />";;
		}
		unset($_POST['button_ChangedPassword']);
		unset($_POST['textbox_CurrentPass1']);
		unset($_POST['textbox_NewPass']);
		
		$user = $accountController->getUserInfo($email);
		$value .= $accountController->UserInfoPage($user);
		
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	else if(isset($_GET['button_ChangeMyPassword']))//http://marketsim-dev.cis.fiu.edu/Account%20Manage/accountManage.php?button_ChangeMyPassword=Change+My+Password
	{
		$value = $accountController->changePasswordPage();
		unset($_GET['button_ChangeMyPassword']);
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	else if(isset($_GET['button_ChangeMyRecovery']))//http://marketsim-dev.cis.fiu.edu/Account%20Manage/accountManage.php?button_ChangeMyRecovery=Change+My+Recovery+Quest%2FAns
	{
		$value = $accountController->changeRecoveryPage();
		unset($_GET['button_ChangeMyRecovery']);
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			
	else if(isset($_GET['button_ChangedPassword']))
	{
		$value = "inside changed password";// $accountController->changePasswordPage();
		unset($_GET['button_ChangedPassword']);
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	else
	{
		//$_SESSION['user'] = $accountController->getUserInfo($email);
		$value = $accountController->UserInfoPage($user);//$email);
	}

	$content = $accountController->CreatePage($value);

	$title = "User Accounts Management";
			
	include '../Styles/ManageTemplate.php';
?>
