<?php

/**
 * Created by PhpStorm.
 * User: albertocabello
 * Date: 11/9/16
 * Time: 8:22 PM
 */
class User
{
    var $username;      //The username of the User
    var $longitude;     //Longitude coordinate of the user
    var $latitude;      //Latitude coordinate of the user

    /**
     * User constructor.
     * @param $username string the username that should match database
     * @param $password string the password that should match database
     * If the provided username and password match database, then this will assign the username to the local variable
     * username allowing other functions to work.  Otherwise, the program dies.
     */
    function __construct($username, $password) {
        //SQL statement to execute
        $sql = "SELECT username, password FROM users WHERE username = '$username'";
        //mysqli_result object returned by mySQLQuery()
        $result = VariousFunctions::mySQLQuery($sql);
        $dbUsername = '';
        $dbPassword = '';
        while ($row = $result->fetch_row()) {
            $dbUsername .= $row[0];
            $dbPassword .= $row[1];
        }
        //echo "Database User: $dbUsername, Database Password: $dbPassword<br>";
        if ($username === $dbUsername && $password === $dbPassword) { //Given username and password match database
            //echo 'Database username is equal to username and database password is equal to password<br>';
            //mysqli_close($con);
            $this->username = $username;
            echo('1');

        }
        else {
            //echo 'Database username is not equal to username or database password is not equal to password<br>';
            //mysqli_close($con);
            die('Username and password did not match');
        }
    }

    /**
     * @return mixed
     */
    function getLatitude() {
        //SQL statement to get latitude of the user
        $sql = "SELECT latitude FROM users WHERE username = '$this->username'";
        //mysqli_result object returned by mySQLQuer()
        $result = VariousFunctions::mySQLQuery($sql);
        $this->latitude = $result->fetch_field();
        return $this->latitude;
    }


}