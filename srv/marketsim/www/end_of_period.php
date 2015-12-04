<?php


require '/srv/marketsim/www/Controller/gameController.php';
require '/srv/marketsim/www/Model/database.php';
session_start();

if(isset($_SESSION['login user']))
{

	//print("there is a sessions here");
	$email = $_SESSION['login user'];
	
	$db = new database();
	//var_dump($db);
	$student = $db->getStudent($email);
	//var_dump($student);
	$group = $db->getGroup($student['hotel']);
	$gameid = $group['game'];
	//var_dump($gameid);
	$game = $db->getGame($gameid);
	//var_dump($game);	
	$gameObj = new gameController();
	
	$gameObj->endPeriod ($gameid, $game['periodNum']);//, $student['hotel']);
}
else
{
	print_r("login session is not set");
}

?>