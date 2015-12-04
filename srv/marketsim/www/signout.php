<!--created by Javier Andrial-->
<!--
<html lang="en">
<head>

</head>

<body>
<div>-->
		<?php 
			ini_set('display_errors', 1);
			error_reporting(~0);

			session_start();
			
			$content = "<h1 style = 'color:blue' align='left'>Strategic Marketing Simulator</h1> <br />";

				if (isset($_SESSION['login user'])) 
				{
					$content .= $_SESSION['login user']." has been logged out";
					//unset($_SESSION['login user']);
					//unset($_SESSION['admin login']);
				}
				else if(isset($_SESSION['admin login']))
				{
					$content .= $_SESSION['admin login']." has been logged out";
					//unset($_SESSION['admin login']);
				}
				else
					$content .= "Your Account has been logged out";
				$content.="<br /> <a href='/views/login.php'>Login</a>";
				
				print_r($content);
				session_unset();
				
				
				
				//sleep(1.1);
				//header("Location: /login.php");
		?>
<!--
<a href="/login.php">Login</a>
</div>
			
</body>

</html>
-->