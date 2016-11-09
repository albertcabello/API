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
     * @param $username the username to check against the database
     * @param $password the password to check against the database
     * @return bool; true if login matches, false otherwise
     * This function inputs a username and password and checks them against the MySQL database.
     * If the username and password match what is in the database, return true, false otherwise.
     */
    function login($username, $password) {
        // echo $username . ' ' . $password . '<br>';
        //New MySQL connection
        $con = mysqli_connect($this->host, $this->db_username, $this->db_password, $this->database);
        //SQL statement to get the username and password that matches for a username
        $sql = "SELECT username, password FROM users WHERE username = '$username'";
        //Do the query and store it in $result
        $result = mysqli_query($con, $sql);
        if ($result) { //$result exists
            //echo 'No Error<br>';
        }
        else { //$result does not exist
            die('Error, could not query database<br>');
        }
        $dbUsername = ' ';
        $dbPassword = ' ';
        while ($row = $result->fetch_row()) {
            $dbUsername .= $row[0];
            $dbPassword .= $row[1];
        }
        //echo "Database User: $dbUsername, Database Password: $dbPassword<br>";
        if ($username === $dbUsername && $password === $dbPassword) {
            //echo 'Database username is equal to username and database password is equal to password<br>';
            return 10;
        }
        else {
            //echo 'Database username is not equal to username or database password is not equal to password<br>';
            return -90;
        }

    }
}