<?php

class User
{
	public function __construct()
	{
		
	}
	
	// *****************************************************
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	// *****************************************************
	
	public function setEmail($email)
	{
		$this->email = $email;
	}
	
	public function setPassword($password)
	{
		$this->password = $password;
	}
	
	// *****************************************************
	
	private $email;
	private $password;
}

?>
