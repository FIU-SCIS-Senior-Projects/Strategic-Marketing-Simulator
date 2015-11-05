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
		if(isset($arr['group']) && $arr['group'] !='')
		{
			$game =$arr['game']; //
			$group =$arr['group'];
			
			$user = $_SESSION['login user'];//
			
			//$obj = New casCade();/
			$obj = New database();
			//$obj->insert_user_data($arr,$con);
			if($obj->updateStudentHotel($user, $group)== true)
			{
				echo true;
			}
			else echo false;
			//echo "created object - calling funciton!";
			//$value=$obj->get_country($arr['city'],$con);
			//echo "Your Data Successfully Saved.";
		}
		else
		{
		echo "Please select all details.";
		}
	}
	else {echo "csc didn't work";}

class casCade{

function insert_user_data($arr,$con){
	
	
	
	
		
		$group =$arr['group'];
		$game =$arr['game'];
		$user = $_SESSION['login user'];
		$sql = "update student set hotel = " .$group.  " where email = " .$user; 
		$query = mysqli_query($con, $sql);
		while ($rs = mysqli_fetch_array($query, MYSQLI_ASSOC )){}
				
		
		$con->close();
		//header('Location: /index.php');
	
	/*}
	else
	{
		echo "User session not set";
	}
		*/
}
 

}