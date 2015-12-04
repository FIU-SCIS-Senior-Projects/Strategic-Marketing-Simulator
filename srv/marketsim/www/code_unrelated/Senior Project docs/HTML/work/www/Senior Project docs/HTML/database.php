<?php



 
  
define ('SERVER',		'localhost');
  define ('USERNAME', 	'root');
  define ('PASSWORD', 	'Jeff_1230');
  define ('DATABASE',	'marketsim'); 
class database
{
  // it should work like this
 

 private $conn;
 // ---------------We need to fix the constuctor to make the connection instead of doing it in each function
 //like in SearchForStudents below
  /*function __contruct() // correct - when you create a database the constructor here is called
  {
    $this->conn = new mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
	
    if ($this->conn->connect_error !== null) {
      
	  
    }
	//else
		//error(); 
  }*/

  public function searchForStudents($v) 
  {
   // for now I am putting the connection in every time
	$this->conn = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE); // -- uncomment this and comment constuctor
    $v = $this->conn->real_escape_string($v);
    $r = $this->conn->query(sprintf("select * from student where email like '%%%s%%' or fname like '%%%s%%' or lname like '%%%s%%' or id like '%%%s%%';",$v,$v,$v, $v));
    //mysql_close($this->conn);
	return $r->fetch_assoc(); // uncomment to return array
    //$res = $r->fetch_assoc();
	//$str = implode(" ", $res); // this is just to see a string

	//return $str; // returning string to createAccount
	}

    public function getStudent($value) {
    $v = $this->conn->real_escape_string($value);
    return $this->conn->query(sprintf("select * from student where id = %s or email = %s;", $v, $v));
  }

  /*public function getStudent($id = null, $email = null)
  {
    // Just do the query. Escape as you go.
    if ($id !== null) {
      return $this->conn->query(sprintf("select * from student where id = %s", $this->conn->real_escape_string($id)));
    }
    else if ($email !== null) {
      return $this->conn->query(sprintf("select * from student where email = %s", $this->conn->real_escape_string($email)));
    }
    else {
      throw new InvalidArgumentException("No arguments supplied to getStudentById");
    }

    /*
    $query = sprintf("SELECT * FROM student WHERE id = '%s'"); // sql query string
    mysql_real_escape_string($id); //escape string

    $this->$res = mysql_query($query); // perform query
                echo $this->$res;
    
  }*/



  public function addStudent($id, $fname, $lname, $email, $bot, $hotel)
  {

	$conn2 = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);  // this should be in the constuctor
    // Try parameter binding it is secure and avoids the need to
    // escape every bit of data:
    $stmt = $conn2->prepare("insert into student (id,fname, lname, email, bot, hotel ) values (?, ?, ?, ?, ?, ?);");
    echo var_dump($stmt);
	$stmt->bind_param("isssii", $id, $fname, $lname, $email, $bot, $hotel);
    $stmt->execute();

  }

  public function deactiveStudent($id)
  {
    // Left as an exercise to the programmer, hint update query using
    // param binding! where id = $id

  }

  public function activateStudent($id)
  {

  }


}


?>
