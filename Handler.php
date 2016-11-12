<?php
/**
 * Created by PhpStorm.
 * User: albertocabello
 * Date: 11/8/16
 * Time: 7:18 PM
 */

/**
 * Class Handler
 * Handles the various HTTP responses, GET, POST, etc. for the Icebreaker API.
 */
include 'VariousFunctions.php';
class Handler {
    /**
     * @param $username string the username to check against the database
     * @param $password string the password to check against the database
     * @return int 1 if provided username and login match server, 0 if they don't match or username does not exist
     * This function inputs a username and password and checks them against the MySQL database.
     * If the username and password match what is in the database, return true, false otherwise.
     */
    /* function login($username, $password) {
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
        if ($username === $dbUsername && $password === $dbPassword) {
            //echo 'Database username is equal to username and database password is equal to password<br>';
            //mysqli_close($con);
            return 1;

        }
        else {
            //echo 'Database username is not equal to username or database password is not equal to password<br>';
            //mysqli_close($con);
            return 0;
        }
    } */

    /**
     * @param $latitude double the latitude that will be used to find others near that latitude
     * @param $longitude double the longitude that will be used to find others near that longitude †
     */
    function getNearbyUsers($latitude, $longitude) {

    }
}