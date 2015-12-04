<?php
	ini_set('display_errors', 1);
	error_reporting(~0);
	
	//header("Content-Type: text/plain");

	class forgotPW_test_class //extends PHPUnit_Framework_TestCase
	{
		public function test_CreateForgotPage($ans,$note)
		{
			require_once '../Controller/StudentController.php';
			$studentController = new StudentController();
				
			$result = $studentController->CreateForgotPage();
			
			$result = trim($result);
			
			$ans = trim($ans);

			//$ans = trim ( $ans," \t\n\r\0\x0B" );
			//$ans =trim($ans,"\n");
			//string trim ( string $str [, string $character_mask = " \t\n\r\0\x0B" ] )
			
			//print_r($result);
			//echo "\n\n";
			//print_r($ans);
			//exit();
			//var_dump(strcmp($result,$ans));
			//exit();
		
			if($result == $ans)
				$ans = "PASSED";
			else
				$ans = "FAILED";
			
			
			return $test = "Testing CreateForgotPage()<br /><b>note:</b> $note
							<br />
							Test: ". $ans."<br />";
		}

		public function test_findStudentAccount($value,$ans,$note)
		{
			require_once '../Controller/StudentController.php';
			$studentController = new StudentController();
		
			$result = $studentController->findStudentAccount($value);
			
			
			$result = (trim($result));
			//$result = str_replace(PHP_EOL,null,$result);
			$ans = (trim($ans));
			//$ans = str_replace(PHP_EOL,null,$ans);
			/*
			print_r($ans);
			echo "\n";
			print_r($result);
			exit();	
			*/
			
			if(strcmp ($result, $ans ) == 0)
				$ans = "PASSED";
			else
				$ans = "FAILED";
			
			$test = "<br />
					Testing findStudentAccount() <br /><b>note:</b> $note
					<br />
					With: ".$value."
					<br />
					Test: ". $ans."<br />";	
			return $test;
		}
	
		public function test_resetPassword($email,$secretAns,$newpassword,$ans,$note)
		{
			require_once '../Controller/StudentController.php';
			$studentController = new StudentController();

		
			$result = $studentController->resetPassword($email,$secretAns,$newpassword);
			
			$result = (trim($result));
			//$result = str_replace(PHP_EOL,null,$result);
			$ans = (trim($ans));
			//$ans = str_replace(PHP_EOL,null,$ans);
			
		/*	print_r($ans);
			echo "\n";
			print_r($result);
			exit();*/
			
			if(strcmp ($result, $ans ) == 0)
				$ans = "PASSED";
			else
				$ans = "FAILED";
			/*
			if($ans == $result)
				$ans = "PASSED";
			else
				$ans = "FAILED";
			*/
			
			return $test = "<br />
					Testing resetPassword()<br /><b>note:</b> $note
					<br />
					With: ".$email.", ".$secretAns.", " .$newpassword."
					<br />
					Test: ". $ans ."<br />";	
		}
	}
?>










