<?php

/**
 * Created by PhpStorm.
 * User: albertocabello
 * Date: 11/9/16
 * Time: 8:51 PM
 */

/**
 * Class VariousFunctions
 * This class is a conglomeration of various functions so I don't have to retype things over and over
 */
class VariousFunctions
{
    /**
     * @param $query string the desired query to perform on the mysql server
     * @return mysqli_result the result from the mysql query
     * This function inputs a string $query, a connection to the mySQL database is opened, the query is performed
     * and then a mysqli_result object is returned that can be manipulated wherever this function was called
     */
    static function mySQLQuery($query) {
        //New MySQL connection
        $con = mysqli_connect('127.0.0.1', 'acabello', '4kbllo56', 'AppTestingUsers');
        //Do the query and store it in $result
        $result = mysqli_query($con, $query); //This is a mysqli_result object
        if ($result) {//$result exists
            return $result;
        }
        else {//$result does not exist
            die('Error, could not perform query');
        }
    }

}
