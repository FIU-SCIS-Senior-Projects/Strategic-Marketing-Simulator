<?php
require ('/srv/marketsim/www/Controller/periodController.php');
require ("/srv/marketsim/www/Model/database.php");
session_start();
	if (isset($_SESSION['login user'])) 
	{
		$email = $_SESSION['login user']; //do nothing
	}
	else
	{
		
			header("Location: /login.php");
	}
	
	if(isset($_POST['commitText']))
	{
		$comments = $_POST['commitText'];
		//echo $comments;
		$obj = new periodController();
		$obj->commit($comments, $email);
	}


	




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
<?php // Here I need to increment the game period of game, and add comments to gamedecisions 

//I am thinking that the best way to do this is to create a table game_comments (game, period (as primary keys) hotel, comments, 

//here I should create a periodController object and call commit?>
  <h1 style = "color:blue" align="left">Strategic Marketing Simulator</h1> 
  <p><?php echo  $email ?>, please discuss your decisions with your group and explain why you made them.</p>
  <form role="form" method ='post'>
    <div class="form-group">
      <label for="comment">Comments:</label>
      <textarea class="form-control" rows="8" name = "commitText" method ='post' required id="comment"></textarea>
    </div>
	
	<div class="pull-right">
               <input type="submit" name="submitCommit" value = "Commit Comments" action =  "commitPeriod(<?php $comments. ", " . $email;?>)"  class="btn btn-primary" />
                
				
				
		 
            </div>
  </form>
</div>

</body>
</html>
