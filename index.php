<?php
/**
 * Created by PhpStorm.
 * User: albertocabello
 * Date: 11/8/16
 * Time: 7:38 PM
 */

include 'User.php';
$action = $_GET["action"];
$userGiven = $_GET["userGiven"];
$passGiven = $_GET["passGiven"];
$user = new User($userGiven, $passGiven);

if ($action == "login") {
    echo $user->loggedIn;
}
if ($action == "get") {
    if ($user->loggedIn == 1) {
        echo $user->getNearbyUsers();
    }
    else {
        echo '0';
    }
}
if ($action == "update") {
    if ($user->loggedIn == 1) {
        echo $user->setCoordinates($_GET["latitude"], $_GET["longitude"]);
     }
     else {
        echo '0';
     }
}
if ($action == "getPrefs") {
    $prefsFor = $_GET["prefsFor"];
    if ($user->loggedIn == 1) {
        echo $user->getPrefs(searchedFor);
    }

}
?>
