<?php
ini_set('display_errors', 1);
error_reporting(~0);
require ("/srv/marketsim/www/Controller/periodController.php");
require ("/srv/marketsim/www/Model/database.php");

		$game =3;
		$period =1;
		$group = 110;

		$periodCon = new periodController;
		$obj = new database();
		
		$groups = $obj->getGroupsIDforGame($game); // getting all the groups for this game
	
		$impactArr = array();
		$decisions = $obj->getDecisionsImpact($game,$period, $group);//decisions is an array of decimals representing the impact on game
		
		$effects = $obj->getNewsEffects(3,1);
		
	//I need to check if Omega applies to a group in question
	
	//I think here we need to have IMPACT_SUB_J either see if muOmega applies to a group or call a function that does
		
		foreach($groups as $g)
		{
			$muOmega  =1.0;
			foreach($effects as $E)
			{
			
			//here I am checking if news impact by location or market segment applies to a group
				if($g['location'] == $E['hotel_location'] || strtoupper($g['hotel_type']) == strtoupper($E['hotel_type']))
				{
					$muOmega = $muOmega * periodController::muOmega($E['effect']);
				}
			}
			
			//array of arrays containing groupnumber and I_sub_j
			array_push($impactArr, $arr = array($g['id'], $periodCon->IMPACT_SUB_J($obj->getDecisionsImpact($game,$period, $g['id']), $muOmega)));
		}
		//var_dump($impactArr);
		$num_of_total_rooms = $obj->getTotalRooms();
		$theta = periodController::theta($impactArr, count($groups), intval($num_of_total_rooms[0]['rooms']));
		
		$BETA = array();
		foreach($groups as $gg)
		{
			$temp  = $periodCon->BETA_SUB_J($gg['id'], $game, $period, $theta);
			$temp2 = array("group"=>$gg['id'], "BETA_J"=>$temp);
			array_push($BETA, $temp2 );
		}
		
		//sorting array of BETA
		usort($BETA, 'periodController::compare_BETA_J'); // sorting Beta in order by BETA_J


		// now I need to reverse indices
		$revBeta = $periodCon->reverseBETA($BETA);

		
		
		
		$DELTA = array();
		foreach($groups as $gg)
		{
			$temp = $periodCon->DELTA ($game, $period, 	$revBeta, $gg['id']);
			$temp2 = array("group"=>$gg['id'], "DELTA"=>$temp);
			array_push($DELTA, $temp2);
			
		}
		//var_dump($DELTA);
		
		
		
		
		
		

?>