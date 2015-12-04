<?php

session_start();
	if (isset($_SESSION['login user'])) 
	{
		$user = $_SESSION['login user']; //do nothing
	}
	else
	{
		
			header("Location: /login.php");
	}

if(isset($_POST['commit']))
{
	
	




?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Commit</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

  <h1 style = "color:blue" align="left">Strategic Marketing Simulator</h1> 
  <p><?php echo  $user ?>, please discuss your decisions with your group and explain why you made them.</p>
  <form role="form">
    <div class="form-group">
      <label for="comment">Comments:</label>
      <textarea class="form-control" rows="5" id="comment"></textarea>
    </div>
	
	<div class="pull-right">
                <a href="#" name = 'commited' method = 'post' class="btn btn-primary">Confirm decisions</a>
                
            </div>
  </form>
</div>
<?php
}
	else
	{
		header("Location: /index.php");
	
	}
	?>
</body>
</html>
