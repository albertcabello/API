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
class Handler {
    var $host = '127.0.0.1';
    var $db_username = 'root';
    var $db_password = 'corvette';
    var $database = 'AppTestingUsers';
    function __construct() {
        print "In Handler Constructor<br>";
    }

    /**
     * @param $username string the username to check against the database
     * @param $password string the password to check against the database
     * @return int 1 if provided username and login match server, 0 if they don't match or username does not exist
     * This function inputs a username and password and checks them against the MySQL database.
     * If the username and password match what is in the database, return true, false otherwise.
     */
    function login($username, $password) {
        //SQL statement to execute
        $sql = "SELECT username, password FROM users WHERE username = '$username'";
        //mysqli_result object returned by mySQLQuery()
        $result = $this->mySQLQuery($sql);
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
    }

    /**
     * @param $query string the desired query to perform on the mysql server
     * @return mysqli_result the result from the mysql query
     * This function inputs a string $query, a connection to the mySQL database is opened, the query is performed
     * and then a mysqli_result object is returned that can be manipulated wherever this function was called
     */
    function mySQLQuery($query) {
        //New MySQL connection
        $con = mysqli_connect($this->host, $this->db_username, $this->db_password, $this->database);
        //Do the query and store it in $result
        $result = mysqli_query($con, $query); //This is a mysqli_result object
        if ($result) {//$result exists
            return $result;
        }
        else {//$result does not exist
            die('Error, could not perform query');
        }
    }

    /**
     * @param $latitude double the latitude that will be used to find others near that latitude
     * @param $longitude double the longitude that will be used to find others near that longitude †
     */
    function getNearbyUsers($latitude, $longitude) {

    }
}