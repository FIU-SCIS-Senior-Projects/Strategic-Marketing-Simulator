<?php
ini_set('display_errors', 1);
error_reporting(~0);

//require ("/srv/marketsim/www/Entities/StudentEntity.php");


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


		$this->conn->query($sql);
				
		
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
		
		$r = $this->conn->query(sprintf("select distinct name, l.type from game g, location l, hotel h where '%s' = h.game and h.location = l.id;", $id));
		$resArr = array();				//select distinct h.id as id, h.name, l.type as type1, h.type as type2 from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id
		
		while($result = $r->fetch_assoc())
		{
			$resArr[]  = $result ;
			
		}
		
        return $resArr;
		
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
	
	//sprint 5
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
		$secretAns = trim($secretAns);
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
		$secretAns = trim($secretAns);
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

