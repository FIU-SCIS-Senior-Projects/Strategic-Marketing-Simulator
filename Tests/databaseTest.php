<?php

require '../Model/database.php';
class databasetest extends \PHPUnit_Framework_testCase
{
	 
     /*
	  public function test__constructInvalidPar()
    {
        $m = new database('EUR');
        $this->assertInstanceOf(database::class, $m);
        return $m;
    }
	
     
	 public function test__construcValidPar()
    {
        $m = new database();
        $this->assertInstanceOf(database::class, $m);
        return $m;
    }
	 
     
	public function test_searchForStudentsFound()
	{
		$db = new database();
		return $this->assertEquals(count($db->searchForStudents("jcarm012@fiu.edu")), 10);
				
		
	}
	 
     
	public function test_searchForStudentsNotFound()
	{
		$db = new database();
		return $this->assertEquals(count($db->searchForStudents("beaver")), 0);
				
		
	}
	 
     
	public function test_getStudentFound()
	{
		$db = new database();
		return $this->assertEquals(count($db->getStudent("2654698")), 10);
				
		
	}
	 
     
	
	public function test_getStudentNotFound()
	{
		$db = new database();
		return $this->assertEquals(count($db->getStudent("stickle")), 0);
				
		
	}
	 
     
	
	public function test_addStudent()
	{
		
	

		$db = new database();
		return $this->assertEquals($db->addStudent(1651248, "ricky", "roberts", "Ricke@roberts.com", 0, 1253481, "where am I", "everywhere", -5), "pass");
				
		
	}
	 
     
	public function test_genPass()
	{
			$pwd = "somePass1234";
			$email = "some@email.com";
			$db = new database;
			$db2 = new database;
			
			
			$this->assertEquals($db->genPass($pwd, $email),$db2->genPass($pwd, $email));
	}
	
     
	
	public function test_updateStudentPassword()
	{
		$email = "jcarm012@fiu.edu";
		
		
		$db = new database();
		
		$pwd = $db->genPass($email, "Jeff_1230");
		
		$this->assertEquals ($db->updateStudentPassword($email, $pwd), "pass");
	
	}
	
     
	
	public function test_updateStudentPasswordInValid()
	{
		$email = "jcarm012@fiu.edu";
		
		
		$db = new database();
		$this->assertEquals($db->updateStudentPassword($email, 'NULL'), "pass");
	
	}
	
     
	
	public function test_addGameValid()
	{
		//public function addGame($semester,$courseID,$section,$schedule,$isActive,$courseNumber)
		$db = new database();
		$semester = "testSemester";
		$courseID = "1234567test";
		$schedule = "3:45-5 test";
		$section = "abcdSectiontest";
		$isActive = -5;
		$courseNumber = "testCourseNumber";
		
		$this->assertEquals($db->addGame($semester,$courseID,$section,$schedule,$isActive,$courseNumber), "pass");
		
		
	
	}
	
     
	public function test_addGameinValid()
	{
		$db = new database();
		$semester = "testSemester";
		$courseID = "1234567test";
		$schedule = "3:45-5 test";
		$section = "abcdSectiontest";
		$isActive = -5;
		$courseNumber = "testCourseNumber";
		
		$this->assertEquals($db->addGame($semester,$courseID,$section,$schedule,NULL,$courseNumber), "fail");
		
	
	}
	
	
	
     
	
	public function test_updateAdminPasswordValid()
	{
		$email = "test@test.com";
		$password = "NewtestPassword";
		$db = new database();
		$this->assertEquals($db->updateAdminPassword($email,$password), 'fail');
		
	}
	
     
	public function test_updateAdminPasswordinValid()
	{
		$email = "test@test.com";
		$password = "NewtestPassword";
		$db = new database();
		$this->assertEquals($db->updateAdminPassword($email,NULL), 'fail');
	}
	
	
     
	public function test_setStudentActiveValid()
	
	{  // (1651248, "ricky", "roberts", "Ricke@roberts.com", 0, 1253481, "where am I", "everywhere", -5), "pass");
		$email = "Ricke@roberts.com";
		$isActive = rand(2,10);
		$db = new database();
		$this->assertEquals($db->setStudentActive($email,$isActive), 'pass');
	}
	
     
	public function test_setStudentActiveinValid()
	
	{
		$email = "Ricke@roberts.com";
		$isActive = "not an int";
		$db = new database();
		$this->assertEquals($db->setStudentActive($email,NULL), 'fail');
	}
	
	
     
	public function test_AdminActiveValid()
	
	{
		$email = "test@test.com";
		$isActive = rand(1,10);
		$db = new database();
		$this->assertEquals($db->setStudentActive($email,$isActive), 'pass');
		
	}
	
     
	
	public function test_AdminActiveinValid()
	
	{
		$email = "test@test.com";
		$isActive = "not an int";
		$db = new database();
		$this->assertEquals($db->setStudentActive($email,$isActive), 'fail');
	}
	
     
	function test_updateStudentHotelValid()
	{
		$student = "jcarm012@fiu.edu"; $hotel = 100;
		$db = new database();
		$this->assertEquals($db->updateStudentHotel($student,$hotel), true);
		
	}
	
     
	function test_updateStudentHotelInValid()
	{
		$student = "jcarm012@fiu.edu"; $hotel = 52;
		$db = new database();
		$this->assertEquals($db->updateStudentHotel($student, NULL), false);
	}
	
	
     
	function test_getGameValid()
	
	{
		$game = 1;
		$db = new database();
		
			return $this->assertEquals(count($db->getGame($game)), 7);
		
	}
	
     
	function test_getGameinValid()
	
	{
		$game = -1;
		$db = new database();
		return $this->assertEquals(count($db->getGame($game)), 0);
	}
	
	
     
	function test_getGroupValid()
	
	{
		$group = 46;
		$db = new database();
		
		return $this->assertEquals(count($db->getGroup($group)), 10);
	}
	
     
	function test_getGroupinValid()
	
	{
		$group = -1;
		$db = new database();
		
			return $this->assertEquals(count($db->getGroup($group)), 0);
	}
	
     
	function test_getGameByCourseValid()
	
	{		$course = 75648;
	
			$db = new database();
		
			return $this->assertEquals(count($db->getGameByCourseNumber($course)), 7);
	
	}
	
     
	function test_getGameByCourseinValid()
	
	{
		$course = 75699;
	
			$db = new database();
		
			return $this->assertEquals(count($db->getGameByCourseNumber($course)), 0);
	
	
	}
	
     
	function test_getLocationValid()
	
	{
		$loc =12345;
		$db = new database();
		
			return $this->assertEquals(count($db->getLocation($loc)), 2);
	
		
	}
	
     
	function test_getLocationinValid()
	
	{
	$loc =123456;
		$db = new database();
		
			return $this->assertEquals(count($db->getLocation($loc)), 0);
	
	}
	
     
	function test_getAllGames()
	{
		$db = new database();
		return $this->assertgreaterThan(0,count($db->getGameAllGames()));
		
	}
	
     
	
	
     
	function test_getAdvertisingValid()
	{
		$db = new database();
		return $this->assertGreaterThan(0,count($db->getadvertising()));
		
	}
	
     
	
	function test_newHotelValid()
	{  //newHotel($name, $location, $type, $game, $balance, $revenue, $rooms, $isActive)
		$db = new database();
		return $this->assertGreaterThan(0,count($db->newHotel('abc test', 12345, "economy", 3, 50000, 35000, 50.00, -1)));
	}
	
     
	
	
	
     
	function test_SearchHotelsValid()
	{
			$name ="ABC Marketing";
			$db = new database();
		
			return $this->assertGreaterThan(0, count($db->searchHotel($name)));
	}
	
     
	function test_SearchHotelsInValid()
	{
			$name = "zzzzz";
			$db = new database();
		
			return $this->assertLessThan(1, count($db->getLocation($name)));
	}
	
     
	function test_getGroupsForGameValid()
	
	{
			$id =3;
		
			$db = new database();
		
			return $this->assertGreaterThan(0, count($db->getGroupsforGame($id)));
	}
	
     
	function test_getGroupsForGameinValid()
	
	{
			$id =-2;
		
			$db = new database();
		
			return $this->assertLessThan(1, count($db->getGroupsforGame($id)));
	}*/
	
	///////Sprint 4 tests///////
	/*	function test_getadvertisingNameAndPriceValid()
	{
		$id = 3;
		$db = new database();
		
		return $this->assertGreaterThan(0, $db->getAdvertisingNameAndPrice($id));
	
	}
	
		function test_getadvertisingNameAndPriceInvalid()
	{
		$id = 'cow';
		$db = new database();
		$count = 1;
		

			
		return $this->assertEquals('error', $db->getAdvertisingNameAndPrice($id));
	
	}
		function test_getPersonnel()
	{
		
		$id = 4;
		$db = new database();
		
		return $this->assertGreaterThan(0, $db->getPersonnel($id));
	
	}
		function test_getResearch()
	{
		
		
		$db = new database();
		
		return $this->assertGreaterThan(0, $db->getResearch());
	}
	
		

	function test_getCurrentPeriod() 
	{
		$gameID = "1";
		$db = new database();
		
		return $this->assertEquals(1, count($db->getCurrentPeriod($gameID)));
		
	}
		
	function test_getCurrentPeriodInvald() 
	{
		$gameID = "cheese";
		$db = new database();
		
		return $this->assertEquals(0, count($db->getCurrentPeriod($gameID)));
		
	}
		function test_getOTA()
	{
		$db = new database();
		
		return $this->assertGreaterThan(0, $db->getOTA());
		
	}
		function test_updateOTA()
	{
		$min = .7;
		$max = .9;
		$discount = rand($min, $max);
		$db = new database();
		
		return $this->assertEquals(true, $db->updateOTA($discount));
		
	}
		function test_updateOTAInvalid()
	{
		
		$discount = "puppies";
		$db = new database();
		
		return $this->assertEquals(false, $db->updateOTA($discount));
		
	}
	
		
	/*function updateAdvPerOrResearch($table, $id, $cost, $impact)*/
	
	/*function test_isDecisionTable() //good!
	{
		$periodTable = "GAME_3_P_1";
		$db = new database();
		
		
		return $this->assertEquals(1, $db->isDecisionTable($periodTable));
		
	}
	
		
	function test_isDecisionTableInvalid() //good!
	{
		$periodTable = "GAME_3_P_16"; // invalid game
		$db = new database();
		
		return $this->assertEquals(0, $db->isDecisionTable($periodTable));
		
	}
	
		function test_getDecisionsTableColumns()
	{
		
		$tableName = "GAME_3_P_1";
		$db = new database();
		
		return $this->assertGreaterThan(0, $db->getDecisionsTableColumns($tableName));
		
	}
		function test_getDecisionsTableColumnsInvalid()
	{
		
		$tableName = "GAME_3_P1"; // invalid game
		$db = new database();
		
		return $this->assertEquals(0, count($db->getDecisionsTableColumns($tableName)));
		
	}
			function test_getStudentDecisions()
	{
		$tableName = "GAME_1_P_1";
		$hotel = 46;
		$db = new database();
		return $this->assertGreaterThan(0, count($db->getStudentDecisions($tableName, $hotel)));
	}
		function test_getStudentDecisionsInvalid()
	{
		$tableName = "GAME_1_P_1";
		$hotel = 47;
		$db = new database();
		return $this->assertEquals(0, count($db->getStudentDecisions($tableName, $hotel)));
	}
	
			
	//function addDecisionsexistingTable($tableName, $gameid, $hotel, $periodNum, $advertising, $personnel, $OTA,$roomRate, $research, $adCount, $researchCount)
	
	function test_updateMarketSegment()
	{
		$segment = "luxury";
		$hotel = 47;
		$db = new database();
		return $this->assertEquals(1, count($db->updateMarketSegment($segment,$hotel)));
		
	}
	
	
		
	//function addNewPeriodDecisions($tableName, $gameid, $periodNum, $advertising, $personnel, $OTA, $research)
	
	public function test_addNews()
	
	{
		$game = 1;
		$article = "This is a small news article that could impact a game.";
		$period = 99;
		$db = new database();
		return $this->assertEquals(true, $db->addNews( $game, $article, $period));
		
	
	}
	

	public function test_addGame_period()
	
	{
		$game = 1;
		$pstart = '2016-10-20 00:00:00';
		$pend =  '2016-10-30 00:00:00';
		$isActive = 1;
		
		$db = new database();
		return $this->assertEquals('pass', $db->addGame_period( $game, $pstart, $pend, $isActive));
	}*/
	/*public function test_addNews_parameters()
	
	{
		$news_id = 99; 
		$effect = "Very Bad";
		$hotel_type = "Midrange";
		$hotel_location = 99;
		
		$db = new database();
		return $this->assertEquals(NULL, $db->addNews_parameters( $news_id, $effect, $hotel_type, $hotel_location));
	
	}*/
	
	
	/*public function test_getNews_by_id() 
	{
		$value = 2; 
		$db = new database();
		return $this->assertGreaterThan(0, count($db->getNews_by_id($value)) );
	}*/
		/*public function test_getNews_by_idInvalid() 
	{
		$value = 15; 
		$db = new database();
		return $this->assertEquals(0, count($db->getNews_by_id($value)) );
	}*/
 		/*public function test_getNews_by_game() 
	
	{
		$value = 4;
		$period = 3;
		$db = new database();
		return $this->assertGreaterThan(0, count($db->getNews_by_game($value,$period) ) );
		
	}*/
	/*	public function test_getNews_by_gameInvalid() 
	
	{
		$value = 4;
		$period = 18;
		$db = new database();
		return $this->assertEquals(NULL, $db->getNews_by_game($value,$period)  );
		
	}*/
	
  	
/*	public function getAllNews_by_game($game) 
   	
	public function getAllNews_parameters($news_id) 
  	
	public function getGame_period($value) 
 	
	public function updateNews_article($id,$article)
   	
	public function updateNews_periodNum($id,$period)
   	
	public function test_updateGame_period()
    	
	public function test_removeNews_parameters()
   	
	public function test_removeNews()
   	
	function test_getLocationByType()
	
	
	*/
	
	

	/**
     * @covers a
     */
	
	
	
	function test_getMarketShareTable()
	{
		$obj = new database();
		$game_period = "GAME_3_P_1";
		
		return $this->assertGreaterthan(0, count($obj->getMarketShareTable($game_period)));
	}
	/**
     * @covers a
     */
	/*function test_updateMarketShare()
	{
		$obj = new database();
		$gamePeriod =   "GAME_3_P_2";
		$groups = $obj->getGameGroupsId(3);
		$groupcount = 6;
		$rooms = 2000;
		$roomsSold = 1600;
		$byGroup = array();
		$counter = 0;
		for($i = 1; $i < $groupcount; $i++)
			{	
				$temp = rand(200,320);
				array_push($byGroup, $temp );
				$counter = $counter + $temp;
			}
		
		$period = 2;
			
		return $this->assertGreaterthan(0, count($obj->updateMarketShare($gamePeriod, $groupcount, $rooms, $roomsSold, $byGroup, $groups, $period)));
		
		//this passede
	
	}*/
		/**
     * @covers a
     */
	/*function test_createMarketShare()
	{
		$obj = new database();
		$gamePeriod =   "GAME_3_P_16";
		$groups = $obj->getGameGroupsId(3);
		$groupcount = 6;
		$period = 16;
		
		return $this->assertEquals("Table created", $obj->createMarketShare($gamePeriod,$groupcount, $groups, $period));
		
		//test passed
	}*/
	/**
     * @covers a
     */
	function test_getGameGroupCount()
	{
		$obj = new database();
		$game = 3;
		return $this->assertGreaterThan(0, $obj->getGameGroupCount($game));
		
	}
	/**
     * @covers a
     */
	function test_getGameGroupsId()
	
	{
		$obj = new database();
		$game = 3;
		return $this->assertGreaterThan(0, $obj->getGameGroupsId($game));
		
	}
		/**
     * @covers a
     */
	function test_isMarketShare() // return 0 if table doesn't already exist and array if it does.
	{
		
		$marketshare = "GAME_3_P_1_MarketShare";
		$obj = new database();
		return $this->assertGreaterThan(0, $obj->isMarketShare($marketshare));
	}/**
     * @covers a
     */
	function test_getRevenue()
	{
		$obj = new database();
		$hotel = 110;
		return $this->assertGreaterThan(0, $obj->getRevenue($hotel));
	
		
	}
/**
     * @covers a
     */
	function test_getLeaderboardTable()
	{
		
		$obj = new database();
		$game = 3;
		return $this->assertGreaterThan(0, $obj->getLeaderboardTable($game));
	}
	/**
     * @covers a
     */
	function test_updatePurpose()
	{
		$obj = new database();
		$purpose = 'leisure';
		$hotel = 110;
		return $this->assertEquals(true, $obj->updatePurpose($purpose,$hotel));
	}/**
     * @covers a
     */
	function test_getPeriodResearch()
	{
		$obj = new database();
		$game = 'GAME_3_P_1';
		$hotel = 110;
		return $this->assertGreaterThan(0, $obj->getPeriodResearch($game,$hotel));
	
		
	}
	/**
     * @covers a
     */
	function test_gethotelIdbyName()
	{
		$name = "XYZ Marketing";
		$obj = new database();
		return $this->assertEquals(1, count($obj->gethotelIdbyName($name)));
	
	}

		/**
     * @covers a
     */
	function test_incrementGamePeriodNum()
	{
		$obj = new database();
		$game = 1;
		$period = 16;
		return $this->assertEquals(true, $obj->incrementGamePeriodNum($game, $period));
		
	}
		/**
     * @covers a
     */
	function  test_isMarketShareForPeriodValid()
	{
		$obj = new database();
		$marketshare = "GAME_3_P_1_MarketShare";
		$periodNum = 1;
		return $this->assertEquals(1, $obj->isMarketShareForPeriod($marketshare, $periodNum));
		
	}
		/**
     * @covers a
     */
	function  test_isMarketShareForPeriodinValid()
	{
		$obj = new database();
		$marketshare = "GAME_3_P_1_MarketSh0are";
		$periodNum = "carrot";
		return $this->assertEquals(-1, $obj->isMarketShareForPeriod($marketshare, $periodNum));
		
	}
		/**
     * @covers a
     */
	/*function test_addComments()
	{
		
		$obj = new database();
		$game = -1;
		$period = -1;
		$group = 110;
		$comments = "these are my comments for the period";
		return $this->assertEquals(true, $obj->addComments($game, $period, $group, $comments));
		
	}*/

		/**
     * @covers a
     */
	/*public function test_updateStudentQuestionValid()
	{
		$obj = new database();
		$email = "jcarm012@fiu.edu";
		$secretQuestion = "where are you?";
		$id = "2654698";
		return $this->assertEquals('pass', $obj->updateStudentQuestion($email,$secretQuestion,$id));
		//passed
	}
	/**
     * @covers a
     */
	/*public function test_updateStudentQuestionInValid()
	{
		$obj = new database();
		$email = "jcarm012@fiu.edu";
		$secretQuestion = "where are you?";
		$id = "2654691548";
		return $this->assertEquals('fail', $obj->updateStudentQuestion($email,$secretQuestion,$id));
		//passed
	}
	*/
	
  

 
	*/
	
	
	
	////////for the excel doc//////
	
	
	/*
	function test_getMarketShareTable()
	{
		$obj = new database();
		$game_period = "GAME_3_P_1";
		
		return $this->assertGreaterthan(0, count($obj->getMarketShareTable($game_period)));
	}
	
	function test_updateMarketShare($gamePeriod, $groupcount, $rooms, $roomsSold, $byGroup, $groups, $period)
		
	function test_createMarketShare($gamePeriod,$groupcount, $groups, $period)
	
	function test_getGameGroupCount($game)
	
	function test_getGameGroupsId($game)
		
	function test_isMarketShare($marketshare) // return 0 if table doesn't already exist and array if it does.
		
	function test_getRevenue($hotel)

	function test_getLeaderboardTable($game)
	
	function test_updatePurpose($purpose,$hotel){
  	
	function test_getPeriodResearch($gamePeriod, $group)
	
	function test_gethotelIdbyName($name)

	
	function test_incrementGamePeriodNum($game, $period)
	
	function  test_isMarketShareForPeriodValid()
	
	function  test_isMarketShareForPeriodinValid()

	function test_addComments($game, $period, $group, $comments)

	
	public function updateStudentQuestion($email,$secretQuestion,$id)

	
	public function test_updateAdminQuestion($email,$secretQuestion,$id)
  
	public function test_updateStudentAnswer($email,$secretAns,$id)

	
	public function test_updateAdminAnswer($email,$secretAns,$id)
    
	
	
	public function test_updateStudentPassword_by_id($email,$password,$id)
   
	
	public function test_updateAdminPassword_by_id()
 
	*/
}


?>


	
	
	

