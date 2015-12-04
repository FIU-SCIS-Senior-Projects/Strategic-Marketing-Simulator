<?php

ini_set('display_errors', 1);
error_reporting(~0);
include("connection.php");
require 'Model/database.php';
	
	////
session_start();
if (isset($_SESSION['login user'])) 
	{
		
		
		$user = $_SESSION['login user'];
		//echo "I've got a session!!";
		
		

	}
	else
	{
		echo "I dont have a session";
		//header('Location: /login.php');
		
	}

	if(isset($_POST['csc']))
	{
		parse_str($_POST['csc'],$arr);
		
			//$type = $arr['radio'];
			$game = $arr['game'];
			$name = $arr['new_group'];
			//echo "made it this far";
			$location = $arr['location'];
			$obj3 = new database();
			if(count($arr3 = $obj3->searchHotel($name)) < 1) 
			{
				$balance = 50000.00;
			$arrz = $obj3->newHotel($name, $location, NULL, $game, $balance, NULL, NULL, 1);	 // adding hotel
			$obj3->updateStudentHotel($user,$arrz['max(id)']); // updated student foreign key for hotel
			//header("Location: /index.php");
			echo true;
			}
			else
			{
				echo "Group name already in use, please select another group name";
			}
	}		
			
	else
	{
		echo "radio is not set.";
	}
	
	
	
	
	

?>