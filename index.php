<?php
/**
 * Created by PhpStorm.
 * User: albertocabello
 * Date: 11/8/16
 * Time: 7:38 PM
 */
 include 'Handler.php';
 include 'User.php';
if (isset($_GET["userGiven"], $_GET["passGiven"])) {
$userGiven = $_GET["userGiven"];
$passGiven = $_GET["passGiven"];
$testUser = new User($userGiven, $passGiven);
echo $testUser->getLatitude() . '<br>';
echo $testUser->getLongitude() . '<br>';
echo $testUser->setCoordinates(1,1);
}
?>
