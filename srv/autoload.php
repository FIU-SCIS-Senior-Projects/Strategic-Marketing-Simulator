<?php function __autoload($class_name) {
   include '/srv/marketsim/www/' . $class_name . '.php';
	include '/srv/marketsim/www/Model' . $class_name . 'php';
	include '/srv/marketsim/www/Tests' . $class_name . 'php';
}
?>
