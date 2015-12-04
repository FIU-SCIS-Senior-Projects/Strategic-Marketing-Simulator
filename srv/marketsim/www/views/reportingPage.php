<?php
	/*created by Javier Andrial
	Date Finished: Nov 2015*/
	ini_set('display_errors', 1);
	error_reporting(~0);

	require '../Controller/ReportController.php';
	$reportController = new ReportController();

	$title = "";
	$content = "";
	$value = "";

	session_start();
		
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if(isset($_POST['button_applyFilter']))
	{
		$gameCheck = null;
		$periodcheck = null;
		
		
		if(isset($_POST['gameCheckbox']))
			$gameCheck = $_POST['gameCheckbox'];

		
		if(isset($_POST['periodCheckbox']))
			$periodcheck = $_POST['periodCheckbox'];

		
		
		
		if($gameCheck == null && $periodcheck == null)
			$list = $reportController->getCommentList();
		else
			$list = $reportController->getCommentListFiltered($gameCheck,$periodcheck);
		$value .= $reportController->generateCommentTable($list,$gameCheck,$periodcheck);
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_feedbackPost']))
	{
		$value = "<div align='center'>";
		if(isset($_POST['textarea_feedback']))
		{		
			$value .= $reportController->postFeedback($_SESSION['commentId'],$_POST['textarea_feedback']);
		}
		else
			$value .= "<b>Faild:</b> Empty textarea";
		
		$value .= "<br /><br /></div>";
		$list = $reportController->getCommentList();
		$value .= $reportController->generateCommentTable($list,null,null);
		
		unset($_SESSION['commentId']);
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	else if(isset($_POST['button_chooseGame']))
	{
		if(isset($_POST['gameRadio']))
		{
			$_SESSION['gameID'] = $_POST['gameRadio'];
			$value = $reportController->selectPeriod($_POST['gameRadio']);
			//$value = $reportController->choosePeriod($_POST['gameRadio']);
		}
		else
			$value = "you did not choose a game";
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_choosePeriod']))
	{
		$table = "";
		if(isset($_POST['periodRadio']))
		{
			$value = $reportController->generatePDF($_SESSION['gameID'],$_POST['periodRadio']);
		}
		else
			$value = "<b>Failed</b><br />You did not choose a period.";
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	else if(isset($_GET['button_commentRepository']))//http://marketsim-dev.cis.fiu.edu/views/reportingPage.php?button_commentRepository=Comment+Repository
	{
		$list = $reportController->getCommentList();
		$value = $reportController->generateCommentTable($list,null,null);

		unset($_GET['button_commentRepository']);
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	else if(isset($_GET['button_reports']))//http://marketsim-dev.cis.fiu.edu/views/reportingPage.php?button_reports=Reports
	{
		$value = $reportController->chooseGame();
		unset($_GET['button_reports']);
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	else if(isset($_GET['button_feedback']))
	{
		$value = $reportController->feedbackPage($_GET['commentId']);
		$_SESSION['commentId'] = $_GET['commentId'];
		unset($_GET['button_feedback']);
		unset($_GET['commentId']);
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	else if(isset($_GET['button_viewfeedback']))
	{
		$value = $reportController->feedbackPageStudent($_GET['commentId']);
		$_SESSION['commentId'] = $_GET['commentId'];
		unset($_GET['button_viewfeedback']);
		unset($_GET['commentId']);
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			
	else
	{
		if(isset($_SESSION['login user']))
			$value = $reportController->commentListStudent($_SESSION['login user']);

	}

	if(isset($_SESSION['admin login'])) 
	{
		$content = $reportController->CreatePage($value);
	}
	else if(isset($_SESSION['login user'])) 
	{
		$content = $reportController->CreatePageStudent($value);
	}
	else
	{
		session_unset();
		header('Location: /views/login.php');
		exit;
	}


	$title = "Reporting";
			
	include '../Styles/ManageTemplate.php';
?>
















