<?php
/**
 * Created by PhpStorm.
 * User: Nemina
 * Date: 7/13/2015
 * Time: 9:52 AM
 */

require_once "deviceDependentAPI.php"
?>

    // Device Dependent

<?php

$api = new deviceDependentAPI();

echo $api->getCAPTCHA();

?>

<?php
if (isset($_POST)) {


    $api = new deviceDependentAPI();
    $data = $_POST;

    $isValid = $api->Validate($data);


    if ($isValid == "true") {

        // Proceed
    } else {
        //Error
    }
}
?>

    // HoneyPot and Timestamp

<?php

$api = new deviceDependentAPI();

echo $api->getHoneyPot();

?>

<?php
if (isset($_POST)) {


    $api = new deviceDependentAPI();
    $data = $_POST;

    $isValid = $api->HoneyPotValidation($data);


    if ($isValid == "true") {
        // Proceed
    } else {
        //Error
    }
}
?>