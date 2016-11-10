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
}
 ?>
