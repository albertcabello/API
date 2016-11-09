<?php
/**
 * Created by PhpStorm.
 * User: albertocabello
 * Date: 11/8/16
 * Time: 7:38 PM
 */
 include 'Handler.php';
if (isset($_GET["userGiven"], $_GET["passGiven"])) {
echo 'Isset true<br>';
$userGiven = $_GET["userGiven"];
$passGiven = $_GET["passGiven"];
$login = new Handler();
echo $login->login($userGiven, $passGiven);
}
 ?>
