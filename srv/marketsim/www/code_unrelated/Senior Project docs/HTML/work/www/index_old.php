<!DOCTYPE html>
<html>

<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Home Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">

function redirect(site) {
	window.location = site
	exit;
}

</script>

</head>

<body>
    <br /><br />    
	<form action="" method="post" style="height: 439px">
        <input height="31" name="Image1" src="Title.png" type="image" width="666" /><br />
	<br /><br />
	<a href="/login.php">Login</a>&nbsp;<br />
	<br />
	
	<div class="container">
    <div class="btn-group btn-group-justified">
    <a href="#"="a" onclick ="redirect('index.php')"  class="btn btn-primary">Home</a>
    <a href="#"="a" onclick ="redirect('metrics.html')" class="btn btn-primary">Metrics</a>
    <a href="#"="a" onclick ="redirect('stratDecisions.html')" class="btn btn-primary">Strategic Decisions</a>
	<a href="#"="a" onclick ="redirect('manage.html')" class="btn btn-primary">Manage</a>
    <a href="#"="a" onclick ="redirect('news.html')" class="btn btn-primary">News</a>
    <a href="#"="a" onclick ="redirect('index.php')" class="btn btn-primary">Sign Out</a>
  </div>
</div>
	
	
	
	</fieldset><br />
	<br />
	<fieldset name="Group1"><br />
	ScoreCard<br />
	<fieldset name="Group1">Name: Miami Vice Hotel<br />
	Type: Luxury<br />
	Location: WaterFront<br />
	Budget: $100,000<legend>Hotel States</legend>
	</fieldset><br />
	<br />
	LeaderBoard<br />
	<textarea cols="20" name="TextArea1" rows="20" style="width: 600px; height: 91px" tabindex="20">Hotel Name, Hotel Type, Location, Budget</textarea><br />
	</fieldset></form>
 	

	
</body>

</html>
