<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="javier andrial">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/logo-nav.css" rel="stylesheet">
	
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
				<a href="/index.php"><img src="/Images/fiu_logo_edit.png"></a>

            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style='margin:auto; width:66%;'>
                <ul class="nav navbar-nav">
					<li> <a href="/index.php">Home</a></li>
					<li> <a href="/views/stratDecisions.php">Strategic Decisions</a></li>
					<?php
						if(isset($_SESSION['admin login']))
							echo "<li> <a href='/views/ManagePage.php'>Manage</a></li>";
					?>
					
					<!--<li> <a href="/News/News.php">News</a></li> -->
					<li> <a href="/views/News.php">News</a></li>				
					<li> <a href="/views/reportingPage.php" >Reporting</a></li>
					<li> <a href="/views/accountManage.php">My Account</a></li>
					<li> <a href="/signout.php">Sign Out</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

		<!-- CONTENTS -->
		<?php echo $content; ?>
		
		<!--	<div class='' align='center' >
					<div class='panel-footer clearfix' style='width: 1080px' >


						<iframe width='560' height='315' src='https://www.youtube.com/embed/oavMtUWDBTM?list=FLlpvYpjrPP2VmA_-5xV3a0Q' frameborder='0' allowfullscreen></iframe>

						<br /><br />
						
						<form action='' method='post'>
							<input name='button_returnBack' type = 'submit' value = 'Return back' class='btn btn-primary'/>
							 <input name='button_commit' type = 'submit' value = 'Commit to DataBase' class='btn btn-primary'/>
						</form>
						
					</div>
				</div>-->

	
		
		
    <!-- /.container 

</body>

</html>