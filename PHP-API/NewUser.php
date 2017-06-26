<?php 
/** Class to create a new user and add it to the database **/
require_once('VariousFunctions.php');
class NewUser {
	function __construct($username, $password, $email) {
		//SQL statemenet to execute
		$sql = "select * from users where username = '$username'";
		//$sql = "insert into users (username, password, email) values ('$username', '$password', '$email')";
		//mysqli_result returned by mysqli_query()
		$result = VariousFunctions::mySQLQuery($sql);
		/*
		if (!$result) {
			//Couldn't add user to the database
			die('Error adding using to database');
		}
		else {
			//User was able to be added
			echo 1;
		}*/
		if ($result->num_rows > 0) {
			echo 'Username exists';
		}
		else {
			$sql = "insert into users (username, password, email) values ('$username', '$password', '$email')";
			$result = VariousFunctions::mySQLQuery($sql);
			echo 'User added';
		}
	}
}
?>
