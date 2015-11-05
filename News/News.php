<?php 
/*created by Javier Andrial
Date Finished: Oct 20 2015*/
ini_set('display_errors', 1);
error_reporting(~0);
//sudo tail -n 1 /var/log/apache2/marketsim-error.log

require '../Controller/NewsController.php';

$title = "";
$header = "";
$content = "";
$value = "";
$email ="jandr018@fiu.edu";
$isAdmin = true;
$newsController = new NewsController();

	session_start();
	/*if (isset($_SESSION['admin login'])) 
	{
		$isAdmin = true;
	}
	else if(isset($_SESSION['login user']))
	{
		$email = $_SESSION['login user'];
		$isAdmin = false;
	}*/
	
	
	if(!isset($_SESSION['impactType']))
		$_SESSION['impactType'] = array();
	if(!isset($_SESSION['hotelLocation']))
		$_SESSION['hotelLocation'] = array();
	if(!isset($_SESSION['hotelType']))
		$_SESSION['hotelType'] = array();
	
	
	
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if(isset($_POST['button_viewStudent']) )//student toggle
	{
		$isAdmin = false;
		//$value = "you're in student session if statement";
		
		if(!isset($email))
			$email = "fail";
		
		$value = $newsController->student_news($email);
	}//1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_viewAdmin']) )//admin toggle
	{
		$isAdmin = true;
		$article = "";
		
		if(!isset($_SESSION['game_id']))
		{
			$value = $newsController->chooseGame();
		}
		else
		{
			$value = $newsController->getTable($_SESSION['news_id'],$_SESSION['hotelType'],$_SESSION['hotelLocation'],$_SESSION['impactType']);
			$value = $newsController->CreatePage_admin($_SESSION['game_id'],$_SESSION['period'],$_SESSION['article'],$value.$newsController->affectsParameters());
		}
	}//2
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_saveAndPreview']) )//news page button
	{
		if(!isset($_POST['impactType']) || !isset($_POST['hotelType']) || !isset($_POST['hotelLocation']))
		{
			
		}
		else
		{
			array_push($_SESSION['impactType'], $_POST['impactType']);
			array_push($_SESSION['hotelLocation'], $_POST['hotelLocation']);
			array_push($_SESSION['hotelType'], $_POST['hotelType']);
		}

		if(isset($_POST['textarea_news']))
			$article = $_SESSION['article'] = $_POST['textarea_news'];
		else
		{
			if(isset($_SESSION['article']))
				$article = $_SESSION['article'];
			else
				$article = "Empty";
		}

		/*header ("content-type: text/plain");
		echo $article;
		exit;*/
		//$_SESSION['preview'] =
		$value = $newsController->saveAndPreview($article);
		//header('Location: /News/News.php?preview=true');
		//exit;
	}//3
	/*else if(isset($_GET['preview']) )
	{
		$value = $_SESSION['preview'];
	}*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_resetParameters']) )
	{
		$value = $newsController->startOverPage();
	}//4
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	else if(isset($_POST['button_clearSession']) )
	{
		unset($_SESSION['impactType']);
		unset($_SESSION['hotelType']);
		unset($_SESSION['hotelLocation']);
		$value = "<b>Successful</b>.<br />Parameters for this session have been removed.";
		$table = $newsController->getTable($_SESSION['news_id'],null,null,null);
		$value .=  $newsController->CreatePage_admin($_SESSION['game_id'],$_SESSION['period'],$_SESSION['article'],$table.$newsController->affectsParameters());
	}//5
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	else if(isset($_POST['button_clearDBParams']) )
	{
		$value = $newsController->clearParameters($_SESSION['news_id']);
		
		$table = $newsController->getTable($_SESSION['news_id'],$_SESSION['hotelType'],$_SESSION['hotelLocation'],$_SESSION['impactType']);
		$value .= $newsController->CreatePage_admin($_SESSION['game_id'],$_SESSION['period'],$_SESSION['article'],$table.$newsController->affectsParameters());
	}//6
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	else if(isset($_POST['button_addParameters']) )
	{
		$article = "";
		$counter = 0;
		
		/*if(!isset($_SESSION['impactType']) || !isset($_SESSION['hotelLocation'])||!isset($_SESSION['hotelType']))
		{
			$_SESSION['impactType'] = array();
			$_SESSION['hotelLocation'] = array();
			$_SESSION['hotelType'] = array();
		}*/
		
		if(!isset($_POST['impactType']) || !isset($_POST['hotelType']) || !isset($_POST['hotelLocation']))
		{
			$value .= "<b>Failed</b>.<br />You had unset values";
		}
		else
		{	
			array_push($_SESSION['impactType'], $_POST['impactType']);
			array_push($_SESSION['hotelLocation'], $_POST['hotelLocation']);
			array_push($_SESSION['hotelType'], $_POST['hotelType']);
		}
		if(isset($_POST['textarea_news']))
			$article = $_SESSION['article'] = $_POST['textarea_news'];
		else
		{
			if(isset($_SESSION['article']))
				$article = $_SESSION['article'];
		}
		
			
		$table = $newsController->getTable($_SESSION['news_id'],$_SESSION['hotelType'],$_SESSION['hotelLocation'],$_SESSION['impactType']);
		$value .=  $newsController->CreatePage_admin($_SESSION['game_id'],$_SESSION['period'],$article,$table.$newsController->affectsParameters()); 
	}//7
////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_chooseGame']) )//save parameters button
	{
		$isAdmin = true;
		$value="";
		if(isset($_POST['gameRadio']))
		{
			$_SESSION['game_id'] = $_POST['gameRadio'];

			unset($_SESSION['impactType']);
			unset($_SESSION['hotelType']);
			unset($_SESSION['hotelLocation']);
			unset($_SESSION['article']);
			unset($_SESSION['news_id']);
			unset($_SESSION['period']);
			
			$_SESSION['period'] = $newsController->getGamePeriod($_SESSION['game_id']);
			$_SESSION['news_id'] = $newsController->getNews_id($_SESSION['game_id'],$_SESSION['period']);
			$article = $newsController->getArticle($_SESSION['news_id']);
			if($article == "fail")
			{
				$article="";
				$value ="<b>FAILED</b>.<br />Failed to retreive news article.<br />There is no News article for this Game.";
			}
			else
				$_SESSION['article'] = $article;
			
			
			$table = $newsController->getTable($_SESSION['news_id'],null,null,null);
			$value .= $newsController->CreatePage_admin($_SESSION['game_id'],$_SESSION['period'],$article,$table.
			$newsController->affectsParameters());
		}
		else
		{
			$value = $newsController->chooseGame();
			$value .= "<br /><br />Please Choose a Game to proceed";
		}
	}//8
/////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_returnBack']) )
	{
		$article = $_SESSION['article'];
		if(isset($_POST['textarea_news']))
			$article = $_SESSION['article'] = $_POST['textarea_news'];
	
		
		$value = $newsController->getTable($_SESSION['news_id'],$_SESSION['hotelType'],$_SESSION['hotelLocation'],$_SESSION['impactType']);
		$value =  $newsController->CreatePage_admin($_SESSION['game_id'],$_SESSION['period'],$article,$value.$newsController->affectsParameters());
		
	}//9
/////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_commit']))
	{
		$value = $newsController->commitToDB($_SESSION['news_id'],$_SESSION['article'],$_SESSION['impactType'],$_SESSION['hotelType'],$_SESSION['hotelLocation']);
		unset($_SESSION['impactType']);
		unset($_SESSION['hotelType']);
		unset($_SESSION['hotelLocation']);
		
		$table = $newsController->getTable($_SESSION['news_id'],null,null,null);
		$value .=  $newsController->CreatePage_admin($_SESSION['game_id'],$_SESSION['period'],$_SESSION['article'],$table.$newsController->affectsParameters());
	}//10
////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_ChangePeriod']))
	{
		$value = $newsController->choosePeriod($_SESSION['game_id']);
	}//11
////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_AddPeriod']))
	{
		$article = $newsController->addPeriod($_SESSION['game_id']);
		if($article == "fail")
			$value = "<b>FAILED</b><br />Unable to Create new Period.";
		else
			$value = "<b>PASSED</b><br />New News Period was Created.";
		
		
		$value = $newsController->choosePeriod($_SESSION['game_id'])."<br /><br />".$value;
	}//12
////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_removePeriod']))
	{
		$article = $newsController->removePeriod($_SESSION['game_id']);
		if($article == "fail")
			$value = "<b>FAILED</b><br />Unable to remove News Period.";
		else
			$value = "<b>PASSED</b><br />Last Period News was removed.";
		
		$value = $newsController->choosePeriod($_SESSION['game_id'])."<br /><br />".$value;
	}//13
////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_choosePeriod']))
	{
		$table = "";
		if(isset($_POST['periodRadio']))
		{
			$_SESSION['news_id'] = $_POST['periodRadio'];
			$_SESSION['period'] = $newsController->getNewsPeriod($_SESSION['news_id']);
			$_SESSION['article'] = $newsController->getArticle($_SESSION['news_id']);
		}
		else
			$value = "<b>Failed</b><br />You did not choose a period.";
		
		$table .= $newsController->getTable($_SESSION['news_id'],$_SESSION['hotelType'],$_SESSION['hotelLocation'],$_SESSION['impactType']);
		$value .= $newsController->CreatePage_admin($_SESSION['game_id'],$_SESSION['period'],$_SESSION['article'],$table.$newsController->affectsParameters());
	}//14
////////////////////////////////////////////////////////////////////////////////////////////////
	else if(isset($_POST['button_upload']))
	{
		if(isset($_POST['upload_button']))
			$_SESSION['article'] = $_POST['upload_button'];
		
		$table = $newsController->getTable($_SESSION['news_id'],$_SESSION['hotelType'],$_SESSION['hotelLocation'],$_SESSION['impactType']);
		$value = $newsController->CreatePage_admin($_SESSION['game_id'],$_SESSION['period'],$_SESSION['article'],$table.$newsController->affectsParameters());
	}//15
////////////////////////////////////////////////////////////////////////////////////////////////
	else
	{
		//this is the crap for session checking
		if (isset($_SESSION['admin login'])) 
		{
			$isAdmin = true;
			$value = $newsController->chooseGame();
			//print_r('inside admin: '.$_SESSION['admin login']);
		}
		else if(isset($_SESSION['login user']))
		{
			$email = $_SESSION['login user'];
			$value = $newsController->student_news($email);
			//print_r('inside student: '.$_SESSION['login user']);
		}
		else
		{
			header('Location: /login.php');
			exit;
		}
		//$value = $newsController->chooseGame();
	}//16
	
	

$title = "News";
$header = "<h1 style = 'color:blue' align='center'>News</h1>";

if(isset($_POST['button_saveAndPreview']))
{
	$content = $value;
}
else
	$content = $newsController->CreatePage($header,$value,$isAdmin);

include '../Styles/ManageTemplate.php';

?>

















