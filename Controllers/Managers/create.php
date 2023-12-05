<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');
require_once('Models/Core/Validator.php');

$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();
$errors = [];

if ($_POST['type'] == 'Deliverer') {
    $delivererUsername = $_POST['username'];
    $delivererPassword = $_POST['password'];
    $delivererUserType = 2;

    if (!Validator::validateString($delivererUsername, 1, 44)) {
        $errors['InvalidInput']['InvalidStringUsername'] = "UserName must be between 1 and 44 characters!";
    }

    if (!Validator::validateString($delivererPassword, 5, 44)) {
        $errors['InvalidInput']['InvalidStringPassword'] = "Password must be between 5 and 44 characters!";
    }

    if ($deliveryUserDataSet->checkUserExists($delivererUsername)) {
        $errors['InvalidInput']['DuplicateUsername'] = "User with the same username already exists!";
    }

    if (empty($errors)) {
        $deliveryUserDataSet->createDeliverer($delivererUsername, $delivererPassword, $delivererUserType);
    }
} elseif ($_POST['type'] == 'Parcel') {
    $parcelName = $_POST['name'];
    $parcelAddress1 = $_POST['address1'];
    $parcelAddress2 = $_POST['address2'] ?? '';
    $parcelPostcode = $_POST['postcode'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $parcelDeliverer = $_POST['deliverer'];
    $parcelStatus = $_POST['status'];

    $status = ParcelText($parcelStatus);

    if (!Validator::validateString($parcelName, 1, 44)) {
        $errors['InvalidInput']['InvalidStringName'] = "Name must be between 1 and 44 characters!";
    }

    if (!Validator::validateString($parcelAddress1, 5, 44)) {
        $errors['InvalidInput']['InvalidStringAddress1'] = "Address 1 must be between 5 and 44 characters!";
    }

    if (!empty($parcelAddress2)) {
        if (!Validator::validateString($parcelAddress2, 5, 44)) {
            $errors['InvalidInput']['InvalidStringAddress2'] = "Address 2 must be between 5 and 44 characters!";
        }
    }

    if (!Validator::validateString($parcelPostcode, 3, 7)) {
        $errors['InvalidInput']['InvalidPostcode'] = "Postcode must be between 3 and 7 characters!";
    }

    if (!Validator::isNumeric($latitude) || !Validator::isNumeric($longitude)) {
        $errors['InvalidInput']['NotIntegers'] = "Latitude and longitude must be float numbers!";
    }

    if (!$deliveryUserDataSet->checkUserExists($parcelDeliverer)) {
        $errors['InvalidInput']['InvalidUsername'] = "Invalid deliverer. Try again! ";
    }

    if (empty($errors)) {
        $deliveryPointDataSet->createParcel($parcelName, $parcelAddress1, $parcelAddress2, $parcelPostcode, $longitude, $latitude, $parcelDeliverer, $status);
    }
}

require_once("Controllers/Managers/show.php");
exit();