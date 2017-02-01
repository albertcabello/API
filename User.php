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
    var $loggedIn;

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
            $this->loggedIn = 1;


        }
        else {
            //echo 'Database username is not equal to username or database password is not equal to password<br>';
            //mysqli_close($con);
            $this->loggedIn = 0;
        }
        $this->getLongitude();
        $this->getLatitude();
    }

    function getName() {
        return $this->username;
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
        $sql = "update users set longitude = $longitude, latitude = $latitude where username = '$this->username'";
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
         
        //Initialize the upper and lower longitude values

        //Due to how MySQL works, the lesser negative value must be the first value in the between statement
        //A mile in longitudinal degree is 1/(cos(lat) * miles at equator which is 69)
        //Half a mile in longitudinal degrees is therefore 1/(2cos(lat) * 138)
        //A mile in latitudinal degrees is 1/69
        //Therefore half a mile in latitudinal degrees is 1/138

        //Half mile latitude
        $halfMileLat = 1/138;

        //Half mile longitude
        $halfMileLong = abs((1/((2 * cos($this->lat)) * 138)));

        if ($this->long < 0) { //If the longitude is negative
          $lowerLong = $this->long - $halfMileLong; //Make the more negative number the lower longitude
          $upperLong = $this->long + $halfMileLong;
          //echo "Upper is: $upperLong, lower is $lowerLong <br>";
        }
        else { //Longitude is positive
          $lowerLong = $this->long - $halfMileLong;
          $upperLong = $this->long + $halfMileLong;
            //echo "Upper is: $upperLong, lower is $lowerLong <br>";
        }
        if ($this->lat < 0) { //If the latitude is negative
          $lowerLat = $this->lat - $halfMileLat; //Make the more negative number the lower latitude
          $upperLat = $this->lat + $halfMileLat;
            //echo "Upper is: $upperLat, lower is $lowerLat <br>";
        }
        else { //Latitude is positive
          $lowerLat = $this->lat - $halfMileLat;
          $upperLat = $this->lat + $halfMileLat;
            //echo "Upper is: $upperLat, lower is $lowerLat <br>";
        }
        //SQL statement to get nearby users that are withing ten percent of the longitude and latitude
        $sql = "select username,latitude,longitude
                from (
                select username,latitude,longitude
                from users
                where latitude between $lowerLat and $upperLat and
                      longitude between $lowerLong and $upperLong
                ) AS result
                where (NOT username = '$this->username') limit 10;";
        //mysqli_result object returned by mySQLQuery()
        $result = VariousFunctions::mySQLQuery($sql);
        $resultArray = array();
        while ($row = $result->fetch_object()) {
            array_push($resultArray, $row);
        }
        return json_encode($resultArray);
    }

    /**
     * Returns the preferences for a given user
     * @param $user User object user that the username will be searched for in the mySQL database
     * @return string json array of the preferences of the given user
     */
    function getPrefs($prefsFor) {
        //SQL statement to get the preferences for the given user
        $sql = "select * from preferences where username = '$prefsFor'";
        $result = VariousFunctions::mySQLQuery($sql);
        $resultArray = array();
        while ($row = $result->fetch_object()) {
            array_push($result, $row);
        }
        return json_encode($resultArray);
    }



}
