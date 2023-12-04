<?php

require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');
require_once('Models/Core/Validator.php');

$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();
$errors = [];

if ($_POST['type'] == 'AssignDeliverer') {
    $assignedDeliverer = $_POST['username'];
    $parcelID = $_POST['_id'];

    if ($deliveryUserDataSet->checkUserExists($assignedDeliverer)) {
        $deliveryPointDataSet->assignDeliverer($parcelID, $assignedDeliverer);
    } else {
        $errors['InvalidInput']['InvalidUsername'] = "Username Not Found. Try again!";
    }

} elseif ($_POST["type"] == "EditUser") {
    $delivererUsername = $_POST['username'];
    $delivererPassword = $_POST['password'];
    $delivererID = $_POST['_id'];

    if(!Validator::validateString($delivererUsername, 1, 44)) {
        $errors['InvalidInput']['InvalidStringUsername'] = "UserName must be between 1 and 44 characters!";
    }

    if(empty($errors))
    {
        if (!$_POST['password'] == null) {
            $deliveryUserDataSet->updateDeliverer($delivererID, $delivererUsername, $delivererPassword);
        } else {
            $deliveryUserDataSet->updateDelivererNoPassword($delivererID, $delivererUsername);
        }
    }
} elseif ($_POST["type"] == "EditParcel") {
    $parcelID = $_POST['_id'];
    $parcelName = $_POST['name'];
    $parcelAddress1 = $_POST['address1'];
    $parcelAddress2 = $_POST['address2'] ?? '';
    $parcelPostcode = $_POST['postcode'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $parcelDeliverer = $_POST['deliverer'];
    $parcelStatus = $_POST['status'];

    $status = ParcelText($parcelStatus);

    if (!$deliveryUserDataSet->checkUserExists($parcelDeliverer)) {
        $errors['InvalidInput']['InvalidUsername'] = "Invalid deliverer. Try again! ";
    } else {
        $parcelDelivererID = $deliveryUserDataSet->getUserID($parcelDeliverer);
    }

    if (!Validator::isNumeric($latitude) || !Validator::isNumeric($longitude)) {
        $errors['InvalidInput']['NotIntegers'] = "Latitude and longitude must be integers!";
    }

    if(!Validator::validateString($parcelName, 1, 44)) {
        $errors['InvalidInput']['InvalidStringName'] = "Name must be between 1 and 44 characters!";
    }

    if(!Validator::validateString($parcelAddress1, 5, 44)) {
        $errors['InvalidInput']['InvalidStringAddress1'] = "Address 1 must be between 1 and 44 characters!";
    }

    if (!empty($parcelAddress2)) {
        if (!Validator::validateString($parcelAddress2, 1, 44)) {
            $errors['InvalidInput']['InvalidStringAddress2'] = "Address 2 must be between 1 and 44 characters!";
        }
    }

    if(!Validator::validateString($parcelPostcode, 3 , 7)) {
        $errors['InvalidInput']['InvalidPostcode'] = "Postcode must be between 3 and 7 characters!";
    }

    if(empty($errors))
    {
        $deliveryPointDataSet->updateParcelWithoutPhoto($parcelID, $parcelName, $parcelAddress1, $parcelAddress2, $parcelPostcode, $longitude, $latitude, $parcelDelivererID, $status);
    }
}

require_once("Controllers/Managers/show.php");
exit();
