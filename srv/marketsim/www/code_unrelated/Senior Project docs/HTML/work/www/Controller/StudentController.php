<?php
/*created by Javier Andrial*/
    ini_set('display_errors', 1);
    error_reporting(~0);
	
require ("/srv/marketsim/www/Model/database.php");
class StudentController 
{

    function CreateForgotPage()
    {     
        //$result = "<form action='' method='post' style='height: 300px; width: 300px'><br /><br /><h2>Forgot Password</h2><h3>Reset password </h3><br />E-mail or PID:<br /><input type = 'Text' name = 'textbox_txt' required placeholder='abcef012@fiu.edu'><br /><br /><input type = 'submit' value = 'Find my account' class='btn btn-primary'/><br /><h5>Enter email or Panther ID to reset your password</h5></form>";
        
        $result = "<form action='' method='post' style='height: 300px; width: 300px'><br />".
                "<br />".
                "<h2>Forgot Password</h2>".       
                "<h3> Reset password </h3>".
                "<br />".
                "E-mail or PID: ".
                "<br />".
                "<input type = 'Text' name = 'textbox_txt' required placeholder='abcef012@fiu.edu'>".
				"<br />".
				"<br />".
                "<input type = 'submit' value = 'Find my account' class='btn btn-primary'/>".
				"<br />".
				"<h5>Enter email or Panther ID to reset your password</h5>".
            "</form>";
        
        return $result;
    }
    
    function findStudentAccount($value)
    {		
		if($value == "")
			return " <b><h4>Account: - $value - was not Found</h4></b>";
	
		require_once 'Entities/StudentEntity.php';

		//print_r( " entering database<br />");
        $mydatabase = new database();     
        $studentArray = $mydatabase->getStudent($value);
        $result = "";
        //var_dump($studentArray);
		//exit;

        if(!isset($studentArray) || count($studentArray) < 10 )
        {          
			$studentArray = $mydatabase->getAdmin($value);
	        if(!isset($studentArray) || count($studentArray) < 8 )
				return $result = " <b><h4>Account: - $value - was not Found</h4></b>";
        }
		
	/*	$myarray = array();
		$int = 0;
		foreach($studentArray as $key => $temp )
		{
			$myarray[$int] = $temp;
			$int = $int+1;
		}*/
		
		
		
		//$student = new StudentEntity($myarray[0],$myarray[1],$myarray[2],$myarray[3],$myarray[4],
               //                     $myarray[5],$myarray[6],$myarray[7],$myarray[8],$myarray[9]);//$studentArray[9]);
		
	/*	
		$email = $studentArray['email'];
		$secretQuestion = $studentArray['secQuestion'];
		
	   return "<form action='' method='post' style='height: 240px; width: 269px'><b><h4>Account:</h4></b><h4>".$email." </h4><br /><b><h4>Secret Question:</h4></b>".$secretQuestion."<br /><br /><input type = 'Text' name = 'textbox_secretAns' required placeholder='cats'><br /><br />Please Enter a new password for your account<br /><input type = 'password' name = 'textbox_newPass' required pattern='.{8,}' placeholder='abcd1234'><br /><br /><input type = 'submit' value = 'Reset password' class='btn btn-primary'  /><br /><br /><h5>Please Enter your secret answer to reset your password</h5><br /><br /><br /></form>";   
 */
		$result = "<form action='' method='post' style='height: 240px; width: 269px'><b><h4>Account:</h4></b><h4>".$studentArray['email']." </h4><br /><b><h4>Secret Question:</h4></b>".$studentArray['secQuestion']."<br /><br /><input type = 'Text' name = 'textbox_secretAns' required placeholder='cats'><br /><br />Please Enter a new password for your account<br /><input type = 'password' name = 'textbox_newPass' required pattern='.{8,}' placeholder='abcd1234'><br /><br /><input type = 'submit' value = 'Reset password' class='btn btn-primary'  /><br /><br /><h5>Please Enter your secret answer to reset your password</h5><br /><br /><br /></form>";   

		/*$result = "<form action='' method='post' style='height: 240px; width: 269px'>".
						"<b><h4>Account:</h4></b>".
						"<h4>$$student->email</h4>".
						"<br />".
						"<b><h4>Secret Question:</h4></b>".
						"$$student->secretQuestion".
						"<br />".
						"<br />".
						"<input type = 'Text' name = 'textbox_secretAns' required placeholder='cats'>".
						"<br />".
						"<br />".
						"Please Enter a new password for your account".
						"<br />".
						"<input type = 'password' name = 'textbox_newPass' required pattern='.{8,}' placeholder='abcd1234'>".
						"<br />".
						"<br />".
						"<input type = 'submit' value = 'Reset password' class='btn btn-primary'/>".
						"<br />".
						"<br />".
						"<h5>Please Enter your secret answer to reset your password</h5>".
						"<br />".
						"<br />".
						"<br />".
				"</form>";*/
  
		//$_SESSION['forgotPassword'] = $student->email;
		$_SESSION['forgotPassword'] = $studentArray['email'];
        return $result;
    }
    

    function resetPassword($email,$secretAns,$newpassword)
    {
		$isAdmin = false;
		if($email == "")
			return ($result ="FAILURE TO LOOK UP ENTRY IN THE DATABASE");
	
	
		//require_once 'Entities/StudentEntity.php';

        
		$secretAns = strtoupper($secretAns);
		// print_r("email entered is = ".$email."<br />");
		
        $mydatabase = new database();     
        $studentArray = $mydatabase->getStudent($email);
        $result = "";
        
		
		if(!isset($studentArray) || count($studentArray) == 0 )
		{
			$studentArray = $mydatabase->getAdmin($email);
			if(!isset($studentArray) || count($studentArray) == 0 )
				return ($result ="FAILURE TO LOOK UP ENTRY IN THE DATABASE");
			$isAdmin = true;
		}
		
		/*$myarray = array();
		$int = 0;
		foreach($studentArray as $key => $temp )
		{
			$myarray[$int] = $temp;
			$int = $int+1;
		}*/
		
		
		//$student = new StudentEntity($myarray[0],$myarray[1],$myarray[2],$myarray[3],$myarray[4],
         //                           $myarray[5],$myarray[6],$myarray[7],$myarray[8],$myarray[9]);//$studentArray[9]);
        

        
        if($mydatabase->genPass($secretAns, $email) == $studentArray['secAnswer'])//$student->secretAnswer )
        {
			//print_r( " Secret ans matched <br />");
            $result = "<tr><th>Secret answer matched.</th></tr><tr><th> Password has been changed</th></tr>";
			/*$result = "<tr>".
                            "<th>secret answer match.</th>".
                        "</tr>".
                        "<tr>".
                           "<th> password has been changed</th>".
                        "</tr>";*/

			if($isAdmin == true)
				$email = $mydatabase->updateAdminPassword($email,$newpassword);
			else
				$email = $mydatabase->updateStudentPassword($email,$newpassword);
			if($email == "fail")
				$result = "Zero entries changed";
			
			return $result;
        }
        else
        {
			//print_r( " Secret Ans did not match <br />");
            $result = "<tr><th>secret answer did not match. </th><th> Password was not changed</th></tr>";
        }
        return $result;
    }
    

}
  

/*
				<table class = 'studentTable'>
					<tr>
						<th>Account $student->email was Found: </th>
					</tr>
					<tr>
						<th>Please Enter your secret answer to reset your password </th>
						<th>Secret Question: $student->secretQuestion </th>
						<th><input type = 'Text' value ='secret ans' name = 'textbox_secretAns'></th> 
					</tr>
					<tr>
						<th><br /></th>
						<th>Please Enter a new password for your account </th>
						<th><input type = 'Text' value ='new Password' name = 'textbox_newPass'></th>                     
						<th><input type = 'submit' value = 'Reset password'/></th>
					</tr>
					
					
					
					
					
					        $result = "<form action='' method='post' style='height: 240px; width: 269px'>

						<b><h4>Account:</h4></b>
						<h4>$student->email </h4>
						<br />
						<b><h4>Secret Question:</h4></b>
						$student->secretQuestion 
						<br />
						<br />
						<input type = 'Text' name = 'textbox_secretAns' required placeholder='cats'> 
						<br />
						<br />
						Please Enter a new password for your account
						<br />
						<input type = 'password' name = 'textbox_newPass' required pattern='.{8,}' placeholder='abcd1234'>
						<br /> 
						<br />
						<input type = 'submit' value = 'Reset password' class='btn btn-primary'  />
						<br />
						<br />
						<h5>Please Enter your secret answer to reset your password</h5>
						<br />
						<br />
						<br />
				</form>
                ";   
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					            $result = " <tr>
                            <th>secret answer match</th>
                        </tr>
                        <tr>
                            <th>password has been changed</th>
                        </tr>";
					
					
					
					
					*/

?>