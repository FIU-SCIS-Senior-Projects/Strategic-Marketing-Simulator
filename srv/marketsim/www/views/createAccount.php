<!DOCTYPE html>
<html>

<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script type="text/javascript" src = "jquery.js"></script>
<title>Create new account</title>


</head>

<body>
<br />

	<h1 style ="color:blue">Strategic Marketing Simulator</h1> 
	<div class =""><form action="../Controller/newAccountController.php" method="post" style="height: 240px; width: 269px"><!--
        <input height"31" name="image1" src="/Images/Title.png" type="image" width="666" />--><br />
		<div class="container">
			<h2>Create a new account</h2>
			<form role="form"> 
			<div class="form-group">
				<label for="fname">First name:</label>
				<input type="text" class="form-control" name="fname" id="fname" required placeholder="John">
				<label for="lname">Last name:</label>
				<input type="text" class="form-control" name="lname" id="lname" required placeholder="Smith">
				<label for="email">E-mail:</label>
				<input type="email" class="form-control" name="email" id="email" required email placeholder ="account@domain.com">
				<label for="PID">Panther ID:</label>
				<input type="text" class="form-control" name="PID" id="PID" required pattern="[0-9]{7}" placeholder ="1234567">
				<h3> Please type and question and answer for password recovery:</h3> <br />
			<label for="security question">Security question:</label>
			<input type="text" class="form-control" name="secQuestion" id="SecQuestion" required placeholder="Question like: What is your favorite color?">
			<label for="security answer">Answer:</label>
			<input type="text" class="form-control" name="secAnswer" id="secAnswer" required placeholder="green">
				<h3> Please enter a password</h3> <br />
				<label for="pwd">Password:</label>
				<input type="password" name="pwd" class="form-control" id="pwd" required pattern=".{8,}" placeholder ="minimum 8 characters">
				<label for="pwd2"> Re-enter password:</label>          
				<input type="password" name ="pwd2"class="form-control" onkeyup= "checkPass()" id="pwd2" placeholder ="minimum 8 characters">
				<br />
				<span id="confirmMessage" class = "confirmMessage"></span>
			</div>
			
		
		<br />
		<input type="submit" name="submit" value = "submit" class="btn btn-primary" />
	    <!--<button type="button" value ="submit" onclick ="post()" class="btn btn-primary">Create Account</button>-->
		</div>
		<br /> 	<br /> 	<br />
		
		
		
     <div id="result">
 <?php 
	session_start();
	if (isset($_SESSION['announcement'])) {
		echo $_SESSION['announcement'];
		unset($_SESSION['announcement']);
	
	}
 ?>
 </div> 
	</div>
 </form></form>
 

		    
     
 <script type ="text/javascript">

 
 function post() // javascript 
 {
	//if(empty()==true){return;}
	
	var fname = $('#fname').val(); 
	var lname = $('#lname').val();
	var PID = $('#PID').val();
	var pwd = $('#pwd').val();
	var pwd2 = $('#pwd2').val();
	var email = $('#email').val();
	
	$.post('newAccountController.php',{postfname:fname,postlname:lname, postPID:PID, postpwd:pwd,postpwd2:pwd2, postemail:email},  
	
		function(data) 
		{
		$('#result').html(data); 
		}); 
	
 }

 function empty() //{alert("you missed some text boxes");}
 
 { 
	
	
	if(document.getElementById('fname').value.trim()== "")// or document.getElementById('lname').value.trim()="")// || document.getElementById('email').value.trim()="" || document.getElementById('pwd').value.trim()="" || document.getElementById('pwd2').value.trim()="")
	{ 
		alert("you missed the name textbox");
		return true;
		
	}
	else if(document.getElementById('lname').value.trim()== "")
	{
		alert("you missed the Last name textbox");
		return true;
	}
	else if(document.getElementById('email').value.trim()== "")
	{
		alert("you missed email textbox");
		return true;
	}
	else if(document.getElementById('PID').value.trim()== "")
	{
		alert("you missed Panther ID textbox");
		return true;
	}
	else if(document.getElementById('pwd').value.trim()== "")
	{
		alert("you missed password textbox");
		return true;
	}
	else if(document.getElementById('pwd2').value.trim()== "")
	{
		alert("you missed re-enter password textbox");
		return true;
	}
	else 
	{
		alert("No missed fields");
		return false;
	}

 }
function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pwd');
    var pass2 = document.getElementById('pwd2');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "";//"Passwords Match!"
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
    }
}   
</script>
	       
</body>

</html>
