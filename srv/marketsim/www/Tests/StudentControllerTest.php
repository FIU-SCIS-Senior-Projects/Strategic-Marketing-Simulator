<?php


require '../Controller/StudentController.php';
//require '../Model/database.php';

class StudentControllerTest extends \PHPUnit_Framework_TestCase
{ 

		/**
     * @covers a
     */
	public function test__StudentControllerConstructInvalidPar()
    {
        $m = new database('not');
        $this->assertInstanceOf(database::class, $m);
        return $m;
    }
	/**
     * @covers a
     */
	 public function test__StudentControllerConstrucValidPar()
    {
        $m = new database();
        $this->assertInstanceOf(database::class, $m);
        return $m;
    }
	/**
     * @covers a
     */
	 
	  function test__StudentControllerCreateForgotPage()
	  {
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
			
			$S = new StudentController();
			return $this->assertEquals($S->createForgotPage(), $result);
		  
	  }
	  /**
     * @covers a
     */
	  function test__StudentControllerfindStudentAccountEmptyParameter()
	  {
		  $value = '';
		  $result = "<b><h4>Account: - ".$value." - was not Found</h4></b>";
		  $a = new StudentController();
		  
		  return $this->assertEquals($a->createForgotPage($value), $result);
		  
	  }
	   /**
     * @covers a
     */
	  function test__StudentControllerfindStudentAccount()
	  {
		  
		  $result = "<form action='' method='post' style='height: 240px; width: 269px'><b><h4>Account:</h4></b><h4>".$studentArray['email']." </h4><br /><b><h4>Secret Question:</h4></b>".$studentArray['secQuestion']."<br /><br /><input type = 'Text' name = 'textbox_secretAns' required placeholder='cats'><br /><br />Please Enter a new password for your account<br /><input type = 'password' name = 'textbox_newPass' required pattern='.{8,}' placeholder='abcd1234'><br /><br /><input type = 'submit' value = 'Reset password' class='btn btn-primary'  /><br /><br /><h5>Please Enter your secret answer to reset your password</h5><br /><br /><br /></form>";   
		  $a = new StudentController();
		  return $this->assertEquals($a->createForgotPage('jcarm012@fiu.edu'), $result);
	  }
	    /**
     * @covers a
     */
	  function test__StudentControllerresetPasswordEmptyEmail()
	  {
		  $email = '';
		
		  
		  $passWord = '';
		  $secretAnswer ='';
		  $newpassword = 'password';
		  $s = new StudentController();
		  
		  return $this->assertEquals($s->resetPassword($email,$secretAns,$newpassword), $result);
		  
		  
	  }
	  /**
     * @covers a
     */
	   function test__StudentControllerresetPasswordInvalidEamil()
	  {
		  $result = "FAILURE TO LOOK UP ENTRY IN THE DATABASE";
		  $email = 'adfgadfg';
		  $secretAnswer = '';
		  $newpassword = '';
		  $s = new StudentController();
		  
		  return $this->assertEquals($s->resetPassword($email,$secretAns,$newpassword), $result);
		  
		  
	  }
	  /**
     * @covers a
     */
	   /*function test__StudentControllerresetPasswordValid()
	  {
		  $result = "<tr><th>Secret answer matched.</th></tr><tr><th> Password has been changed</th></tr>";
		  $email = 'admin@marketsim.com';
		  $db = new database();
		  
		  $passWord = 'password';
		  $secretAnswer = $db->genPass($email, );
		  $newpassword = 'password';
		  $s = new StudentController();
		  
		  return $this->assertEquals($s->resetPassword($email,$secretAns,$newpassword), $result);
		  
		  
	  }*/
}