<?php

session_start();

ini_set('display_errors', 1);
error_reporting(~0);

require '../Model/database.php';

$fname = $_POST['fname']; 
$lname = $_POST['lname'];
$PID = $_POST['PID']; 
$pwd = $_POST['pwd'];
$pwd2 = $_POST['pwd2']; 
$email = $_POST['email'];
$secQuestion = $_POST['secQuestion'];
$secAnswer = $_POST['secAnswer'];
$obj = new database();
$res = $obj->searchForStudents($PID);
$pwd = $obj->genPass($pwd, $email);

$secAnswer = $obj->genPass(strtoupper($secAnswer), $email);


	if(count($res) < 1 )
	{
		$bot = 0;
		$isActive = 1;
	
		$obj->addStudent($PID, $fname, $lname, $email, $bot, $pwd, $secQuestion, $secAnswer, $isActive);
	
		$_SESSION['login user'] = $email;
		
		header('Location: ../views/joinGroup.php');
	}
	else
	{
		session_start();
		$_SESSION['announcement'] = "Student Already in the database  <br />";
		header('Location: ../views/createAccount.php');
	}
session_write_close();



?>