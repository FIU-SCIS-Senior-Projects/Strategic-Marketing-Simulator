<?php
$mysql_db_hostname = "localhost";
$mysql_db_user = "root";
$mysql_db_password = "Jeff_1230";
$mysql_db_database = "marketsim";

$con = @mysqli_connect($mysql_db_hostname, $mysql_db_user, $mysql_db_password,
    $mysql_db_database);
if (!$con) {
    trigger_error('Could not connect to MySQL: ' . mysqli_connect_error());
}
?>