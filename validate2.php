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
$res2 = $obj->getAdmin($email);
$pwd2 = $obj->genPass($pwd, $email);




if (in_array($pwd2, $res2))
{
	if(isset($_SESSION['user login']))
	{
		unset ($_SESSION['user login']);
	}
	$_SESSION['admin login'] = $email;
	header("Location: /admin/ManagePage.php");
	EXIT;
}
		

/*
$os = array("Mac", "NT", "Irix", "Linux");
if (in_array("Irix", $os)) {
    echo "Got Irix";
*/

	if(count($res) > 0 )
	{
		if(isset($_SESSION['admin login']))
		{
			unset ($_SESSION['admin login']);
		}
	
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
		$_SESSION['announcement'] = "Student not database  <br />";
		header('Location: /login.php');
	}
		session_write_close();



?>