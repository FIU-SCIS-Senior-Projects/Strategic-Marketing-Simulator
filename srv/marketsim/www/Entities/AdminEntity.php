<?php
/*created by Javier Andrial*/
class AdminEntity 
{
    public $id;
    public $fname;
    public $lname;
    public $email;
    public $password;
    public $secretQuestion;
    public $secretAnswer;
	public $isActive;
    
    function __construct($id, $first_name, $last_name, $email,$password,$secretQuestion,$secretAnswer,$isActive) 
    {
        $this->id = $id;
        $this->fname = $first_name;
        $this->lname = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->secretQuestion = $secretQuestion;
        $this->secretAnswer = $secretAnswer;
		$this->isActive = $isActive;
	}

}


?>