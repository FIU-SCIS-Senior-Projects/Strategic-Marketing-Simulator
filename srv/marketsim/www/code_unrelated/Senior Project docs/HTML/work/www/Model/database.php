<?php

require ("/srv/marketsim/www/Entities/StudentEntity.php");

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
		if($semester == NULL or $courseID == NULL or $section== NULL or $schedule== NULL or $isActive== NULL or $courseNumber == NULL)
		{return "fail"; exit;}
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
		{return "fail"; exit;}
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
		{return "fail";}
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
		
		if($email==NULL or $isActive==NULL)
		{return "fail"; exit;}

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
		if($student == NULL or $hotel == NULL){return false; exit;}
		
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
         $r = $this->conn->query(sprintf("select * from location where id = '%s';",$value));
  
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
}


?>

