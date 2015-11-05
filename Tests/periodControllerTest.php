<?php

require '../Model/database.php';
require '../Controller/periodController.php';
class databasetest extends \PHPUnit_Framework_testCase
{
	
	/**
     * @covers a
     */
/*	function test_getDisplay()
	{
		$email = "jcarm012";
		$obj = new periodController();
		return $this->assertGreaterThan(0,count( $obj->getDisplay($email)));
		
		//passed
		
	}*/
	/**
     * @covers a
     */
	function  test_marketShareValid()
	{
		$obj = new periodController();
		$obj2 = new database();
		$gamePeriod = "GAME_3_P_1";
		$game = $obj2->getGame(3);
		
		$obj = new periodController();
		return $this->assertGreaterThan(0,count( $obj->marketShare($gamePeriod, $game)));
		
	}
	/**
     * @covers a
     */
	function  test_marketShareinValidGamePeriod()
	{
		$obj = new periodController();
		$obj2 = new database();
		$gamePeriod = "GAME_3_P_11";
		$game = $obj2->getGame(3);
		
		
		$obj = new periodController();
		return $this->assertEquals(false, $obj->marketShare($gamePeriod, $game));
		
	}
	/**
     * @covers a
     */
	 function test_commit()
	
	{
		$obj = new periodController();
		$email = "jcarm012@fiu.edu";
		$comments = "These are my comments";
		return $this->assertEquals(true, $obj->commit($comments, $email));
		
	}
	/**
     * @covers a
     */
	 
	/* function test_commitInvalid()
	
	{
		$obj = new periodController();
		$email = "notavalidemail@notvalid.com";
		$comments = "These are my comments";
		return $this->assertEquals(false, $obj->commit($comments, $email));
		//passed
	}*/
	
	

	/*function test_getDisplay()
	
	
	*/
	
	}