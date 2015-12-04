<?php

require '../Model/database.php';
class databaseTest extends \PHPUnit_Framework_TestCase
{
	 /**
     * @covers a
     */
	  public function test__constructInvalidPar()
    {
        $m = new database('EUR');
        $this->assertInstanceOf(database::class, $m);
        return $m;
    }
	/**
     * @covers a
     */
	 public function test__construcValidPar()
    {
        $m = new database();
        $this->assertInstanceOf(database::class, $m);
        return $m;
    }
	 /**
     * @covers a
     */
	public function test_searchForStudentsFound()
	{
		$db = new database();
		return $this->assertEquals(count($db->searchForStudents("jcarm012")), 10);
				
		
	}
	 /**
     * @covers a
     */
	public function test_searchForStudentsNotFound()
	{
		$db = new database();
		return $this->assertEquals(count($db->searchForStudents("beaver")), 0);
				
		
	}
	 /**
     * @covers a
     */
	public function test_getStudentFound()
	{
		$db = new database();
		return $this->assertEquals(count($db->getStudent("2654698")), 10);
				
		
	}
	 /**
     * @covers a
     */
	
	public function test_getStudentNotFound()
	{
		$db = new database();
		return $this->assertEquals(count($db->getStudent("stickle")), 0);
				
		
	}
	 /**
     * @covers a
     */
	
	public function test_addStudent()
	{
		
	

		$db = new database();
		return $this->assertEquals($db->addStudent(1651248, "ricky", "roberts", "Ricke@roberts.com", 0, 1253481, "where am I", "everywhere", -5), "pass");
				
		
	}
	 /**
     * @covers a
     */
	public function test_genPass()
	{
			$pwd = "somePass1234";
			$email = "some@email.com";
			$db = new database;
			$db2 = new database;
			
			
			$this->assertEquals($db->genPass($pwd, $email),$db2->genPass($pwd, $email));
	}
	/**
     * @covers a
     */
	
	public function test_updateStudentPassword()
	{
		$email = "jcarm012@fiu.edu";
		
		
		$db = new database();
		
		$pwd = $db->genPass($email, "Jeff_1230");
		
		$this->assertEquals ($db->updateStudentPassword($email, $pwd), "pass");
	
	}
	/**
     * @covers a
     */
	
	public function test_updateStudentPasswordInValid()
	{
		$email = "jcarm012@fiu.edu";
		
		
		$db = new database();
		$this->assertEquals($db->updateStudentPassword($email, 'NULL'), "pass");
	
	}
	/**
     * @covers a
     */
	
	public function test_addGameValid()
	{
		//public function addGame($semester,$courseID,$section,$schedule,$isActive,$courseNumber)
		$db = new database();
		$semester = "TestSemester";
		$courseID = "1234567Test";
		$schedule = "3:45-5 Test";
		$section = "abcdSectionTest";
		$isActive = -5;
		$courseNumber = "TestCourseNumber";
		
		$this->assertEquals($db->addGame($semester,$courseID,$section,$schedule,$isActive,$courseNumber), "pass");
		
		
	
	}
	/**
     * @covers a
     */
	public function test_addGameinValid()
	{
		$db = new database();
		$semester = "TestSemester";
		$courseID = "1234567Test";
		$schedule = "3:45-5 Test";
		$section = "abcdSectionTest";
		$isActive = -5;
		$courseNumber = "TestCourseNumber";
		
		$this->assertEquals($db->addGame($semester,$courseID,$section,$schedule,NULL,$courseNumber), "fail");
		
	
	}
	
	
	/**
     * @covers a
     */
	
	public function test_updateAdminPasswordValid()
	{
		$email = "test@test.com";
		$password = "NewTestPassword";
		$db = new database();
		$this->assertEquals($db->updateAdminPassword($email,$password), 'fail');
		
	}
	/**
     * @covers a
     */
	public function test_updateAdminPasswordinValid()
	{
		$email = "test@test.com";
		$password = "NewTestPassword";
		$db = new database();
		$this->assertEquals($db->updateAdminPassword($email,NULL), 'fail');
	}
	
	/**
     * @covers a
     */
	public function test_setStudentActiveValid()
	
	{  // (1651248, "ricky", "roberts", "Ricke@roberts.com", 0, 1253481, "where am I", "everywhere", -5), "pass");
		$email = "Ricke@roberts.com";
		$isActive = rand(2,10);
		$db = new database();
		$this->assertEquals($db->setStudentActive($email,$isActive), 'pass');
	}
	/**
     * @covers a
     */
	public function test_setStudentActiveinValid()
	
	{
		$email = "Ricke@roberts.com";
		$isActive = "not an int";
		$db = new database();
		$this->assertEquals($db->setStudentActive($email,NULL), 'fail');
	}
	
	/**
     * @covers a
     */
	public function test_AdminActiveValid()
	
	{
		$email = "test@test.com";
		$isActive = rand(1,10);
		$db = new database();
		$this->assertEquals($db->setStudentActive($email,NULL), 'fail');
		
	}
	/**
     * @covers a
     */
	
	public function test_AdminActiveinValid()
	
	{
		$email = "test@test.com";
		$isActive = rand(1,20);
		$db = new database();
		$this->assertEquals($db->setStudentActive($email,$isActive), 'fail');
	}
	/**
     * @covers a
     */
	function test_updateStudentHotelValid()
	{
		$student = "jcarm012@fiu.edu"; $hotel = 52;
		$db = new database();
		$this->assertEquals($db->updateStudentHotel($student,$hotel), true);
		
	}
	/**
     * @covers a
     */
	function test_updateStudentHotelInValid()
	{
		$student = "jcarm012@fiu.edu"; $hotel = 52;
		$db = new database();
		$this->assertEquals($db->updateStudentHotel($student, NULL), false);
	}
	
	/**
     * @covers a
     */
	function test_getGameValid()
	
	{
		$game = 1;
		$db = new database();
		
			return $this->assertEquals(count($db->getGame($game)), 7);
		
	}
	/**
     * @covers a
     */
	function test_getGameinValid()
	
	{
		$game = -1;
		$db = new database();
		return $this->assertEquals(count($db->getGame($game)), 0);
	}
	
	/**
     * @covers a
     */
	function test_getGroupValid()
	
	{
		$group = 46;
		$db = new database();
		
		return $this->assertEquals(count($db->getGroup($group)), 10);
	}
	/**
     * @covers a
     */
	function test_getGroupinValid()
	
	{
		$group = -1;
		$db = new database();
		
			return $this->assertEquals(count($db->getGroup($group)), 0);
	}
	/**
     * @covers a
     */
	function test_getGameByCourseValid()
	
	{		$course = 75648;
	
			$db = new database();
		
			return $this->assertEquals(count($db->getGameByCourseNumber($course)), 7);
	
	}
	/**
     * @covers a
     */
	function test_getGameByCourseinValid()
	
	{
		$course = 75699;
	
			$db = new database();
		
			return $this->assertEquals(count($db->getGameByCourseNumber($course)), 0);
	
	
	}
	/**
     * @covers a
     */
	function test_getLocationValid()
	
	{
		$loc =12345;
		$db = new database();
		
			return $this->assertEquals(count($db->getLocation($loc)), 2);
	
		
	}
	/**
     * @covers a
     */
	function test_getLocationinValid()
	
	{
	$loc =123456;
		$db = new database();
		
			return $this->assertEquals(count($db->getLocation($loc)), 0);
	
	}
	/**
     * @covers a
     */
	function test_getAllGames()
	{
		$db = new database();
		return $this->assertgreaterThan(0,count($db->getGameAllGames()));
		
	}
	/**
     * @covers a
     */
	
	/**
     * @covers a
     */
	function test_getAdvertisingValid()
	{
		$db = new database();
		return $this->assertGreaterThan(0,count($db->getadvertising()), 0);
		
	}
	/**
     * @covers a
     */
	
	function test_newHotelValid()
	{  //newHotel($name, $location, $type, $game, $balance, $revenue, $rooms, $isActive)
		$db = new database();
		return $this->assertGreaterThan(0,count($db->newHotel('abc Test', 12345, "economy", 3, 50000, 35000, 50.00, -1)));
	}
	/**
     * @covers a
     */
	
	
	/**
     * @covers a
     */
	function test_SearchHotelsValid()
	{
			$name ="ABC Marketing";
			$db = new database();
		
			return $this->assertGreaterThan(0, count($db->searchHotel($name)));
	}
	/**
     * @covers a
     */
	function test_SearchHotelsInValid()
	{
			$name = "zzzzz";
			$db = new database();
		
			return $this->assertLessThan(1, count($db->getLocation($name)));
	}
	/**
     * @covers a
     */
	function test_getGroupsForGameValid()
	
	{
			$id =3;
		
			$db = new database();
		
			return $this->assertGreaterThan(0, count($db->getGroupsforGame($id)));
	}
	/**
     * @covers a
     */
	function test_getGroupsForGameinValid()
	
	{
			$id =-2;
		
			$db = new database();
		
			return $this->assertLessThan(1, count($db->getGroupsforGame($id)));
	}
	
	
	

}
?>
