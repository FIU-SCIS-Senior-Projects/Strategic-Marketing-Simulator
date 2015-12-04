

<html lang="en">
<head>

</head>

<body>
<div>
		<?php 
			ini_set('display_errors', 1);
			error_reporting(~0);

			
			session_start();
			$content = "";

				if (isset($_SESSION['login user'])) 
				{
					$content = $_SESSION['login user']." has been logged out";
					unset($_SESSION['login user']);
				}
				else
					$content = "Your Account has been logged out";
				$content.="<br />";
				print_r($content);
				//sleep(1.1);
				//header("Location: /login.php");
		?>
		<a href="/login.php">Login</a>
</div>
			
</body>

</html>