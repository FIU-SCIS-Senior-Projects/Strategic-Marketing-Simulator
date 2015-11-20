<?php
/*created by Javier Andrial*/
ini_set('display_errors', 1);
error_reporting(~0);

//require ("/srv/marketsim/www/Model/database.php");
require ("/srv/marketsim/www/Model/Javis_database.php");

class NewsController
{
	function CreatePage($header,$value,$isAdmin)
	{	
		$temp = "";
		/*	if($isAdmin)
				$temp = "<input name='button_viewStudent' id='textbox_news' type = 'submit' value = 'view as student' class='btn btn-primary'/>";
			else
				$temp = "<input name='button_viewAdmin' type = 'submit' value = 'View as Admin' class='btn btn-primary'/>";*/
	
		$result = $header. 
				"<form action='' method='post'>".
					$temp.
					//"<div class='bs-example'>".
						//"<div class='panel panel-default'>".
							"<div class='' align='center' >".
								"<div class='panel-footer clearfix' style='width: 1080px' >".
								$value.
							   "</div>".
						   "</div>".
					"</form>";	
					
		return $result;
	}
	
	function startOverPage()
	{
		return "<h4>Clearing Parameters</h4>".
				"<br /><div align=center style='margin:auto; width:50%;'>".
				"<ul>".
				"<li><h5 align=left>Select Clear Session Parameters to clear your parameters for your current session.</h5></li>".
				"<li><h5 align=left>Select Clear DataBase Parameters to remove the current stored parameters for this news article</h5></li></ul></div>".
				"<br /><br />".
				"<input name='button_clearDBParams' type = 'submit' value = 'Clear DataBase Parameters' class='btn btn-primary'/> ".
				" <input name='button_clearSession' type = 'submit' value = 'Clear Session Parameters' class='btn btn-primary'/>".
				"";
	}
	
	function clearParameters($news_id)
	{
		$mydatabase = new DataBase();
		//$news = $mydatabase->getNews_by_id($news_id);
		if($mydatabase->removeNews_parameters($news_id) == "fail")
			return "<b>FAILED</b>.<br />Clearing Parameters on DataBase was unsuccesful.";
		return "<b>PASSED</b>.<br />All Parameters where removed from the DataBase.";
		
	}
	
	function getArticle($news_id)
	{
		$mydatabase = new DataBase();
		//$news = $mydatabase->getNews_by_game($game,$period);
		$news = $mydatabase->getNews_by_id($news_id);
		
		if(!isset($news)||count ($news)==0)
			return "fail";
				
		return $news['article'];		
		//return $news['article'];
	}
	
	function getGamePeriod($game_id)
	{
		$mydatabase = new DataBase();
		$game = $mydatabase->getGame($game_id);

		if(!isset($game)|| count($game)==0)
			return "fail";
				
		return $game['periodNum']; 
	}
	
	
	function getNewsPeriod($news_id)
	{
		$mydatabase = new DataBase();
		$news = $mydatabase->getNews_by_id($news_id);

		if(!isset($news)|| count($news)==0)
			return "fail";
				
		return $news['periodNum']; 
	}
	
	function getNews_id($game_id,$period)
	{
		$mydatabase = new DataBase();
		$news = $mydatabase->getNews_by_game($game_id,$period);

		if(!isset($news)|| count($news)==0)
			return "fail";
				
		return $news['id'];
	}	
	
	function getTable($news_id,$hotelType,$hotelLocation,$impactType)
	{
		$mydatabase = new DataBase();
		//$news = $mydatabase->getNews_by_game($game,$period);
		$news = $mydatabase->getNews_by_id($news_id);
		//print_r("Game: ".$game.", Period: ".$period);
		
		
		if(!isset($news)||count ($news)==0)
			return "fail";
		
		$parameters = $mydatabase->getAllNews_parameters($news['id']);
		
		$count = 0;		
		
		$result = '<h3 align="center"> News Affects Parameters</h3>'.'<br />'.
				'<table class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Hotel Type</th>
								<th>Hotel Location</th>
								<th>Impact</th>
							</tr>
					</thead>';
					
			if(isset($parameters) && count($parameters)>0)
			{
				foreach($parameters as $key => $temp )	
				{	
					$result .= "<tbody>".
							"<tr>".
								"<td>".(++$count)."</td>".
								"<td>".$temp['hotel_type']."</td>".
								"<td>".$mydatabase->getLocation($temp['hotel_location'])['type']."</td>".
								"<td>".$temp['effect']."</td>".
							"</tr>".
							"</tbody>";
				}
			}

					

			if(isset($hotelType) && isset($hotelLocation) && isset($impactType))
			{				
				for($counter = 0;$counter < count($impactType);$counter++)	
				{	
					$result .= "<tbody>".
							"<tr>".
								"<td>".($counter+1+$count)."</td>".
								"<td>".$hotelType[$counter]."</td>".
								"<td>".$hotelLocation[$counter]."</td>".
								"<td>".$impactType[$counter]."</td>".
							"</tr>".
							"</tbody>";
				}
			}

			$result.="</table><br />";
					
		return $result;
	}
	
	
	function chooseGame()
	{	
		$mydatabase = new database();
		$gamesArray = $mydatabase->getGameAllGames();
		
		
		$result = '<div class="table-responsive">
			<h3>Choose a Game to modify its News</h3><br />
			<table class="table table-bordered">
				<thead>
					<tr>
						<th></th>
						<th>Course #</th>
						<th>Course</th>
						<th>Semester</th>
						<th>Section</th>
						<th>Schedule</th>
						<th>is Active</th>
					</tr>
			</thead>';
		
		foreach($gamesArray as $key => $temp )
		{
			$result .="<tbody>"
					."<tr>"
					."<td>"."<input type='radio' name='gameRadio' value='".$temp['id']."'></td>"
					."<td>".$temp["courseNumber"]."</td>"
					."<td>".$temp["course"]."</td>"
					."<td>".$temp["semester"]."</td>"
					."<td>".$temp["section"]."</td>"
					."<td>".$temp["schedule"]."</td>"
					."<td>".$temp["isActive"]."</td>"
					."</tr>"
					."</tbody>";
		}

		$result .="</table>"."<input name='button_chooseGame' type = 'submit' value = 'Choose A Game' class='btn btn-primary'/>";
					
		return $result;
	}
	
	
	function student_news($email)
	{	
		$mydatabase = new database(); 
        $student = $mydatabase->getStudent($email);
		if(isset($student) && count($student) != 0 )
		{			
			$hotel = $mydatabase->getGroup($student['hotel']);
			if(!isset($hotel) || count($hotel) == 0 )
			{
				return "Hotel not Found.";
			}
		}
		else
		{
			return "Student not Found";
		}
		//$game_period = $mydatabase->getGame_period_by_game($hotel['game']);
		$game = $mydatabase->getGame($hotel['game']);
		
		$news = $mydatabase->getNews_by_game($hotel['game'],$game['periodNum']);
		
	
		//$results = 	"<p style='border:inset black 3px; margin:auto; width:70%; padding:1em;'>".$news['article']."</p>";
					
		$results = 	"<div class='' align='center' >".
					//"<div class='panel-footer clearfix' style='width: 1080px' >".
					$news['article'].
					"<br /><br />".	
					//"</div>".
					"</div>";
		//"<div style='width:200px;height:100px;padding:10px;border:10px outset bluegreen;'>".
										
							
							
		return $results;
	}
	
	
	function addPeriod($game)
	{
		$mydatabase = new database(); 
		$news = $mydatabase->getAllNews_by_game($game);
		
		/*if(!isset($news) || count($news) == 0 )
		{
			return "fail";
		}*/
		$max = 0;
		foreach($news as $key => $temp )
		{
			if($temp['periodNum'] > $max)
				$max = $temp['periodNum'];
		}
		$mydatabase->addNews($game, "This Article Has Not Yet Been Set.", (++$max));
		
		return 'pass';
	}// $mydatabase->getNews_by_game($game,$max)['article']
	
	function removePeriod($game)
	{
		$mydatabase = new database(); 
		$news = $mydatabase->getAllNews_by_game($game);
		
		if(!isset($news) || count($news) == 0 )
		{
			return "fail";
		}
		$max = 0;
		foreach($news as $key => $temp )
		{
			if($temp['periodNum'] > $max)
				$max = $temp['periodNum'];
		}
		if($max > 1)
			$mydatabase->removeNews($game,$max);
		else
			return "fail";
		
		return 'pass';
	}


	
	function choosePeriod($game)
	{
		$mydatabase = new database(); 
        //$game = $mydatabase->getGame($game);
		$news = $mydatabase->getAllNews_by_game($game);//$game['id']);
		
		$result = '<div class="table-responsive">
			<h3>Choose a Period</h3><br />
				<table class="table table-bordered">
					<thead>
						<tr>
							<th></th>
							<th>Period</th>
							<th>Article</th>
						</tr>
				</thead>';
		
		foreach($news as $key => $temp )
		{
			$result .="<tbody>"
					."<tr>"
					."<td>"."<input type='radio' name='periodRadio' value='".$temp['id']."'></td>"
					."<td>".$temp["periodNum"]."</td>"
					."<td>".substr(preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags( $temp["article"] ))) ), 0,30)." ..."."</td>"
					."</tr>"
					."</tbody>";
		}
		$result .= "</table>".
		"<br />".
		"<input name='button_choosePeriod' type = 'submit' value = 'Choose a Period'  class='btn btn-primary'/> ".
		" <input name='button_removePeriod' type = 'submit' value = 'Remove last Period' class='btn btn-primary'/> ".
		" <input name='button_AddPeriod' type = 'submit' value = 'Create a Period' class='btn btn-primary'/> ".
		""
		;
		return $result;
		
		
		//convert_html_to_text($temp["article"]);
		//preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags( $temp["article"] ))) );
	}
	
	
	function CreatePage_admin($game_str,$period,$article,$content)
	{	
		$mydatabase = new database(); 
        $game = $mydatabase->getGame($game_str);
	
		if(!isset($game) || count($game) == 0 )
		{
			$game_str = "<b>FAILED</b><br />. Unable to retreive game info.";
		}
		else
			$game_str = "<b>Game Choosen:</b><br />".$game['course']." ".$game['semester']." ".$game['schedule'].
					"<br /><br />".
					"<b>Current Period:</b><br />".$period;
					
		$placeholder = 'Copy and Paste your News article Here. Html will work as Well!';
	
		$results = 	"<div align=right>".
					"<input name='button_ChangeGame' type = 'submit' value = 'Change Game' title='unsaved changes will be lost' class='btn btn-primary'/> ".
					//"<br />".
					" <input name='button_ChangePeriod' type = 'submit' value = 'Change Period' title='unsaved changes will be lost' class='btn btn-primary'/>".
					"</div>".
					$game_str.
					"<h3>News Article</h3>".
					"<textarea rows='20' cols='60' name=textarea_news placeholder='".$placeholder."'>".$article.
					"</textarea>".
					"<br />".
					/*"<input name='upload_button' type='file' placeholder='Choose Text File'> ".
					" <input name='button_upload' type = 'submit' value = 'upload' />".
					"<br />".
					"<br />".
					"<br />".*/
					$content;
					
					
		return $results;
	}
	
	function saveAndPreview($value)
	{
		
		$result = "<div class='' align='center' >".
					"<div class='panel-footer clearfix' style='width: 1080px' >".
						$value.
						//"<iframe width='560' height='315' src='https://www.youtube.com/embed/oavMtUWDBTM?list=FLlpvYpjrPP2VmA_-5xV3a0Q' frameborder='0' allowfullscreen></iframe>".
						"<br /><br />".
	
						"<form action='/views/News.php' method='post'>".
							"<input name='button_returnBack' type = 'submit' value = 'Return back' class='btn btn-primary'/> ".
							" <input name='button_commit' type = 'submit' value = 'Commit to DataBase' class='btn btn-primary'/>".
						"</form>".
						
					"</div>".
				"</div>";
		
		/*header ("content-type: text/plain");
		echo $result;
		exit;*/
		return $result;
	/*"<p style='border:inset black 3px; margin:auto; width:70%; padding:1em;'>".$value."</p>".
				"<br /><br />".
				"<input name='button_commit' type = 'submit' value = 'Commit to DataBase' class='btn btn-primary'/>";*/			
	}
	
	function commitToDB($news_id,$article,$impactType,$hotelTypes,$hotelLocations)
	{
		$mydatabase = new database();
		//$mydatabase->addNews($game,$article);
		$news = $mydatabase->getNews_by_id($news_id);
		
		if(!isset($news) || count($news)==0)
			return "<b>FAILED</b>.<br />News Article was not saved.";
		
		
		for($count = 0;$count < count($impactType);$count++)
			$mydatabase->addNews_parameters($news['id'],$impactType[$count], $hotelTypes[$count],$mydatabase->getLocationByType($hotelLocations[$count])['id']);
		
		$mydatabase->updateNews_article($news['id'],$article);
	
		return "<b>PASSED</b>.<br />News article was succesfully saved.";
	}
	
	function affectsParameters()
	{
		$mydatabase = new database();
		$locationArray = $mydatabase->getAllLocation();
		$locations = "";
		$result= "";
		$impactarray = array('Very Bad', 'Fairly Bad', 'none', 'Fairly Good','Very Good');
		$hotelArray = array('Economic','Midrange', 'Luxury');
		$impactTypes = "";
		$hotelTypes = "";
		
		for($int = 0;$int < 5;$int++)
		{
			$impactTypes .= '<input type="radio" name="impactType" value="'.$impactarray[$int].'"> '.$impactarray[$int].'<br />';
		}
						
		foreach($locationArray as $key => $temp )
		{
			$locations .="<input type='radio' name='hotelLocation' value =".$temp['type']." id=".$temp['id']."> ".$temp['type'].
						"<label class='radio-inline' for ".$temp['id'].">".
						"</label>";
		}
		
		for($int = 0;$int < 3;$int++)
		{
			$hotelTypes .= ' <input type="radio" name="hotelType" value="'.$hotelArray[$int].'"> '.$hotelArray[$int]."  ";//.'<br />'
		}
		
		$result = 
				  '<div align="left">'.
				 // '<h3 align="center"> News Affects Parameters</h3>'.
				  '<h4>Impact on Hotel</h4>'.
				  $impactTypes.
				  '<h3>Location of Affected Hotel</h3>'.
				  $locations.
				  '<br /><h4>Hotel Type</h4>'.
				  $hotelTypes.
				  '<br />'.
				  '<div align=right>'.
				  '<input name="button_saveAndPreview" type = "submit" value = "Save and Preview" class="btn btn-primary"/> '.
				  ' <input name="button_resetParameters" type = "submit" value = "Remove Parameters" class="btn btn-primary"/> '.
				  ' <input name="button_addParameters" type = "submit" value = "Add Addition Parameters" class="btn btn-primary"/>'.
				  '</div>'.

				  '</div>';
		return $result;
	}
	
	
}

?>