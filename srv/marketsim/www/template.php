<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> <?php echo $title;  ?> </title>
          <link rel="stylesheet" type="text/css" href="/Styles/StyleSheet.css"/> 
		
    
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<link href="css/logo-nav.css" rel="stylesheet"> 
	
	<!-- 
	<html>
		<head>
			<meta content="en-us" http-equiv="Content-Language" />
			<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
			<meta name="viewport" content="width=device-width, initial-scale=1">
			  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
			  <script type="text/javascript" src = "jquery.js"></script>
-->
	  </head>
    <body>
        <div id="wrapper">
            <div id="banner">
				<h1 style ="color:blue">Strategic Marketing Simulator</h1> 
            </div>
            
			<nav id="navigation">
				<ul id="nav">
					<li> <a href="/index.php">Home</a></li>
					<li> <a href="/views/login.php">Login</a></li>
					<!--<li> <a href="/createAccount.php">Create Account</a></li>
					<li> <a href="#"></a></li>-->
					<li> <a href="/forgotPW.php">Forgot Password</a></li>
				</ul>
			</nav>
			<div id="content_area" >
				<?php echo $content; ?>
			</div>
			

			
        </div>
    </body>
</html>

