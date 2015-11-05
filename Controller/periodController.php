<?php
ini_set('display_errors', 1);
error_reporting(~0);
//require ("/srv/marketsim/www/Model/database.php");
//require ("/srv/marketsim/www/Model/database.php");
if(isset($_POST['commitText']))
{
	
	//echo $_POST['commitText'];
	
}


class periodController
{


//the get display function takes a group and returns all values needed for homepage in and array of arrays
	public function getDisplay($email)

	{
		$obj = new database();
		$stuArr = $obj->getStudent($email);
		$stuGroup = $obj->getGroup($stuArr['hotel']);
		$stuLoc = $obj-> getLocation($stuGroup['location']);
		//$str = implode(" ", $stuGroup);
		//print_r($stuGroup['name']);
		
		$game = $obj->getGame($stuGroup['game']);
		
		$period = $game['periodNum'] -1;
		
		
		
		//var_dump($period);
		//print_r("current period is " . $period);
		$periodDecName = "GAME_" . $stuGroup['game'] . "_P_". ($period);
		$decisions = $obj->getStudentDecisions($periodDecName, $stuGroup['id']); // = false for first period
		
		$advertTotal = $obj->getadvertising();
		$adSize = count($advertTotal);
		//getting advertising list for home display - this is only those selected by student
		$personnelName = $obj->getPersonnel();
		//var_dump($personnelName);
		$personnel = array();
		$temp = "You have selected:<br/>";
		
		
		$advertising = array();
		if($decisions != false)
		{
		for($a = 1; $a< $adSize; $a++)
		{
			$adv = "adv" . $a;
			if($decisions[$adv] == 0)
			{
				break;
			}
			else
			{
				$temp = $obj->getadvertisingNameAndPrice($a);
				
				array_push($advertising, $temp)	; // $advertising [0][0]['type'] then [1][0] and [2][0] to access
			}
			
			
		}
		
		
		//getting selected personnel
		
		
		for($a = 1; $a< 4; $a++)
		{
			
			$per = "P" . $a;
			if($decisions[$per]!= 0)
			{
				
				$temp .= "<p>" .
				$a . 
				" ". 
				$personnelName[$a]['name'] 
				." $". ($personnelName[$a]['cost'] 
				* $a) .
				"</p>";
				
				array_push($personnel, $temp)	; 
			
			
			}
		}
		}
		$groups = $obj->getGameGroupsId($stuGroup['game']);
		//var_dump($groups);
		$returnArray = array();
		
		$makertshare = periodController::marketShare($periodDecName, $game, $groups); // this will be moved to commit later
		
		$groupcount = $obj->getGameGroupCount($game['id']);
		$groupcount = implode("", $groupcount);
		//var_dump($groups);
			//var_dump($stuGroup['id']);
			//var_dump($makertshare);
			if($makertshare != false)
			{
			$marketShareByGroup = array();
		for($k = 0; $k <  $groupcount; $k++)
		{
			$id = $groups[$k]['id'];
			$temp = "group" . $id;
						
				array_push($marketShareByGroup, $makertshare[$temp]);
			
			
		}
		}
		else
		{
			$marketShareByGroup = false;
		}
		
		$rev = $obj->getRevenue($stuArr['hotel']);
		
		$leaderboard = $obj -> getLeaderboardTable($stuGroup['game']);
		//sorting array to present in descending order
		for($i = 0; $i< count($leaderboard ); $i++)
		{
			for($j = 0; $j< count($leaderboard ); $j++)
			{
				if(intval($leaderboard[$i]['revenue']) > intval($leaderboard[$j]['revenue']))
				{
					$temp = $leaderboard[$j]['revenue'];
					$leaderboard[$j]['revenue'] = $leaderboard[$i]['revenue'];
					$leaderboard[$i]['revenue'] = $temp;
				}
			}
		}
		
		$selectedResearch = $obj->getPeriodResearch($periodDecName, $stuGroup['id']);
		$researched = array();
		//var_dump($selectedResearch);
		if($selectedResearch != false)
		{
			foreach ($selectedResearch as $res)
			{
				foreach($res as $r)
				{
			//var_dump($res);
					if($r!= "NULL")
					{
				
					array_push($researched, $r);
					}
			
				}
			}
		}
		//var_dump($researched);
		$researchDisplay = "You have not selected a group to research yet";
		$researchDisplay2 = "";
		$resCount = 1;
		if(count($researched) > 0)
		{
			$temp = "research" . $resCount;
			$researchDisplay = "</h4><h4 style = 'color:green'>" .$researched[0]."<h4 style='font-weight: bold'>
								<h4>Average rate : $";
			$id = $obj->gethotelIdbyName($researched[0]);	
			//Var_dump($researched[0]);
			$decs = $obj->getStudentDecisions($periodDecName, $id[0]['id'])	;	
			//var_dump($decs);
			$researchDisplay.= $decs['aveRate'];
			
			//Var_dump($decs['aveRate']);
			$resAdvert = array();
			for($a = 1; $a< $adSize; $a++)
			{
				$adv = "adv" . $a;
				if($decisions[$adv] == 0)
				{
					break;
				}
				else
				{
					$temp = $obj->getadvertisingNameAndPrice($a);
					
					array_push($resAdvert, $temp)	; // $advertising [0][0]['type'] then [1][0] and [2][0] to access
				}
			
			
			}		
				$i = 0;
				$researchDisplay.= "</h4><h4 style='font-weight: bold'> Advertising:</h4><h4>";
				foreach($resAdvert as $ad)
				{
					//print_r($resAdvert[$i][0]['type']);
					$researchDisplay.="<h4>" .$resAdvert[$i][0]['type'] . "</h4>" ;
					$i++;							
				}	
				
				$researchDisplay2 .= "<br/><h4 style='font-weight: bold'>Number of personnel<h4><h4>Entry Level : ".$decs['P1'] ."</h4>
				<h4>Manager in training : ".$decs['P2'] ."</h4>
				<h4>Experienced Professional : ".$decs['P3'] ."</h4>";
				
				$researchDisplay2.="<h4 style='font-weight: bold'>OTA Allocations : " . $decs['OTA'] . "</h4>";
			
				
		}
		
		
		//var_dump($leaderboard);
		
		
		// I need to return research for the prior period.  That means that I need to update the database with all the entries
		//I think I will merely return a string here or empty string if use hasn't selected research

		
		array_push($returnArray, $decisions, $stuArr, $stuGroup, $stuLoc, $game ,$periodDecName , $advertising, $personnel, $period, $makertshare, $marketShareByGroup, $groups, $rev, $leaderboard, $researchDisplay, $researchDisplay2 );
		
		return $returnArray;
		
	}
	
	public static function  marketShare($gamePeriod, $game)
	{
		
		$obj2 = new database();
		$groupcount = $obj2->getGameGroupCount($game['id']);
		//var_dump($groupcount);
		$groupcount = implode("", $groupcount);
		$marketShare = $gamePeriod . "_MarketShare";
		$temp = $obj2->getMarketShareTable($gamePeriod);
	//var_dump($temp);
	return $obj2->getMarketShareTable($gamePeriod);
	}
	
	public static function commit($comments, $email)
	{
		//this call to createMarketShare will be moved to the commit button
		
		$obj = new database();
		$stuArr = $obj->getStudent($email);
		$stuGroup = $obj->getGroup($stuArr['hotel']);
		$stuLoc = $obj-> getLocation($stuGroup['location']);
		//$str = implode(" ", $stuGroup);
		//print_r($stuGroup['name']);
		
		$game = $obj->getGame($stuGroup['game']);
		
		$period = $game['periodNum'];
		
		//var_dump($period);
		//print_r("current period is " . $period);
		$groupcount = $obj->getGameGroupCount($game['id']);
		$groupcount = implode("", $groupcount);
		$periodDecName = "GAME_" . $stuGroup['game'] . "_P_". ($period);
		$groups = $obj->getGameGroupsId($stuGroup['game']);
		$marketShare = $periodDecName . "_MarketShare";
		
		if($obj->isMarketShare($marketShare) == 0) //if the table doesn't already exist, create it, otherwise update it
		{
		
			$obj->createMarketShare($periodDecName, $groupcount,$groups, $period );
		
		}
		
		
			/*This will be moved to the commit button
			**************************this update will be replaced when the game functionality is better understood.  ***************************
			****************************For now, the number of rooms and rooms sold are selected arbitrarily*****************************/
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
			array_push($byGroup,($roomsSold - $counter));
			print_r(count($obj->isMarketShareForPeriod($periodDecName, $period)));
			if(count($obj->isMarketShareForPeriod($periodDecName, $period)) < 2)
			{
				print_r($obj->updateMarketShare($periodDecName,$groupcount, $rooms, $roomsSold, $byGroup, $groups, $period));
				$obj->incrementGamePeriodNum($game['id'], $period+1); // this will have to be removed from the final version when we have the game working - instead this will depend on a timer
				//HERE i HAVE TO ADD THE COMMENTS
				$obj->addComments($game['id'], $period, $stuGroup['id'], $comments);
				$obj->addNews( $game['periodNum'], '', $period+2);
				return true;
			}
			else
			{
			 print_r("You have already committed for this period");
			 header("Location: ../index.php");
			}
			
			//*************************end of arbitrary assignment of rooms sold for period
		
		
	
	}

}
?>