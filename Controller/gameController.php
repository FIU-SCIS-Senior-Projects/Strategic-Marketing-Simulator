<?php
ini_set('display_errors', 1);
error_reporting(~0);
require ("/srv/marketsim/www/Controller/periodController.php");
//require ("/srv/marketsim/www/Model/database.php");



class gameController
{
	public function endPeriod ($game, $period)//_, $group)
	{
	//echo "inside of endperiod function";
		$periodCon = new periodController;
		$obj = new database();
		
		$groups = $obj->getGroupsforGame($game); // getting all the groups for this game
		
		$impactArr = array();
//		$decisions = $obj->getDecisionsImpact($game,$period, $group);//decisions is an array of decimals representing the impact on game
		
	//	echo "decisions:<br/>";
		//var_dump($decisions);
		//var_dump($game);var_dump($period);
		$effects = $obj->getNewsEffects($game,$period);
	
		
		foreach($groups as $g)
		{
			$muOmega  =1.0;
			
			if(count($effects !=0))
			{
				foreach($effects as $E)
				{
			
			
			
			//here I am checking if news impact by location or market segment applies to a group
					if($g['location'] == $E['hotel_location'] 
					|| strtoupper($g['hotel_type']) == 
					strtoupper($E['hotel_type']))
					{
								$muOmega = $muOmega * periodController::muOmega($E['effect']);
								
					}
				}
				
			}
			
			//array of arrays containing groupnumber and I_sub_j
		
			$temp = $obj->getDecisionsImpact($game,$period, $g['id']);
			//var_dump($temp);
			echo "<br/>";
			$impactTemp = $periodCon->IMPACT_SUB_J($temp, $muOmega);
			$temparr = array($temp,$impactTemp );
			array_push($impactArr, $temparr);
		
		}
		
		
		//echo "impact array: ";
		//var_dump($impactArr);exit;
		
			
		
		//var_dump($impactArr);
		//var_dump($impactArr);
		$num_of_total_rooms = $obj->getTotalRooms();
		$theta = periodController::theta($impactArr, count($groups), intval($num_of_total_rooms[0]['rooms']));
		//var_dump($theta);
		//echo "<br/>Theta:<br/>";
		
		
		//getting all Beta(market Share Array
		$BETA = array();
		foreach($groups as $gg)
		{
			$temp  = $periodCon->BETA_SUB_J($gg['id'], $game, $period, $theta);
			$temp2 = array("group"=>$gg['id'], "BETA_J"=>$temp);
			array_push($BETA, $temp2 );
		}
		//echo "<br/>I Beta:<br/>";
		//var_dump($BETA) ;
		//echo"<br/><br/>";
		usort($BETA, 'periodController::compare_BETA_J'); // sorting Beta in order by BETA_J


		// now I need to reverse indices
		$revBeta = $periodCon->reverseBETA($BETA);
	//	var_dump($revBeta);exit;
		//reBeta is the new BETA to used to fill the revenue table
	
		
		
		$DELTA = array();
		foreach($groups as $gg)
		{
			$temp = $periodCon->DELTA ($game, $period, 	$revBeta, $gg['id']);
			$temp2 = array("group"=>$gg['id'], "DELTA"=>$temp);
			array_push($DELTA, $temp2);
			
		}
		//var_dump($DELTA);
		//fill marketshare table
		
		foreach($revBeta as $MS)
		{
		//var_dump($theta);
		//var_dump($MS); 
		
			$obj->insertBeta($game, $period,$theta, $MS);
			//exit;
		}
		
		foreach($DELTA AS $d)
		{
			$obj->insertRevenue($game,$period, $d);
			//var_dump($d);
		}
		
		$trp = $obj->incrementGamePeriodNum($game, $period);
		//var_dump($trp);
		header("location: /index.php");
		
		//I need to add a check to see if a group hasn't made strategic decisions yet.  If not, we need to handle those some how
		
		//now we have all of the values needed for end of period
		
		//also need to add news article to next period
		
		//add period to database
		
		//I need to add revenue up for each group
	}

}

?>