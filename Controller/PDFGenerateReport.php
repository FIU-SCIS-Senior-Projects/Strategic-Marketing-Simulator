<?php
require('fpdf.php');

class PDF extends FPDF
{
	//private $myHeader;
	
	/*function __construct($heading)
	{
		$this->myHeader = $heading;
	}*/
	
	
	
	// Load data
	function LoadData($file)
	{
		// Read file lines
		$lines = file($file);
		$data = array();
		foreach($lines as $line)
			$data[] = explode(';',trim($line));
		return $data;
	}

	
	function Header()
	{
		// Logo
		$this->Image('../Images/fiu_logo_edit.png',10,6,30);
		// Arial bold 15
		//$this->SetFont('Arial','B',15);
		// Move to the right
		$this->Ln(20);
		//$this->Cell(60);
		// Title

		//$this->Cell(75,11,"Report for Game: ".'3'." Period: "."3",1,0,'C');
		// Line break
		//$this->Ln(20);
		//print_r("finished header <br />");
	}
	
	
	function title($spacer,$width,$height,$content)
	{
		$this->SetFont('Arial','B',15);
		$this->Ln(10);
		$this->Cell($spacer);
		$this->Cell($width,$height,$content,1,0,'C');

		$this->Ln(20);
	}
	
	
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		//print_r("finished footer <br />");
	}
	
	
	
	// Simple table
	function BasicTable($header, $data)
	{
		// Header
		foreach($header as $col)
			$this->Cell(40,7,$col,1);
		$this->Ln();
		// Data
		foreach($data as $row)
		{
			foreach($row as $col)
				$this->Cell(40,6,$col,1);
			$this->Ln();
		}
	}

	// Better table
	function ImprovedTable($header, $data)
	{
		// Column widths
		$w = array(40, 35, 40, 45);
		// Header
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C');
		$this->Ln();
		// Data
		foreach($data as $row)
		{
			$this->Cell($w[0],6,$row[0],'LR');
			$this->Cell($w[1],6,$row[1],'LR');
			$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
			$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
			$this->Ln();
		}
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
	}

	// Colored table
	function FancyTable($header, $data)
	{
		// Colors, line width and bold font
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		// Header
		$w = array(50, 60);
		$this->Cell(40);
		//for($i=0;$i<count($header);$i++)
			$this->Cell(110,7,$header,1,0,'C',true);
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = false;
		//foreach($data as $row)
		for($int =0; $int < count($data);$int+=2)
		{
			$this->Cell(40);
			$this->Cell($w[0],6,$data[$int],'LR',0,'L',$fill);
			$this->Cell($w[1],6,$data[$int+1],'LR',0,'L',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		
		
		
		// Closing line
		$this->Cell(40);
		$this->Cell(array_sum($w),0,'','T');
	}
}

	session_start();
	require ("/srv/marketsim/www/Model/Javis_database.php");

	if(!isset($_SESSION['gameID'])||!isset($_SESSION['period']))
	{
		print_r("ERROR: Game and or period where not selected!");
		exit;
	}
	
	
	$mydatabase = new database();
	$game = $mydatabase->getGame($_SESSION['gameID']);//$_SESSION['gameID']
	$hotels = $mydatabase->getHotelByGameID($_SESSION['gameID']);
	$news =	$mydatabase->getNews_by_game($_SESSION['gameID'],$_SESSION['period']);
	$news_parameters = $mydatabase->getAllNews_parameters($news['id']);
	 

	
	$int = 0;
	$pdf = new PDF();

	$header = 'Game Table';

	////////////////////////// G A M E /// T A B L E /////////////////////////////
	$data = array('Game ID:',$game['id'],'Semester:', $game['semester'],'Course:',$game['course'],'Section:',$game['section'],
				'Schedule:',$game['schedule'],'Course Number:',$game['courseNumber'],'is Active:',($game['isActive'] > 0)?'yes':'no',
				"","","News:","","   News ID:",$news['id']);
	foreach($news_parameters as $key => $temp )
	{
		array_push($data, "","","  #".++$int,"",
				"   Location:",$mydatabase->getLocation($temp['hotel_location'])['type'],
				"   Hotel Type: ",$temp['hotel_type'],
				"   Effect:",$temp['effect']);
	}
	////////////////////////////////////////////////////////////////
	
	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','',14);
	$pdf->AddPage();
	$pdf->title(55,75,11,"Report for Game: ".'3'." Period: "."1");
	$pdf->FancyTable($header,$data);
	
	//////////////////////////// S T U D E N T   H O T E L ////////////////////////////////////////////////
	$pdf->AddPage();
	$pdf->title(70,40,11,"Hotel Details");
	$int = 0;
	foreach($hotels as $key => $temp )
	{
		/*print_r($mydatabase->getCommentByHotelAndPeriod($temp['id'],
		$_SESSION['period']));
		exit;*/
		
		
		unset($data);
		$marketShare = $mydatabase->getMarketShareByHotelAndPeriod($temp['id'],1);
		
		$data = array ("ID:",$temp['id'],"Location:",
					$mydatabase->getLocation($temp['location'])['type']
					,"Type:",$temp['type']
					,"Balance",$temp['balance'],
						"Revenue:",$temp['revenue'],"RoomsFilled:",$temp['roomsFilled'],"Budget:",$temp['budget'],"Purpose:",
						$temp['purpose'],"Is Active",(($temp['isActive'] > 0)?'yes':'no'),
						"","","Market Share:","",
						"   Rooms Sold:",$marketShare['roomsSold'],
						'   Group Sold:',$marketShare['groupSold']);
						
		$students = $mydatabase->getStudentByHotel($temp['id']);
		
		array_push($data, "","","Students:", "");
		foreach($students as $key => $temp2 )
		{
			array_push($data, "","","  #".++$int,"","   Name:",$temp2['fname']." ".$temp2['lname'],
			"   PID:",$temp2['id'],"   Email:",$temp2['email'],"   Is Active:",(($temp['isActive'] > 0)?'yes':'no'));
		}
		$str = (substr(preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($mydatabase->getCommentByHotelAndPeriod($temp['id'],$_SESSION['period'])['comments']))) ), 0,30));
		$str .= (strlen($str) == 30)?'...':'';
		array_push($data,"","","End of Period:","","   Comment:",(strlen($str) > 3)?$str:"NOT SET");

		
		
		$int =0;
		
		$pdf->FancyTable($temp['name'],$data);
		$pdf->AddPage();
		$pdf->Ln(15);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////

	$pdf->Output();



	/*
	
	$locations = $mydatabase->getAllLocation();
	

	$mydatabase->getCommentByGameAndPeriod($game,$period);
	$mydatabase->getadvertising();
	$mydatabase->getResearch();
	$mydatabase->getOTA();
	$mydatabase->getGame_period($gameID);
	$mydatabase->getRevenue($hotel);
	$mydatabase->getPeriodResearch($game, $period, $hotel);
	$mydatabase->getStudentDecisions2($game, $period, $hotel);
	$mydatabase->getMarketShare($game, $period);
	$mydatabase->getMarketShareforGroup($game, $period, $hotel);
	$mydatabase->getDecisionsImpact($game,$period, $group);
	$mydatabase->getTotalRooms();*/





?>
















