<?php
/*created by Javier Andrial*/
class StudentEntity 
{
    public $id;
    public $fname;
    public $lname;
    public $email;
    public $bot;
    public $hotel;
    public $password;
    public $secretQuestion;
    public $secretAnswer;
	public $isActive;
    
    function __construct($id, $first_name, $last_name, $email, $bot, $hotel,$password,$secretQuestion,$secretAnswer,$isActive) 
    {
        $this->id = $id;
        $this->fname = $first_name;
        $this->lname = $last_name;
        $this->email = $email;
        $this->bot = $bot;
        $this->hotel = $hotel;
        $this->password = $password;
        $this->secretQuestion = $secretQuestion;
        $this->secretAnswer = $secretAnswer;
		$this->isActive = $isActive;
	}

}


?>

