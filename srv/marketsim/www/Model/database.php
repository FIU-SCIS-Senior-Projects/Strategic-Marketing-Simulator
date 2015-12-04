<?php



//require ("/srv/marketsim/www/Entities/StudentEntity.php");


ini_set('memory_limit', '-1');
class database
{
  // it should work like this
 
 private $conn;
 // ---------------We need to fix the constuctor to make the connection instead of doing it in each function
 //like in SearchForStudents below
  function __construct() // correct - when you create a database the constructor here is called
  {
	require 'dbInfo.php';
    $this->conn = new mysqli($host, $user, $password, $database);

    if ($this->conn->connect_error !== null) {
      print_r($this->conn->connect_error); 
    } 
  }

  public function searchForStudents($v) 
  {
        require 'dbInfo.php';
        // for now I am putting the connection in every time
        $this->conn = new mysqli($host, $user, $password, $database); // -- uncomment this and comment constuctor
        $v = $this->conn->real_escape_string($v);
		
        $r = $this->conn->query($s = sprintf("select * from student where email like '%%%s%%' or fname like '%%%s%%' or lname like '%%%s%%' or id like '%%%s%%';",$v,$v,$v,$v));
        //mysql_close($this->conn);
		
        return $r->fetch_assoc(); // uncomment to return array
        //$res = $r->fetch_assoc();
        //$str = implode(" ", $res); // this is just to see a string

        //return $str; // returning string to createAccount
    }

    public function getStudent2($value) 
    {
        $v = $this->conn->real_escape_string($value);
        
        return $this->conn->query(sprintf("select * from student where id = %s or email = %s;", $v, $v));
    }
    
    public function getStudent($value) 
    {        
        $v = $this->conn->real_escape_string($value);
        $r = $this->conn->query(sprintf("select * from student where email = '%s' or id = '%s';",$value,$value));
  
        return $r->fetch_assoc();
    }
	
	public function getAllAdmin() 
    {        
		$r = $this->conn->query(sprintf("select * from admin;"));
		$resArr = array();

		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
        return $resArr;
    }
	
	public function getAllStudent() 
    {        
		$r = $this->conn->query(sprintf("select * from student;"));
		$resArr = array();
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
		
        return $resArr;
    }
	
	public function getAllHotel() 
    {        
		$r = $this->conn->query(sprintf("select * from hotel;"));
		$resArr = array();
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
		
        return $resArr;
    }
	public function getAllLocation() 
    {        
		$r = $this->conn->query(sprintf("select * from location;"));
		$resArr = array();

		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
        return $resArr;
    }
	
	public function getAllStudentinGame($game) 
    {     
		$q = sprintf("select * from student where hotel in(select id from hotel where game='%s');",$this->conn->real_escape_string($game));
		$r = $this->conn->query($q);
		
		$resArr = array();
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}

        return $resArr; 	
    }
	
	
	
	public function getAdmin($value) 
    {        
        $r = $this->conn->query(sprintf("select * from admin where email = '%s';",$this->conn->real_escape_string($value)));
  
        return $r->fetch_assoc();
    }


	
	public function addAdmin( $fname, $lname, $email, $pwd, $secQuestion, $secAnswer, $isActive)
	{        
		$pwd= $this->genPass($pwd, $email);
		$secAnswer = strtoupper($secAnswer);
		$secAnswer = $this->genPass($secAnswer, $email);
	
		$stmt = $this->conn->prepare("insert into admin (fname, lname,email, password, secQuestion, secAnswer, isActive) values ( ?, ?, ?, ?,?,?,?);");
		$stmt->bind_param("ssssssi", $fname, $lname, $email, $pwd, $secQuestion, $secAnswer, $isActive);
		$stmt->execute();
	}
	
    public function addStudent($id, $fname, $lname, $email, $bot, $pwd, $secQuestion, $secAnswer, $isActive)
    {
      $stmt = $this->conn->prepare("insert into student (id,fname, lname, email, bot, password, secQuestion, secAnswer, isActive) values (?, ?, ?, ?, ?,?,?,?,?);");
      $stmt->bind_param("isssisssi", $id, $fname, $lname, $email, $bot, $pwd, $secQuestion, $secAnswer, $isActive);
      $stmt->execute();
	  if($this->conn->affected_rows==0){
			return "fail";
		}
		else 
			return "pass";
    }

	public function addBotStudent($id, $fname, $lname, $email, $bot, $hotel,$pwd, $secQuestion, $secAnswer, $isActive)
    {
		$pwd = $this->genPass($pwd, $email);
		$secAnswer = $this->genPass($secAnswer, $email);
				
		$stmt = $this->conn->prepare("insert into student (id,fname, lname, email, bot, hotel, password, secQuestion, secAnswer, isActive) values (?, ?, ?, ?,?,?,?,?,?,?);");
		$stmt->bind_param("ssssiisssi", $id, $fname, $lname, $email, $bot, $hotel, $pwd, $secQuestion, $secAnswer, $isActive);
		$stmt->execute();
	  
		if($this->conn->affected_rows==0)
			return "fail";
		else 
			return "pass";
    }
	
	
  	public function addGame($semester,$courseID,$section,$schedule,$isActive,$courseNumber)
	{        
		$section = strtoupper($section);
		
		//if($semester == NULL or $courseID == NULL or $section== NULL or $schedule== NULL or $isActive== NULL or $courseNumber == NULL)
		//{return "fail"; exit;}
	
		$stmt = $this->conn->prepare("insert into game (semester, course, section, schedule, isActive,courseNumber) values ( ?, ?, ?, ?,?,?);");
		$stmt->bind_param("ssssis",$semester,$courseID,$section,$schedule,$isActive,$courseNumber);
		$stmt->execute();
		if($this->conn->affected_rows==0){
			return "fail";
		}
		else 
			return "pass";
	}
	
    public function genPass($pass, $email) 
    {
		return hash('sha256', $email . $pass);
    }

    public function updateStudentPassword($email,$password)
    {
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }

		$password = $this->conn->real_escape_string($password);
		$email = $this->conn->real_escape_string($email);
			
		$v = $this->genPass($password,$email);
        $sql = sprintf("UPDATE student SET password='%s' WHERE email='%s'",$v,$email);


		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }
	
	public function updateAdminPassword($email,$password)
    {
		$result = "";
		if($password == NULL)
			return "fail";
		////change exit;}
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }

		$password = $this->conn->real_escape_string($password);
		$email = $this->conn->real_escape_string($email);
			
		$v = $this->genPass($password,$email);
        $sql = sprintf("UPDATE admin SET password='%s' WHERE email='%s'",$v,$email);


		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }	
	
	public function setStudentActive($email,$isActive)
	{
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }
		
        $sql = sprintf("UPDATE student SET isActive='%d' WHERE email='%s'",$isActive,$email);


		$r = $this->conn->query($sql);
			
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }
	
	public function setAdminActive($email,$isActive)
	{
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }

        $sql = sprintf("UPDATE admin SET isActive='%d' WHERE email='%s'",$isActive,$email);
		
		$this->conn->query($sql);

		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }
	
	
	public function updateStudentHotel($student,$hotel)
    {
		//if($student == NULL or $hotel == NULL){return false; exit;}
		
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }

		$sql = sprintf("UPDATE student SET hotel='%s' WHERE email='%s'",$hotel,$student);

        if (mysqli_query($this->conn, $sql)) 
        {
			$result = true;
        } 
        else 
        {
			$result = false;
        }

		return $result;
    }
	
	function getGroup($value)
	{
		 $v = $this->conn->real_escape_string($value);
         $r = $this->conn->query(sprintf("select * from hotel where id = '%s';",$value));
  
        return $r->fetch_assoc();
		
	}
	
	function getGame($value)
	{
		 $v = $this->conn->real_escape_string($value);
         $r = $this->conn->query(sprintf("select * from game where id = '%s';",$v));
  
        return $r->fetch_assoc();
	}
	
	function getGameByCourseNumber($value)
	{
		 $v = $this->conn->real_escape_string($value);
         $r = $this->conn->query(sprintf("select * from game where courseNumber = '%s';",$v));
  
        return $r->fetch_assoc();
		
	}

	function getLocation($value)
	{
		 $v = $this->conn->real_escape_string($value);
         $r = $this->conn->query(sprintf("select * from location where id = '%s';",$v));
  
        return $r->fetch_assoc();
	}
	function getAllBotStudents()
	{
		$r = $this->conn->query(sprintf("select * from student where bot > 0;"));
		$resArr = array();
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
		
        return $resArr;
	}
	
	function getGameAllGames()
	{
		$r = $this->conn->query(sprintf("select * from game;"));
		$resArr = array();
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
		
        return $resArr;
	}
	
	
	function getadvertising()
	{
		$r = $this->conn->query(sprintf("select * from advertising;"));
		$resArr = array();
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
			
		}
		
        return $resArr;
	}
	
	function newHotel($name, $location, $type, $game, $balance, $revenue, $rooms, $isActive)
	{	
		$budget = 50000.00;
		$stmt = $this->conn->prepare("insert into hotel (name, location, type, game, balance, revenue, roomsFilled, isActive, budget) values (?, ?, ?, ?, ?,?,?, ?,?);");
		$stmt->bind_param("sisidddid", $name, $location, $type, $game, $balance, $revenue, $rooms, $isActive, $budget);
		$stmt->execute();
	  
		$sql = "select max(id) from hotel;";
		$query = mysqli_query($this->conn, $sql);
		

		$rs = mysqli_fetch_array($query, MYSQLI_ASSOC );

		return $rs;
	}

	
	 public function searchHotel($v) 
	{
        require 'dbInfo.php';
        
        $this->conn = new mysqli($host, $user, $password, $database); // -- uncomment this and comment constuctor
        $v = $this->conn->real_escape_string($v);
		
        $r = $this->conn->query(sprintf("select * from hotel where name like '%%%s%%';",$v));
        
		
        return $r->fetch_assoc(); 
    }
	
	
	function getGroupsforGame($id)
	{
		
		$r = $this->conn->query(sprintf("select distinct name,h.location, h.type as hotel_type,  h.id, l.type from game g, location l, hotel h where '%s' = h.game and h.location = l.id;", $id));
		$resArr = array();				//select distinct h.id as id, h.name, l.type as type1, h.type as type2 from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
			
		}
		
        return $resArr;
		
	}
	
	/////////sprint 4 //////
	
	function getadvertisingNameAndPrice($id)
	{
		$qry = "select type, cost from advertising where id = " . $id;
		//return $qry;
		$r = $this->conn->query($qry);
		
		///////////this was added for a test/////////////
		if(!$r)
		{
			return 'error';
		}
		
		/////////////////////////////////
		
		$resArr = array();
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
			
		}
		
        return $resArr;
	}
	
	function getPersonnel()
	{
		$r = $this->conn->query(sprintf("select * from personnel;"));
		$resArr = array();
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
			
		}
		
        return $resArr;
	}
	
	function getResearch()
	{
		$r = $this->conn->query(sprintf("select * from research;"));
		$resArr = array();
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
			
		}
		
        return $resArr;
	}
	
	
	
	function getCurrentPeriod($id) //good!
	{
		$r = $this->conn->query(sprintf("select periodNum from game where '%s' = id;", $id));
		$resArr = array();

		
        while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
			
		}
		
        return $resArr;
		
		
	}
	
	function getOTA()
	{
		$r = $this->conn->query(sprintf("select * from ota;"));
		$resArr = array();
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
			
		}
		
        return $resArr;
		
	}
	
	function updateOTA($discount)
	{
		$qry = "UPDATE ota SET discount=" . $discount . ";";
		return $this->conn->query($qry);
		
		
	}
	
	

	function updateAdvPerOrResearch($table, $id, $cost, $impact)
	{
		$result = "";
		$qry = ""; 
		//			$obj2->updateAdvPerOrResearch('advertising', $ct, 5000.00, $d);
		
		if($impact == 'NULL') // update research table
		{
			$qry = "UPDATE ". $table. " SET cost = " . $cost . " where id=" . $id . ";"; 
		
			
		}
		else if($cost=='NULL') // update personnel or advertising
		{
			
			$qry = "UPDATE ". $table. " SET impact=" .$impact . " where id=" . $id . ";"; 
		
		}
		else{
			
			$qry = "UPDATE ". $table. " SET cost = " . $cost . ", impact=" .$impact . " where id=" . $id . ";"; 
		
		}
		
		//return $qry;
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "connection failed";
        }


		$this->conn->query($qry);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
		
	}
	
	function isDecisionTable($name) //good!
	{
		$r = $this->conn->query(sprintf("SHOW TABLES LIKE '%%%s%%';", $name));
		$resArr = array();			
        while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
			
		}
		return (count($resArr));		
     /*   return $resArr;
		$qry = "SHOW TABLES LIKE '" . $name."';";
	
        //$r = $this->conn->query($qry);
	//	$s = mysqli_query($this->conn, $qry);
		//return $s;
        //mysql_close($this->conn);
		if(mysql_num_rows(mysqli_query($this->conn, $qry))==1) 
		{return 1;}
	else{return 0;}
		
		
		if($s!== FALSE)
		{
			return 0;
			
		}
		else
		{
			return 1;
		}
	
		
       // return intval(count($r->fetch_assoc()));
		*/
	}
	
	function getDecisionsTableColumns($tableName)
	{
		$sql="SELECT * from " . $tableName . ";";
		$finResult = array();
		if ($result=mysqli_query($this->conn,$sql))
		{
			// Get field information for all fields
			while ($fieldinfo=mysqli_fetch_field($result))
			{
				
				array_push($finResult,$fieldinfo->name );
			}
			// Free result set
			mysqli_free_result($result);
		}
		
		return $finResult;	
	}
	

	
	
	function getStudentDecisions($game,$period, $hotel)
	{
	
		$qry = "Select * from strat_decions where  where hotel=". $hotel . "and gameID=" . $game . " and periodNum=" .$period. ";"; 
        
        $r = $this->conn->query($qry);
		if($r)
		{
			
			return $r->fetch_assoc(); 
		}
		else
		{
		return false;
		}
		
	}
	
	function addDecisionsexistingTable($tableName, $gameid, $hotel, $periodNum, $advertising, $personnel, $OTA,$roomRate, $research, $adCount, $researchCount)
	{
	
	//this functions checks if a groups has already made decisions.  If not, new decisions are added to the table.
	//If they have made decisions, new decisions update the old ones.
	//return $tableName;
		$s = "select * from " . $tableName . " where hotel = ". $hotel .";";
	//return $s;
		 $r = $this->conn->query($s);// = sprintf("select * from '%s' where hotel='%s';",$tableName,$hotel));
		//return $r;
		$ARRAY = array();
		while ($result = $r->fetch_assoc())
		{
			array_push($ARRAY, $result);
			
		}
	//RETURN COUNT($ARRAY);
	//	return "this is !r : " . !$r;		
		if(count($ARRAY)== 0)//WORKING
		{
		
			//return "not r";
			$query = "insert into ". $tableName . " (gameID, periodNum, aveRate, hotel, ";
			
			for($k = 0; $k <$adCount; $k++ )
			{
				$query.= "adv" . ($k+1). ", " ;
			}
		
			$query.= " P1, P2, P3, OTA, ";
			
			for($x = 0; $x < $researchCount; $x ++)
			{
					if(($x +1) < $researchCount)
					{
						$query.= "research". ($x+1). ", ";
					}
					else
					{
						$query.= "research". ($x+1). ") VALUES (";
						
					}
			}
			
			$query.= $gameid . ", " .$periodNum. ", " .$roomRate. ", ".$hotel . ", "; 
			
			for ($q = 0; $q < count($advertising); $q++ )
			{
				$query.= $advertising[$q] . ", ";
			}
			
			for($rr = $q; $rr < $adCount; $rr++ )
			{
				$query.= "NULL, ";
			}	
			
			for($t = 0; $t < count($personnel); $t++)
			{
				$query.= $personnel[$t] . ", ";
			}
			
			$query.= $OTA . ", ";
				
			
			for($p = 0; $p < count($research); $p++)
			{
				$query.= "'".$research[$p] . "', ";
			}
			//return "Size of p is " . $p . " Research count is " .$researchCount ;
			for(; $p < $researchCount; $p++ )
			{
				if(($p+1) < $researchCount)
				{
					$query.= "NULL, ";
					
				}
				else
				{
					$query.= "NULL);";  //Fatal error: Allowed memory size of 134217728 bytes exhausted 
				}
				
			}
			//return $query;
			
			if (mysqli_query($this->conn, $query)) 
			{
			return "Decisions accepted";
			} 
			else
			{
			return "Something went wrong";
			}
			
			return $query;
		
		}
		else
		{
			//print_r("entry already exists.  time to update");
			//(gameID, periodNum, aveRate, hotel,
			
			$qry  = "UPDATE ". $tableName .	" SET aveRate =" .$roomRate. ", "
											."hotel=" .$hotel. ", ";	
											
										//return $qry;
			$k=1;
			foreach($advertising as $ADVERT)
			{
			
				$qry.= "adv" . ($k). "=".$ADVERT.", " ;
				$k = $k+1;
			}
			
			for(;$k<$adCount+1;$k++)
			{
				$qry.="adv".$k. "='NULL', ";
			}
			$p=1;
			foreach($personnel as $person)
			{
				$qry.= "P".$p. "=" .$person . ", ";
			}
			
			$kk = 1;
			$rr = count($research);
			foreach($research as $res)
			{
				
				
				
				$res = str_replace(str_split('\\/:*?"<>|'), '', $res) ;
				$res =  str_replace(' ', '', $res);
				$res = str_replace("'", '', $res);
				//return $rr;
				if($kk+1 == $researchCount)
				{
					
					$qry.= "research" . $kk . "='". $res. "' ";
				}
				else
				{
					
					$qry.= "research" . $kk . "='". $res. "', ";
				}
				
				$kk++;
				//return $res;
			}
			
			$check = 1;
			for(; $kk< $researchCount+1;$kk++)
			{
				$check = 0;
				if($kk +1<($researchCount +1 ))
				{
					
					
					$qry.= "research" . $kk . "='NULL', " ;
				}
				else
				{
					$qry.= "research" . $kk . "='NULL'  " ;
					
				}
				
			}
			//return $qry;
			
			/*
			
			
			I need to change balance in database for hotel anbd I need to check rate on page on click commit
			
			*/
			if($check ==1)
			{
				rtrim($qry, ",");
				//substr($qry,0,-2);
			}
			$qry.= "where hotel =" . $hotel. ";";
			
			//return $qry;
			//exit;
			
			if (mysqli_query($this->conn, $qry)) 
			{
				return "pass";
			} 
		else
		{
			return "fail";
			
		}
			return $qry;
			
			//where hotel = hotel
		}
	}
	
	//update segment the first time per game that a user selects it during a game
	function updateMarketSegment($segment,$hotel)
	{
    
		//if($student == NULL or $hotel == NULL){return false; exit;}
		
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }

		$sql = sprintf("UPDATE hotel SET type='%s' WHERE id='%s'",$segment,$hotel);

		//return $sql;
		//exit;
        if (mysqli_query($this->conn, $sql)) 
        {
			$result = true;
        } 
        else 
        {
			$result = false;
        }

		return $result;
    
	}
	
	function addNewPeriodDecisions($tableName, $gameid, $periodNum, $advertising, $personnel, $OTA, $research)
	{
		
		$query = "CREATE TABLE ". $tableName . " (id INT(6) AUTO_INCREMENT PRIMARY KEY, gameID INT(6), periodNum INT (3), aveRate double(12,2), hotel int(6), ";
		$fKey = " FOREIGN KEY (hotel) REFERENCES hotel(id), FOREIGN KEY (gameID) REFERENCES game(id));";
		$advNum = 1;
		$addAdvert = "";
		$cnt = count($advertising);
		$cnt2 = count($research);
		
		
		for($i = 0; $i<$cnt; $i++ ) // advertising is working
		{
			$addAdvert.= "adv" . $advNum . " int(2), ";
			$advNum = $advNum + 1;
			
		}
		
		$query.= $addAdvert . "P1 INT(3), P2 INT(3), P3 INT(3), OTA INT(3),";
		
		for($i = 0; $i<$cnt2; $i++ ) 
		{
		
			$query.= "research". ($i+1). " TINYTEXT, ";
			
		}
		// advertising is working
		
		$query.= $fKey;
			
		if (mysqli_query($this->conn, $query)) 
        {
			return "table created!!";
        } 
		else
		{
			return "the table already exists";
			
		}
		
		return $query;
				
	}

	
	////////////////////sprint 5 functions///////
	
	function getMarketShareTable($gamePeriod)
	{
		$query = "SELECT * from " . $gamePeriod . "_MarketShare;";
		$r = $this->conn->query($query);
		if($r)
		{
			return $r->fetch_assoc();
		}
		else 
		{
			return false;
		}		
	}
	function updateMarketShare($gamePeriod, $groupcount, $rooms, $roomsSold, $byGroup, $groups, $period)
	{
	
		$query = "insert into " . $gamePeriod . "_MarketShare" . " (period, rooms, roomsSold, ";
		for($i = 0; $i < $groupcount ; $i++ )
	{
		$temp = "group" . $groups[$i]['id'];
		if($i + 1 < $groupcount)
		{	
			
			$query.= $temp . ", ";
		}
		else
		{
			$query.= $temp . ") values (" . $period . ", " . $rooms . ", " . $roomsSold . ", ";
		}
		
		
	}
		for($i=0; $i< count($byGroup); $i++)
			{
		
				if($i+1 < count($byGroup))
				{
					$query .= $byGroup[$i] . ", ";
				}
				else
				{
					$query .= $byGroup[$i] . "); ";
				}
			}	
		//return $query;	
		$r = $this->conn->query($query);
		if($r)
		{
			return "Table updated";
        } 
		else
		{
			return "Table could not be updated";
			
		}
	}
	
	function createMarketShare($gamePeriod,$groupcount, $groups, $period)
	{
	$query = "CREATE TABLE " . $gamePeriod . "_MarketShare" . " (period  varchar(256), rooms int(11), roomsSold int(11), ";
	
	for($i = 0; $i < $groupcount ; $i++ )
	{
	
		$temp = "group" . $groups[$i]['id'];
		if($i + 1 < $groupcount)
		{	
			
			$query.= $temp . " int (11), ";
		}
		else
		{
			$query.= $temp . " int (11));";
		}
		
			
		
	}
	//return $query;
		$r = $this->conn->query($query);
		if($r)
		{
			return "Table created";
        } 
		else
		{
			return "the table already exists";
			
		}

	
	}
	
	function getGameGroupCount($game)
	{
		
		$qry  = "select count(*) from hotel where game = " . $game;
		$r = $this->conn->query($qry);
		if($r)
		{
		return $r->fetch_assoc();
		}
		else{
			
			return false;
		}
	}
	
	
	function getGameGroupsId($game)
	{
		$query = "SELECT * from hotel where game = " . $game;
		$r = $this->conn->query($query);
		$arr = array();
		while($result = $r->fetch_assoc())
		{
			$arr[] = $result; 
		}
		return $arr;
	}
	
	function isMarketShare($marketshare) // return 0 if table doesn't already exist and array if it does.
	{
	
		$r = $this->conn->query(sprintf("SHOW TABLES LIKE '%%%s%%';", $marketshare));
		$resArr = array();			
        while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
			
		}
		return (count($resArr));		
		
		
	}
	
	function getRevenue($hotel)
	{
		$qry = "select revenue from hotel where id =" . $hotel;
		$r = $this->conn->query($qry);
		$arr = array();
		while($result = $r->fetch_assoc())
		{
			$arr[] = $result; 
		}
		return $arr;
	}
	
	function getLeaderboardTable($game)
	{
		$qry = "Select distinct h.name, h.type, l.type as ltype, h.revenue, h.purpose from hotel h, location l, game g where h.game= " . $game . " and l.id=h.location order by h.revenue";
		$r = $this->conn->query($qry);
		$arr = array();
		while($result = $r->fetch_assoc())
		{
			$arr[] = $result; 
		}
		return $arr;

	}
	
	function updatePurpose($purpose,$hotel){
    
		//if($student == NULL or $hotel == NULL){return false; exit;}
		
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }

		$sql = sprintf("UPDATE hotel SET purpose='%s' WHERE id='%s'",$purpose,$hotel);

		//return $sql;
		//exit;
        if (mysqli_query($this->conn, $sql))
        {
			$result = true;
        } 
        else 
        {
			$result = false;
        }

		return $result;
    
	}
	
	function getPeriodResearch($game, $period, $hotel)
	{
		$qry = "Select research1,  research2,  research2, research4 from strat_decisions where gameID=  " . $game . " and periodNum=" . $period. " and hotel=".$hotel.";" ;
		//return $qry;
		$r = $this->conn->query($qry);
		$arr = array();
		if($r)
		{
		while($result = $r->fetch_assoc())
		{
			$arr[] = $result; 
		}
		
		return $arr;
		}
		else
		{
			return false;
		}
	}
	
	function gethotelIdbyName($name)
	{
		$qry = "Select id from hotel where name = '". $name . "';" ;
		$r = $this->conn->query($qry);
		$arr = array();
		while($result = $r->fetch_assoc())
		{
			$arr[] = $result; 
		}
		return $arr;
	}
	
	function incrementGamePeriodNum($game, $period)
	
	{
		$result = "";
		$sql = sprintf("UPDATE game SET periodNum='%s' WHERE id='%s'",$period+1,$game);
		//return $sql;
		//return $sql;
		//exit;
        if (mysqli_query($this->conn, $sql))
        {
			$result = true;
        } 
        else 
        {
			$result = false;
        }

		return $result;
	}
	
	function  isMarketShareForPeriod($marketshare, $periodNum)
	{
		$qry = "Select * from " . $marketshare . " where period= '". $periodNum . "';" ;
		$r = $this->conn->query($qry);
		
		if($r)
		{
			return 1;
		}
		else
		{
			return -1;
		}
		
	}
	function addComments($game, $period, $group, $comments)
	{
		
		$result = "";
		$sql = "insert into student_comments (game, period, hotel, comments) values (". $game . ", ". $period. ", " . $group. ", '". $comments .  "');";

		
        if (mysqli_query($this->conn, $sql))
        {
			$result = true;
        } 
        else 
        {
			$result = false;
        }

		return $result;
    
	
	}
	
	public function updateStudentQuestion($email,$secretQuestion,$id)
    {
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }

		$secretQuestion = $this->conn->real_escape_string($secretQuestion);
		$email = $this->conn->real_escape_string($email);
		$id = $this->conn->real_escape_string($id);
			

        $sql = sprintf("UPDATE student SET secQuestion='%s' WHERE id='%s'",$secretQuestion,$id);

		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }
	
	public function updateAdminQuestion($email,$secretQuestion,$id)
    {
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }

		$secretQuestion = $this->conn->real_escape_string($secretQuestion);
		$email = $this->conn->real_escape_string($email);
		$id = $this->conn->real_escape_string($id);
			
		//$v = $this->genPass($secretQuestion,$email);
        $sql = sprintf("UPDATE admin SET secQuestion='%s' WHERE id='%s'",$secretQuestion,$id);


		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }
	public function updateStudentAnswer($email,$secretAns,$id)
    {
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }

		$secretAns = strtoupper($this->conn->real_escape_string($secretAns));
		$email = $this->conn->real_escape_string($email);
		$id = $this->conn->real_escape_string($id);
		
		$v = $this->genPass($secretAns,$email);
        $sql = sprintf("UPDATE student SET secAnswer='%s' WHERE id='%s'",$v,$id);


		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }
	
	public function updateAdminAnswer($email,$secretAns,$id)
    {
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }
		
		$secretAns = strtoupper($this->conn->real_escape_string($secretAns));
		$email = $this->conn->real_escape_string($email);
		$id = $this->conn->real_escape_string($id);
		
		$v = $this->genPass($secretAns,$email);
        $sql = sprintf("UPDATE admin SET secAnswer='%s' WHERE id='%s'",$v,$id);


		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }
	
	
	public function updateStudentPassword_by_id($email,$password,$id)
    {
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }

		$password = $this->conn->real_escape_string($password);
		$email = $this->conn->real_escape_string($email);
		$id = $this->conn->real_escape_string($id);
				
		$v = $this->genPass($password,$email);
        $sql = sprintf("UPDATE student SET password='%s' WHERE id='%s'",$v,$id);


		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }
	
	public function updateAdminPassword_by_id($email,$password,$id)
    {
		$result = "";
		if($password == NULL)
			return "fail";
		////change exit;}
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }

		$password = $this->conn->real_escape_string($password);
		$email = $this->conn->real_escape_string($email);
		$id = $this->conn->real_escape_string($id);
			
		$v = $this->genPass($password,$email);
        $sql = sprintf("UPDATE admin SET password='%s' WHERE id='%s'",$v,$id);


		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }	
	/*//////////////////////////////////////////////////////////////////////////////////////////////////////////*/
	///////////////////////////////////////////////////sprint 6///////////////////////////////////////////////////
	/*///////////////////////////////////////////////////////////////////////////////////////////////////////////*/
	
	function insertdecisions($gameNum ,$periodNum, $roomRate, $hotel,  $arrDecisions, $personArr, $OTA,  $research)
	{
		$qry = "select * From strat_decisions where gameID= " .$gameNum." and periodNum=".$periodNum." and hotel=" . $hotel.";";
	
		$r = $this->conn->query($qry);
		$resArr = array();

		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
     
		if (count($resArr)!=0) 
			{		
			$query = "REPLACE ";
			}
			else
			{
			$query = "INSERT ";
			}
			
	
		$query .= "into strat_decisions (gameID, periodNum, aveRate, hotel, adv1, adv2, adv3, adv4, adv5, adv6, adv7, adv8, adv9, adv10, adv11, ";
		$query.= "P1, P2, P3, OTA, research1, research2, research3, research4) VALUES ("	;
			
			
			
			$query.= $gameNum . ", " .$periodNum. ", " .$roomRate. ", ".$hotel . ", "; 
			
			for ($q = 0; $q < count($arrDecisions); $q++ )
			{
				$query.= $arrDecisions[$q] . ", ";
			}
			for(;$q < 11; $q++)
			{
				$query.= "0, ";
			}
									
			for($t = 0; $t < count($personArr); $t++)
			{
				$query.= $personArr[$t] . ", ";
			}
			for(;$t < 2; $t++)
			{
				$query.= "0, ";
			}
			
			$query.= $OTA . ", ";
				
			
			for($p = 0; $p < count($research); $p++)
			{
				$query.= "'".$research[$p] . "', ";
			}
			
			for( ;$p < 4; $p++ )
			{
				if(($p+1) < 4)
				{
					$query.= "NULL, ";
					
				}
				else
				{
					$query.= "NULL); ";  //Fatal error: Allowed memory size of 134217728 bytes exhausted 
				}
				
			}
			
			
			
			/*INSERT INTO table (id, name, age) VALUES(1, "A", 19) ON DUPLICATE KEY UPDATE    
	name=VALUES(name), age=VALUES(age)*/
			//return $query;
			
			if (mysqli_query($this->conn, $query)) 
			{
				return "Decisions accepted";
			} 
			else
			{
				return "Something went wrong";
			}
			
			return $query;
	}
	
	function getStudentDecisions2($game, $period, $hotel)
	{
		$qry = "select * from strat_decisions where gameID =" . $game . " and periodNum=" . $period. " and hotel =".$hotel.";"; 
		//return $qry;
		$r = $this->conn->query($qry);
		$resArr = array();
		if($r)
		{
			while($result = $r->fetch_assoc())
			{	
				$resArr[]  = $result ;
			}
			return $resArr;
		}
		else 
		{
			return false;
		}
	}
	
	function getMarketShare($game, $period)
	{
		$qry = "select * from market_share where gameID =" . $game . " and period=" . $period.";"; 
		//return $qry;
		//exit;
		$r = $this->conn->query($qry);
		$resArr = array();
		if($r)
		{
			while($result = $r->fetch_assoc())
			{	
				$resArr[]  = $result ;
			}
			return $resArr;
		}
		else 
		{
			return false;
		}	
	}
	
	function getMarketShareforGroup($game, $period, $hotel)
	{
		$qry = "select * from market_share where gameID =" . $game . " and period=" . $period." and hotel =".$hotel.";"; 
		//return $qry;
		$r = $this->conn->query($qry);
		$resArr = array();
		if($r)
		{
			while($result = $r->fetch_assoc())
			{	
				$resArr[]  = $result ;
			}
			return $resArr;
		}
		else 
		{
			return false;
		}
	}
	
	function getMarketchart($game, $period, $hotel)
	{
		$qry = "select * from market_share where gameID =" . $game . " and period=" . $period."and hotel =".$hotel.";"; 
		//return $qry;
		$r = $this->conn->query($qry);
		$resArr = array();
		if($r)
		{
			while($result = $r->fetch_assoc())
			{	
				$resArr[]  = $result ;
			}
			return $resArr;
		}
		else 
		{
			return false;
		}
	}
	
	function gethotelname($id)
	{
		$qry = "select name from hotel where id =". $id.";"; 
		//return $qry;
		$r = $this->conn->query($qry);
		$resArr = array();
		if($r)
		{
			while($result = $r->fetch_assoc())
			{	
				$resArr[]  = $result ;
			}
			return $resArr;
		}
		else 
		{
			return false;
		}	
	}
	
	function getAdvertFromStrats($game, $period, $hotel)
	{
		//var_Dump($game);
		//var_dump($period);
		$qry = "select * from strat_decisions where hotel=";
		$qry.= $hotel . " and gameid=". $game . " and periodNum=" . $period .";"; 
		//return $qry;
		$r = $this->conn->query($qry);
		$resArr = array();
		if($r)
		{
			while($result = $r->fetch_assoc())
			{	
				$resArr[]  = $result ;
			}
			return $resArr;
		}
		else 
		{
			
			return false;
		}	
	}
	
	
	// this function returns an array of decimals representing the decisions impact on a market for a group during one period
	public function getDecisionsImpact($game,$period, $group) // ok
	{
		$P_Impacts = database::getPersonnel();
		$allAdvert = database::getAdvertising();
		$newEffect = database::getNewsEffects($game, $period);
	
	
	
	//*getting advertising impact*//
		$advertQRY = "select adv1, adv2, adv3, adv4, adv5, adv6, adv7, adv8, adv9, adv10, adv11 from strat_decisions where hotel=";
		$advertQRY.= $group. " and gameID = " . $game . " and periodNum=" . $period . ";";
		//return $advertQRY;
		
		$r = $this->conn->query($advertQRY);
		
		$advertising = array();
		$decisions = array();
		
		if($r)
		{
			while($result = $r->fetch_assoc())
			{	
				foreach($result as $res)
				{
					if($res==0)
					{
						break;
					}
					array_push($advertising, $res); // this is the advertising that a group selected
				}
				
							
			}
								
			 // temp array only used to get impact for each advertising the group selected.
			
			foreach($advertising as $ad)
			{
					//$temp = array(floatval($allAdvert[$ad-1]['impact']));
					
				array_push($decisions,  floatval($allAdvert[$ad-1]['impact']) );
			}
			
			//*getting advertising impact ---  Finished*//
		}
		else 
		{
			return false;
		}
		
		
		$P_QRY = "select P1, P2, P3 from strat_decisions where hotel=";
		$P_QRY.= $group. " and gameID = " . $game . " and periodNum=" . $period . ";";
		
		$rr = $this->conn->query($P_QRY);
		$selectPersonnel = array();
		
		if($rr)
		{
		$count = 0;
			while($result = $rr->fetch_assoc())
			{	
				foreach($result as $res)
				{
					if(intval($res) != 0)
					{
					
						array_push($decisions, intval($res) * floatval($P_Impacts[$count]['impact'])); // this is the advertising that a group selected
						
					}
					$count++;
				}
				
							
			}
					//**getting personnel -- end**//
		}
		else
		{
			return false;
		}

		return $decisions; // all the decision impact for a group
	}
	
	public function getNewsEffects($game, $period)
	{
		$qry = "select p.effect, p.hotel_type, p.hotel_location from news_parameters p, news n where n.id =p.news_id and n.game=";
		$qry.= $game . " and n.periodNum = " . $period .";";
		//return $qry;
		
		$r = $this->conn->query($qry);
		$res = array();
		if($r)
		{
			while($result = $r->fetch_assoc())
			{	
				$res[]  = $result ;
			}
			return $res;
		}
		else 
		{
			return "didn't work";
		}
	}
	
	function getGroupsIDforGame($game)
	{
		$r = $this->conn->query($str =sprintf("select distinct h.id, h.name, h.location, h.type as hotel_type from game g, location l, hotel h where '%s' = h.game and h.location = l.id;", $game));
		//return $str;
		$resArr = array();				//select distinct h.id as id, h.name, l.type as type1, h.type as type2 from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id
		if($r)
		{
			while($result = $r->fetch_assoc())
			{
				$resArr[]  = $result ;
			}
			return $resArr;
		}
		else
		{
			return false;
		}
	}
	
	function getTotalRooms()
	{
		$r = $this->conn->query("select * from totalrooms;");
		//return $str;
		$resArr = array();				//select distinct h.id as id, h.name, l.type as type1, h.type as type2 from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id
		if($r)
		{
			while($result = $r->fetch_assoc())
			{
				$resArr[]  = $result ;
			}
			return $resArr;
		}
		else
		{
			return false;
		}
	}
	public  function  Alpha($game, $period)
	{
		$r = $this->conn->query("select hotel, aveRate from strat_decisions where gameID=" . $game." and periodNum=".$period.";");
		$resArr = array();				//select distinct h.id as id, h.name, l.type as type1, h.type as type2 from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id
		if($r)
		{
			while($result = $r->fetch_assoc())
			{
				$resArr[]  = $result ;
			}
			return $resArr;
		}
		else
		{
			return false;
		}
	}
	
	public  function  Epsilon($game, $period, $group)
	{
		//return "select hotel, OTA from strat_decisions where gameID=" . $game." and periodNum=".$period." and hotel =".$group.";";
		$r = $this->conn->query("select hotel, OTA from strat_decisions where gameID=" . $game." and periodNum=".$period." and hotel =".$group.";");
		$resArr = array();				//select distinct h.id as id, h.name, l.type as type1, h.type as type2 from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id
		if($r)
		{
			while($result = $r->fetch_assoc())
			{
				$resArr[]  = $result ;
			}
			return $resArr;
		}
		else
		{
			return false;
		}
	}
	
	public  function  getGroupComments($game, $period, $group)
	{
		//return "select hotel, OTA from strat_decisions where gameID=" . $game." and periodNum=".$period." and hotel =".$group.";";
		$r = $this->conn->query("select comments from student_comments where gameID=" . $game." and periodNum=".$period." and hotel =".$group.";");
		$resArr = array();				//select distinct h.id as id, h.name, l.type as type1, h.type as type2 from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id
		if($r)
		{
			while($result = $r->fetch_assoc())
			{
				$resArr[]  = $result ;
			
			}
			return $resArr;
		}
		else
		{
			return false;
		}
	}
	
	//insertBeta function adds a record to the marketshare table
	
	public function insertBeta($game, $period,$theta, $BETA_J )
	{
		$qry = "insert into market_share (gameid, period, hotel, roomsSold, groupSold) values (" . $game . ", " .
		$period . ", " . $BETA_J['group'] . ", " 
		. $theta . ", "
		. $BETA_J['BETA_J'] . " );";
	
		if (mysqli_query($this->conn, $qry)) 
			{
				return "pass";
			} 
		else
		{
			return "fail";
		}
	}
	
	
	//insert revenue for a group for end of period
	
	public function insertrevenue($game, $period, $delta)
	{
		$qry = "insert into revenue (game, period, hotel, revenue) values (" . $game . ", " . $period . ", " . $delta['group'] . ", ". $delta['DELTA'] . " );";
	
		if (mysqli_query($this->conn, $qry)) 
			{
				return "pass";
			} 
		else
		{
			return "fail";
		}
	}


	public function getAllDecisions($game, $period)
	{
		$qry = "select hotel from strat_decisions where gameID = " . $game ." and periodNum =" . $period. ";";
		$r = $this->conn->query($qry );//return $str;
		$resArr = array();				//select distinct h.id as id, h.name, l.type as type1, h.type as type2 from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id
		if($r)
		{
			while($result = $r->fetch_assoc())
			{
				$resArr[]  = $result ;
			
			}
			return $resArr;
		}
		else
		{
			return false;
		}
	}
			
	public function insertdecs($game, $period,  $aveRate, $hotel,$ad1,$ad2,$ad3,$p1, $p2, $p3, $ota   )
	{
		$qry = "insert into strat_decisions (gameID, periodNum, aveRate, hotel, adv1, adv2, adv3, adv4, adv5, adv6, adv7, adv8, adv9, adv10, adv11,P1, P2,P3, OTA) values ";
		$qry .=" (".$game.",". $period. "," . $aveRate. "," .$hotel.",".$ad1.",".$ad2.",".$ad3. ",0,0,0,0,0,0,0,0," ;
		$qry .= $p1.",".  $p2.",".  $p3.",".  $ota .");";

		if (mysqli_query($this->conn, $qry)) 
			{
				return "pass";
			} 
		else
		{
			return "fail";
		}
	}
	
	public function getPeriodDate($game, $period)
	{
		$qry = "select pend from game_period where game =".$game." and period = ".$period.";";
		$r = $this->conn->query($qry );//return $str;
		$resArr = array();				//select distinct h.id as id, h.name, l.type as type1, h.type as type2 from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id
		if($r)
		{
			while($result = $r->fetch_assoc())
			{
				$resArr[]  = $result ;
			
			}
		
			return $resArr;
		}
		else
		{
			return false;
		}
	}

	
	
	
	
	
	
	
/////////sprint 4 //////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// _________ //  _______  _______  _______  // __________________ /////////////////////////////////////
///////////////////////// \__   __/ // (  ____ \(  ____ \(  ____ \ // \__   __/\__   __/ /////////////////////////////////////
/////////////////////////    ) (    // | |    \/| |    \/| |    \/ //    ) (      ) (    /////////////////////////////////////
/////////////////////////    | |    // | |_____ | |__    | |__     //    | |      | |    /////////////////////////////////////
/////////////////////////    | |    // (_____  )|  __)   |  __)    //    | |      | |    /////////////////////////////////////
/////////////////////////    | |    //       | || |      | |       //    | |      | |    /////////////////////////////////////
///////////////////////// ___) (___ // /\____| || |____/\| |____/\ // ___) (___   | |    /////////////////////////////////////
///////////////////////// \_______/ // \_______)(_______/(_______/ // \_______/   |_|    /////////////////////////////////////
/////////////////////////           //                             //                    /////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 14 Functions										  
	public function addNews( $game, $article, $period)
	{        
		$stmt = $this->conn->prepare("insert into news (game, article,periodNum) values ( ?, ?,?);");
		$stmt->bind_param("isi", $game, $article,$period);
		$stmt->execute();
	}//1
	
	public function addGame_period( $game, $pstart, $pend, $isActive)
	{        
		$pstart = $this->conn->real_escape_string($pstart);
		$pend = $this->conn->real_escape_string($pend);
	   
		$stmt = $this->conn->prepare("insert into game_period (game, pstart,pend,isActive) values (?,?,?,?);");
		$stmt->bind_param("issi", $game, $pstart, $pend, $isActive);
		$stmt->execute();
	}//2
	
	public function addNews_parameters( $news_id, $effect, $hotel_type, $hotel_location)
	{        
		if($hotel_type == "economy")
			$hotel_type = "Economic";
	
		$stmt = $this->conn->prepare("insert into news_parameters (news_id, effect,hotel_type, hotel_location) values (?,?,?,?);");
		$stmt->bind_param("issi", $news_id, $effect, $hotel_type, $hotel_location);
		$stmt->execute();
	}//3

	public function getNews_by_id($value) 
    {        
        $v = $this->conn->real_escape_string($value);
        $r = $this->conn->query(sprintf("select * from news where id = '%s';",$value));
  
        return $r->fetch_assoc(); 
    }//4
	
	public function getNews_by_game($value,$period) 
    {        
        $value = $this->conn->real_escape_string($value);
		$period = $this->conn->real_escape_string($period);
        $r = $this->conn->query(sprintf("select * from news where game = '%s' and periodNum = '%s';",$value,$period));
    
        return $r->fetch_assoc();
    }//5
	
	public function getAllNews_by_game($game) 
    {        
        $game = $this->conn->real_escape_string($game);
        $r = $this->conn->query(sprintf("select * from news where game = '%s';",$game));
  
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
  
        return $resArr;
    }//6
	
	public function getAllNews_parameters($news_id) 
    {        
		$news_id = $this->conn->real_escape_string($news_id);
		$r = $this->conn->query(sprintf("select * from news_parameters where news_id = '%s';",$news_id));
		$resArr = array();
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
		
        return $resArr;
    }//7
	
	public function getGame_period($value) 
    {        
        $v = $this->conn->real_escape_string($value);
        $r = $this->conn->query(sprintf("select * from game_period where game = '%s';",$value));
  
        return $r->fetch_assoc();
    }//8
	
	
	public function updateNews_article($id,$article)
    {
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			return "fail";
        }

		$article = $this->conn->real_escape_string($article);
		$id = $this->conn->real_escape_string($id);
			
        $sql = sprintf("UPDATE news SET article='%s' WHERE id='%s'",$article,$id);


		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }//9
	
	public function updateNews_periodNum($id,$period)
    {
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			return "fail";
        }

		$period = $this->conn->real_escape_string($period);
		$id = $this->conn->real_escape_string($id);
			
        $sql = sprintf("UPDATE news SET periodNum='%s' WHERE id='%s'",$period,$id);


		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }//10
	
	
	public function updateGame_period($game,$pstart,$pend)
    {
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			return "fail";
        }

		$pstart = $this->conn->real_escape_string($pstart);
		$pend = $this->conn->real_escape_string($pend);
		$game = $this->conn->real_escape_string($game);
			
        $sql = sprintf("UPDATE game_period SET pstart='%s', pend = '%s' WHERE game='%s'",$pstart,$pend,$game);


		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }//11
	
	public function removeNews_parameters($news_id)
    {
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			return "fail";
        }

		$news_id = $this->conn->real_escape_string($news_id);
        $sql = sprintf("delete from news_parameters WHERE news_id='%s'",$news_id);

		$this->conn->query($sql);

		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }//12
	
	public function removeNews($game,$period)
    {
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			return "fail";
        }

		$game = $this->conn->real_escape_string($game);
		$period = $this->conn->real_escape_string($period);
        $sql = sprintf("delete from news WHERE game='%s' and periodNum='%s'",$game,$period);

		$this->conn->query($sql);

		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }//13
	
	function getLocationByType($value)
	{
		 $v = $this->conn->real_escape_string($value);
         $r = $this->conn->query(sprintf("select * from location where type = '%s';",$value));
  
        return $r->fetch_assoc();
	}//14
	

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////SPRINT 666////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getAllComments() 
    {        
		$r = $this->conn->query(sprintf("select * from student_comments;"));
		$resArr = array();

		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
        return $resArr;
    }//1
	
	public function getCommentById($id) 
    {        
        $v = $this->conn->real_escape_string($id);
        $r = $this->conn->query(sprintf("select * from student_comments where id = '%s';",$v));
  
        return $r->fetch_assoc();
    }//2
	
	public function getCommentByGameAndPeriod($game,$period) 
    {       
		$gameStr = "";
		$periodStr = "";
		
		if(isset($game) && $game != null)
		{
			if(count($game) > 0)
			{
				$gameStr = "( game = ".$game[0];
				for($i = 1;$i< count($game);$i++)
					$gameStr .= " or game = ".$game[$i];
				$gameStr .= ")";
			}
			
			if(count($game) > 0 && count($period) > 0)
			{
				$gameStr .= " and ";
			}
		}
		
		if(isset($period) && $period != null)
		{
			if(count($period) > 0)
			{
				$periodStr = "( period = ".$period[0];
				for($i = 1;$i < count($period);$i++)
					$periodStr .= " or period = ".$period[$i];
				$periodStr .= ")";
			}
		}
		

        $v = $this->conn->real_escape_string($gameStr);
		$v .= $this->conn->real_escape_string($periodStr);
		

		$q = sprintf("select * from student_comments where %s;",$v);
		$r = $this->conn->query($q);//sprintf("select * from student_comments where ('%s');",$v));

		
		$resArr = array();
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
		
        return $resArr; 
    }//3
	

	
	public function updateFeedback($id,$feedback)
	{
		$result = "";
        if (!$this->conn) 
        {
			die("Connection failed: " . mysqli_connect_error());
			$result = "fail";
        }
		
		$id = $this->conn->real_escape_string($id);
		$feedback = $this->conn->real_escape_string($feedback);
		
        $sql = sprintf("UPDATE student_comments SET feedback='%s' WHERE id='%s'",$feedback,$id);

		$this->conn->query($sql);
				
		
		if($this->conn->affected_rows==0)
			return "fail";
		return "pass";
    }//4
	
	function getHotelByGameID($gameID)
	{
		 $v = $this->conn->real_escape_string($gameID);
         $r = $this->conn->query(sprintf("select * from hotel where game = '%s';",$v));
  
		$resArr = array();
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
		
        return $resArr; 
	}//5
	function getStudentByHotel($HotelID)
	{
		 $v = $this->conn->real_escape_string($HotelID);
         $r = $this->conn->query(sprintf("select * from student where hotel = '%s';",$v));
  
		$resArr = array();
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
		
        return $resArr; 
	}//6
	
	function getMarketShareByHotelAndPeriod($HotelID,$period)
	{
		$v = $this->conn->real_escape_string($HotelID);
		$s = $this->conn->real_escape_string($period);
		$r = $this->conn->query(sprintf("select * from market_share where hotel = '%s' and period = '%s';",$v,$s));
  
		return $r->fetch_assoc();
	}//7
	
	public function getCommentByHotelAndPeriod($hotel,$period) 
    {        
        $v = $this->conn->real_escape_string($hotel);
		$s = $this->conn->real_escape_string($period);
        $r = $this->conn->query(sprintf("select * from student_comments where hotel = '%s' and period = '%s';",$v,$s));
  
  	/*	if($this->conn->affected_rows==0)
			return ($v.' : '.$s.' : '."fail<br />");
		return ("pass");*/
  
  
        return $r->fetch_assoc();
    }//8
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////SPRINT SeVeN////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function getCommentsByHotel($hotel) 
    {       
		$v = $this->conn->real_escape_string($hotel);	
		$r = $this->conn->query(sprintf("select * from student_comments where hotel = '%s';",$v));
		$resArr = array();

		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
		}
        return $resArr;
    }//1
	
	
}
?>

