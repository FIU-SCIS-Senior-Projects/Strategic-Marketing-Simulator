<?php



session_start();

ini_set('display_errors', 1);
error_reporting(~0);

require 'Model/database.php';

if(isset($_POST['pwd']))
{
	$pwd = $_POST['pwd'];
}
if(isset($_POST['email']))
{
$email = $_POST['email'];
}

$obj = new database();
$res = $obj->searchForStudents($email);


/*
$os = array("Mac", "NT", "Irix", "Linux");
if (in_array("Irix", $os)) {
    echo "Got Irix";
*/

	if(count($res) > 0 )
	{
		$pwd = $obj->genPass($pwd, $email);
		if (in_array($pwd, $res))
		{
		
			
		$_SESSION['login user'] = $email;
		
			if ($res['hotel'] == null)
			{	
		
				header('Location: /joinGroup.php');	
			}
			else
			{
				header('Location: /');	
			}
		}
		else
		{
			$_SESSION['announcement'] = "Incorrect Password  <br />";
			header('Location: /login.php');
		}
	
		
	}
	else
	{
		
		session_start();
		$_SESSION['announcement'] = "Student not in database  <br />";
		header('Location: /login.php');
	}
		session_write_close();



?>