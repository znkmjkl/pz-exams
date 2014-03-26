<?php

include_once("User.php");
include_once("DatabaseConnector.php");

final class UserDatabase
{
	/*
	 * Metoda sprawdza czy użytkownik o zadanym e-mailu istnieje w bazie danych.
	 */
	static public function checkEmail($basicUser)
	{
		$sql = "Select * from Users where Email = '".$basicUser->getEmail()."'";

		DatabaseConnector::getConnection()->query($sql) ? true : false;
	}
	
	/*
	 * Metoda sprawdza czy przypisane hasło do klasy $user jest poprawne.
	 */
	static public function checkPassword($basicUser)
	{
		$sql = "Select * from Users where Email = '". $basicUser->getEmail()."' && Password = '". $basicUser->getPassword()."'";
		$result = DatabaseConnector::getConnection()->query($sql);
		$row_num = $result ->num_rows;
		if($row_num == 1)
		{
			$result = DatabaseConnector::getConnection()->query($sql);
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$user->setID($row['ID']);
			$_SESSION['USER'] = $basicUser;
			return true;
		}
		return false;		
	}
	
	static public function addUser($user)
	{ 
		$values = "('"	. $user->getEmail() . "','"
				        . $user->getPassword() . "','" 
				        . $user->getName() . "','arek ','private','examiner' , 'female' , '"
				        . date("Y/m/d") . "')";  
				
		$sql =  "INSERT INTO Users (Email, Password, FirstName , Surname, Visibility , Rights , Gender , RegistrationDate)" 
			 .	"VALUES $values";

		return DatabaseConnector::getConnection()->query($sql) ? true : false;
	} 
	
	// Nie pozwalamy na utworzenie obiektu - Jeżeli zrozumiałeś design to nigdy nie zmienisz tego konstruktora na publiczny ;)
	private function __construct() { }
}

?>