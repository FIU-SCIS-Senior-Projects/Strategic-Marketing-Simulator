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
		
		$groups = $obj->getGroupsforGame($stuGroup['game']);
		
	
		//print_r("current period is " . $period);
		//print_r($obj->getStudentDecisions2($game['id'], $period+1, $stuGroup['id']));
		$decisions = $obj->getStudentDecisions2($game['id'], $period+1, $stuGroup['id']); // = false for first period
	
	
		
		//getting advertising list for home display - this is only those selected by student
		$personnelName = $obj->getPersonnel();
	
		$personnel = array();
		$temp = "You have selected:<br/><br/>";
		
		
		$advertising = array();
		if($decisions != false)
		{
		for($a = 0; $a< 11; $a++)
		{
			$adv = "adv" . ($a+1);
			if($decisions[0][$adv] == 0)
			{
				break;
			}
			else
			{
				$temp = $obj->getadvertisingNameAndPrice($a+1);
				
				array_push($advertising, $temp)	; // $advertising [0][0]['type'] then [1][0] and [2][0] to access
			}
	
		
			
		}
		
		
		//getting selected personnel
		
		
		for($a = 1; $a< 4; $a++)
		{
			
			$per = "P" . $a;
			if($decisions[0][$per]!= 0)
			{
			
				
				$perTemp = "<p>You selected " .
				$decisions[0][$per] . 
				" ". 
				$personnelName[$a-1]['name'] 
				." at a cost of $". floatval($personnelName[$a-1]['cost'] ).
				
				"each </p>";
				
				array_push($personnel, $perTemp)	; 
			
			
			}
		}
		}
		
	
		$returnArray = array();

		$marketshare = $obj->getMarketShare ($stuGroup['game'],$period ); // this will be moved to commit later
	
		$groupcount = $obj->getGameGroupCount($game['id']);
		$groupcount = implode("", $groupcount);
		
		
		$rev = $obj->getRevenue($stuArr['hotel']);
		
		$leaderboard = $obj -> getLeaderboardTable($stuGroup['game']);
		$leaderboard = array_reverse($leaderboard);
		$selectedResearch = $obj->getPeriodResearch($stuGroup['game'], $game['periodNum'],$stuGroup['id']);
	
		$researched = array();
		$resHotelId = NULL;
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
			$resHotelId = $obj->gethotelIdbyName($researched[0]);
		}

		$researchDisplay = "you have not selected research for this period";
		$researchDisplay2 = "";
		$resCount = 1;
		
		if($resHotelId  != null)
		{
		
		$resDecisions = $obj->getAdvertFromStrats($stuGroup['game'], $period,$resHotelId[0]['id']);
		//var_dump($resDecisions);
		if(count($researched) > 0)
		{
			$temp = "research" . $resCount;
			$researchDisplay = "</h4><h4 style = 'color:green'>" .$researched[0]."<h4 style='font-weight: bold'>
								<h4>Average rate : $";
			$id = $obj->gethotelIdbyName($researched[0]);	
		
			$researchDisplay.= $resDecisions[0]['aveRate'];
			
			//Var_dump($decs['aveRate']);
			$resAdvert = array();
			for($a = 1; $a< 12; $a++)
			{
				$adv = "adv" . $a;
				if($decisions[0][$adv] == "0")
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
				
				$researchDisplay2 = "<br/><h4 style='font-weight: bold'>Number of personnel<h4><h4>Entry Level : ".$decisions[0]['P1'] ."</h4>
				<h4>Manager in training : ".$decisions[0]['P2'] ."</h4>
				<h4>Experienced Professional : ".$decisions[0]['P3'] ."</h4>";
				
				$researchDisplay2.="<h4 style='font-weight: bold'>OTA Allocations : " . $decisions[0]['OTA'] . "</h4>";
			
			}	
		}
		else
		{
			$researchDisplay = "you have not selected research for this period";
			$researchDisplay2 = "";
		}
		
		
	
		
		
		// I need to return research for the prior period.  That means that I need to update the database with all the entries
		//I think I will merely return a string here or empty string if use hasn't selected research

		$groupMarketShare = $obj->getMarketShareforGroup($stuGroup['game'], $period, $stuGroup['id']);
		array_push($returnArray, $decisions, $stuArr, $stuGroup, $stuLoc, $advertising, $personnel, $period, $marketshare, $groups, $rev, $leaderboard, $researchDisplay, $researchDisplay2, $groupMarketShare  );
		//var_dump($groupMarketShare);
		return $returnArray;
		
	}
	
	
	//γ gamma is a random number between .95 and 1.05 that is applied to each decisions that a group makes and to the news impact
	public static function gamma()
	{
		while(($gamma = rand(95,105)/100) != 0)
		{return $gamma;}
		return .9;
		
	}
	//μ and ω (mu and omega) are impacts between .7 and 1.3 applied to the game 
	//they come in the form of failry god
	public static function muOmega($muOmega)
	{
		switch ($muOmega) {
			case "Very Good":
			return 1.3;
			break;
			case "Fairly Good":
			return 1.15;
			break;
			case "None":
			return 1;
			break;
			case "Fairly Bad":
			return .85;
			break;
			case "Very Bad":
			return .7;
			break;
			default: return "no valid mu/omega provided";
       }
}
	
	//the impact function queries the strat decisions table at the end of a period and does some math.
	
	//= I_j=[ ∏_(i=0)^n▒〖φ_i γ_i 〗]μωγ   // see accompanying documentation
	public function IMPACT_SUB_J($decisions, $muOrOmega)
	{
		$I = 0.00;
				
		foreach ($decisions as $d)
		{
			
			$I = $I + (floatval($d)  * periodController::gamma());  //sum of decisions impact * random modifier gamma
		}
		
		return $I * ($muOrOmega * periodController::gamma()); // news impact * modifier * summation of modified decisions 
		
	}
	
	//delta returns a group's revenue for a period.  it is modified by ro (OTA) which sells rooms at a reduced price epsilon
	//$alpha is the average rate for a group
	public function DELTA ($game, $period, $beta, $group)
	{
		$obj = new database();
		$epsilon = $obj->Epsilon($game, $period, $group);
		
		$ro= $obj->getOTA();
		$aveRateArr = $obj->Alpha($game, $period);
		$alpha = 0;
		$BETA_J = 0;
		
		
		foreach($aveRateArr as $s) // getting alpha for group g
		{
						
			if($s['hotel'] == $group)
			{
				$alpha = $s['aveRate'];
				
		
			}
		}
		foreach($beta as $b) // getting alpha for group g
		{
						
			if($b['group'] == $group)
			{
				$BETA_J = $b['BETA_J'];
					
			}
		}
		
		
		return floor($alpha *(($BETA_J - $epsilon[0]['OTA']) + ($epsilon[0]['OTA']*$ro[0]['discount'])));
	}
	
	 

  // sort alphabetically by name

		public static function compare_BETA_J($a, $b)
		{
			return strnatcmp($a['BETA_J'], $b['BETA_J']);
		}
		
		public function reverseBETA($BETA)
		{
			$count = intval(count($BETA) / 2);
						
			for($i = 0; $i < $count; $i++)
			{
				$lower = $BETA[$i]['BETA_J'];
				$upper = $BETA[(count($BETA)-1)-$i]['BETA_J'];
				$BETA[$i]['BETA_J'] = $upper;
				$BETA[(count($BETA)-1)-$i]['BETA_J'] = $lower;
				
			}
			return $BETA;
		}
	
	
	//this function returns the matket share for a particular group.  number of rooms is rounded down to nearest int
	public function BETA_SUB_J($group, $game, $period, $theta)
	{
		$obj = new database();
		$SUM_OF_ALPHA = 0;
		$ALPHA_SUB_j = 1;
		$aveRateArr = $obj->Alpha($game, $period);
		
	
		foreach($aveRateArr as $sum) // getting sum of alpha and alpha for group g
		{
			$SUM_OF_ALPHA = $SUM_OF_ALPHA + $sum['aveRate'];
			
			
			if($sum['hotel'] == $group)
			{
				
				$ALPHA_SUB_j = $sum['aveRate'];
				
			}
		}
	
		return floor(($ALPHA_SUB_j * $theta) / $SUM_OF_ALPHA) + rand(-500,500);  // returning rooms sold * groups aveRate divided by sum of all ave rates
	
	}
	
	public static function theta($array_of_I, $num_of_groups, $num_of_total_rooms)
	{
		$I_SUM = 0.0;
		
		foreach($array_of_I as $I)
		{
				$I_SUM = $I_SUM + $I[1];
		}
		return floor($I_SUM * (floatval($num_of_total_rooms) / $num_of_groups));
	}
	
	
	
	public static function commit($comments, $email)
	{
		//this call to createMarketShare will be moved to the commit button
		
		//this is where I put the game math function calls
		
		$obj = new database();
		$stuArr = $obj->getStudent($email);
		$stuGroup = $obj->getGroup($stuArr['hotel']);
		$game = $obj->getGame($stuGroup['game']);
		$period = $game['periodNum'];
		$obj->addComments($game['id'], $period, $stuGroup['id'], $comments);
		header("Location: ../index.php");

		
	
	}
	
	

}
?>