<?php

/**
 * Created by PhpStorm.
 * User: albertocabello
 * Date: 11/9/16
 * Time: 8:22 PM
 */

/**
 * Class User
 * Logs in the user if the given username and password when instantiated exists
 * Can set new coordinates for the user
 * Can retrieve the coordinates of the user
 */
include 'VariousFunctions.php';
class User
{
    var $username;      //The username of the User
    var $long;     //Longitude coordinate of the User
    var $lat;      //Latitude coordinate of the User

    /**
     * User constructor.
     * @param $username string the username that should match database
     * @param $password string the password that should match database
     * If the provided username and password match database, then this will assign the username to the local variable
     * username allowing other functions to work.  Otherwise, the program dies.
     * Initialize the long variable to the longitude stored in the database
     * Initialize the lat variable to the longitude stored in the database
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
            echo('1<br>');

        }
        else {
            //echo 'Database username is not equal to username or database password is not equal to password<br>';
            //mysqli_close($con);
            die('Username and password did not match');
        }
        $this->getLongitude();
        $this->getLatitude();
    }


    /**
     * @return mixed string containing the latitudinal value for this User
     */
    function getLatitude() {
        //SQL statement to get latitude of the user
        $sql = "SELECT latitude FROM users WHERE username = '$this->username'";
        //mysqli_result object returned by mySQLQuery()
        $result = VariousFunctions::mySQLQuery($sql);
        while ($obj = $result->fetch_object()) {
            $this->lat = $obj->latitude;
        }
        $result->close();
        return $this->lat;
    }//

    /**
     * @return mixed string containing the longitudinal value for this User
     */
    function getLongitude() {
        //SQL statement to get longitude of the user
        $sql = "SELECT longitude FROM users WHERE username = '$this->username'";
        //mysqli_result object returned by mySQLQuery()
        $result = VariousFunctions::mySQLQuery($sql);
        while ($obj = $result->fetch_object()) {
            $this->long = $obj->longitude;
        }
        $result->close();
        return $this->long;
    }

    /**
     * @param $latitude string the desired
     * @param $longitude
     * @return string
     */
    function setCoordinates($latitude, $longitude) {
        //SQL statement to set latitude and longitude
        $sql = "update users set longitude = $longitude, latitude = $latitude where username = $this->username;";
        //mysqli_result object returned by mySQLQuery()
        $result = VariousFunctions::mySQLQuery($sql);
        if ($result) {
            return '1';
        }
        else {
            return '0';
        }
    }

    /**
     * @return string returns the username and coordinates of users nearby the current user
     */
    function getNearbyUsers() {
        $lowerLat = .9 * $this->lat;
        $upperLat = 1.1 * $this->lat;
        $lowerLong = .9 * $this->long;
        $upperLong = 1.1 * $this->long;
        //SQL statement to get nearby users that are withing ten percent of the longitude and latitude
        $sql = "select username,latitude,longitude
                from (
                select username,latitude,longitude
                from users 
                where latitude between $lowerLat and $upperLat AND
                      longitude between $lowerLong and $upperLong
                ) AS result
                where (NOT username = '$this->username');";
        //mysqli_result object returned by mySQLQuery()
        $result = VariousFunctions::mySQLQuery($sql);
        $resultArray = array();
        while ($row = $result->fetch_object()) {
            array_push($resultArray, $row);
        }
        return json_encode($resultArray);
    }
}