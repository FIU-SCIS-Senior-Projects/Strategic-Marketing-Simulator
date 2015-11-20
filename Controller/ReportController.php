<?php
/*created by Javier Andrial*/
ini_set('display_errors', 1);
error_reporting(~0);

require ("/srv/marketsim/www/Model/Javis_database.php");


class ReportController 
{
	function CreatePage($value)
	{	
		$result =  "<form action='' method='post'>
					<div class='bs-example'>".
						"<div class='panel panel-default'>".
							"<div class='panel-body' align='center'>".

								"<h2>User Accounts Management</h2>".
								
								//"<input name='button_reports' type = 'submit' value = 'Reports' class='btn btn-primary'/>".
								//"<input name='button_commentRepository' type = 'submit' value = 'Comment Repository' class='btn btn-primary'/>".
								"<a href='http://marketsim-dev.cis.fiu.edu/views/reportingPage.php?button_reports=Reports' class='btn btn-primary'>Reports</a>".
								"<a href='http://marketsim-dev.cis.fiu.edu/views/reportingPage.php?button_commentRepository=Comment+Repository' class='btn btn-primary'>Comment Repository</a>".

							"</div>".
							"<div class='' align='center'>".
							"<div class='panel-footer clearfix' style='width: 1075px' >".
							$value.
						   "</div>".
						"</div>".
					"</div>".
					"</div>".
					"</form>";				
		
		return $result;
	}
	
	function getCommentList()
	{
		$mydatabase = new database(); 
		$commentArray = $mydatabase->getAllComments();

		return $commentArray;
	}
	
	function getCommentListFiltered($game,$period)
	{
		$mydatabase = new database();
		/*print_r("Game: ");
		var_dump($game);
		print_r("<br />");*/
		$commentArray = $mydatabase->getCommentByGameAndPeriod($game,$period);

		
		return $commentArray;
	}
	
	function postFeedback($id,$feedback)
	{
		$mydatabase = new database();
		$result = $mydatabase->updateFeedback($id,$feedback);
		
		if($result == "pass")
			return "<b>Sucess:</b> Feedback has been posted";
		else
			return "<b>Failed:</b> Feedback was either the same or record was not found";
	}

	function feedbackPage($id)
	{
		$mydatabase = new database();
		$comment = $mydatabase->getCommentById($id);
		$result = 	"<div align='center'>"
					."<h3>Students Comment</h3>"
					."<p style='border:ridge black 3px; margin:auto; width:42.85%; padding:1em;'>"
					
					
					.$comment['comments']."</p>"
					."<br />"
					."<h3>Feedback</h3>"
					."<textarea rows='10' cols='60' name=textarea_feedback >".$comment['feedback']
					."</textarea>"
					."</div>"
					."<br />"
					."<br />"
					."<input name='button_feedbackPost' type = 'submit' value = 'post feedback' class='btn btn-primary'/>";
		
		return $result;
	}
	
	
	function generateCommentTable($commentArray,$gamesChecked,$periodsChecked)
	{

		
		$myTable = "<table>"
					."<thead>"
						."<tr>"
							."<th>".$this->filterMenu($gamesChecked,$periodsChecked)."</th>"
							//."<th>  </th>"
							."<th>".$this->commentList($commentArray)."</th>"
						."</tr>"
					."</thead>";
		
		return $myTable;
	}

	function filterMenu($gamesChecked,$periodsChecked)
	{
		$mydatabase = new database(); 
        $gameArray = $mydatabase->getGameAllGames();
		$result = "<div style='padding: 0px 45px 0px 0px'> <h3>Filter</h3> <h5>Games</h5>";
		$periodHigh = 1;
		$gameBool = false;
		$periodBool = false;
		
		if($gamesChecked == null)
		{
			$gameBool = true;
			$gamesChecked = array();
		}
		if($periodsChecked == null)
		{
			$periodBool = true;
			$periodsChecked = array();
		}
		
		foreach($gameArray as $key => $temp )
		{
			$str = "unchecked";
			if(in_array(strval($temp['id']), $gamesChecked) || $gameBool )
			{
				$str = "checked";
			}
			
			$result .= "<input type='checkbox' name ='gameCheckbox[]' ".$str." value='".$temp['id']."'>".$temp['course']." <br />";
			if($temp['periodNum'] > $periodHigh)
				$periodHigh = $temp['periodNum'];
		}		//(in_array(strval($temp['id']), $gamesChecked) || $gameBool? "'checked'" : "'unchecked'")
		
		
		$result .= "<br /><h5>Periods</h5>";
		for($int = 1; $int <= $periodHigh;$int++)
		{
			$str = "unchecked";
			if(in_array(strval($int), $periodsChecked) || $periodBool )
			{
				$str = "checked";
			}
			
			$result .= "<input type='checkbox' name ='periodCheckbox[]' ".$str." value='".$int."'> $int <br />";		
		}//(in_array(strval($int), $periodsChecked) || $periodBool ? "'checked'" : "'unchecked'")//checked= ".$str."
		
		return $result."<br /><input name='button_applyFilter' type = 'submit' value = 'Apply Filter'  class='btn btn-primary'/>"."</div>";	
	}
	

	function commentList($commentArray)
	{
		$mydatabase = new database();
		$hotelArray = $mydatabase->getAllHotel();
		$locationArray = $mydatabase->getAllLocation();
		$currentHotel;
		
		
		$result = ' <div class="table-responsive">'
					.'<table class="table table-bordered">'
						.'<thead>'
							.'<tr>'
								.'<th> Game</th>'
								.'<th>Period</th>'
								.'<th>Hotel</th>'
								.'<th>Type</th>'
								.'<th>Location</th>'
								.'<th>Comment</th>'
								.'<th>Feedback</th>'
								.'<th></th>'
							.'</tr>'
					.'</thead>';
		$int = 1;			
		foreach($commentArray as $key => $temp )
		{
			foreach($hotelArray as $key => $hotel)
			{
				if($hotel['id'] == $temp['hotel'] )
				{
					$temp['hotel'] = $hotel['name'];
					$temp['type'] = $hotel['type'];
					$currentHotel = $hotel;
					break;
				}
			}

			foreach($locationArray as $key => $loc)
			{
				if($loc['id'] == $currentHotel['location'] )
				{
					$temp['location'] = $loc['type'];
					break;
				}
			}
			
			if(strlen($temp['comments'])>25)
				$temp['comments'] = substr(preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags( $temp["comments"] ))) ), 0,22)."...";
			if(strlen($temp['feedback'])>25)
				$temp['feedback'] = substr(preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags( $temp["feedback"] ))) ), 0,22)."...";
			
			
			
			
			$result .=
			"<tbody>"
			."<tr>"
			//."<td>".$int++."</td>"
			."<td>".$mydatabase->getGame($temp['game'])['course']."</td>"
			."<td>".$temp["period"]."</td>"
			."<td>".$temp["hotel"]."</td>"
			."<td>".$temp["type"]."</td>"
			."<td>".$temp['location']."</td>"
			."<td>".$temp["comments"]."</td>"
			."<td>".$temp["feedback"]."</td>"
			."<td>"."<a href='http://marketsim-dev.cis.fiu.edu/views/reportingPage.php?button_feedback=Give+Feedback&commentId=".$temp['id']."' class='btn btn-primary'>Give Feedback</a>"."</td>"
			."</tr>"
			."</tbody>";
		}
		
        $result .= "</table></div>";
		return $result;	
	}
	
	
	
	function chooseGame()
	{	
		$mydatabase = new database();
		$gamesArray = $mydatabase->getGameAllGames();
		
		
		$result = '<div class="table-responsive">
			<h3>Select a Game to view its details</h3><br />
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

	function choosePeriod($game)
	{
		$mydatabase = new database(); 
        //$game = $mydatabase->getGame($game);
		$news = $mydatabase->getAllNews_by_game($game);
		
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
		""
		;
		return $result;
	}
	function selectPeriod($gameID)
	{
		$mydatabase = new database(); 
        $game = $mydatabase->getGame($gameID);
		
		
		$result = '<h3>Select a Period</h3><br />
					<div style="width: 10%">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th></th>
									<th>Period</th>
								</tr>
						</thead>';
		
		for($int = 1; $int <= $game['periodNum'];$int++ )
		{
			$result .="<tbody>"
					."<tr>"
					."<td>"."<input type='radio' name='periodRadio' value='".$int."'></td>"
					."<td>".$int."</td>"
					."</tr>"
					."</tbody>";
		}
		$result .= "</table>".
		"<br />".
		"<input name='button_choosePeriod' type = 'submit' value = 'Choose a Period'  class='btn btn-primary'/> ".
		""
		;
		return $result;
	}
	
	function generatePDF($gameID,$period)
	{
		$_SESSION['gameID'] = $gameID;
		$_SESSION['period'] = $period;
		header('Location: /Controller/PDFGenerateReport.php');
		exit;	
	}
	
}//end of class
?>



















