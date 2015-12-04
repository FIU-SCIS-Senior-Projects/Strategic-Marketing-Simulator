<?php

session_start();

ini_set('display_errors', 1);
error_reporting(~0);

require 'Model/database.php';

$obj = new database();
$games = $obj->getGames();

print_r($games);
exit;





?>