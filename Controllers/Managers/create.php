<?php
// Requiring necessary classes
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');
require_once('Models/Core/Validator.php');

// Creating instances of classes
$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();
$errors = [];

// Handling form submission based on creation type
if ($_POST['type'] == 'Deliverer') {
    // Handling data for a Deliverer type
    $delivererUsername = $_POST['username'];
    $delivererPassword = $_POST['password'];
    $delivererUserType = 2;

    // Validating username and password
    if (!Validator::validateString($delivererUsername, 1, 44)) {
        $errors['InvalidInput']['InvalidStringUsername'] = "UserName must be between 1 and 44 characters!";
    }

    if (!Validator::validateString($delivererPassword, 5, 44)) {
        $errors['InvalidInput']['InvalidStringPassword'] = "Password must be between 5 and 44 characters!";
    }

    // Checking if the user already exists
    if ($deliveryUserDataSet->checkUserExists($delivererUsername)) {
        $errors['InvalidInput']['DuplicateUsername'] = "User with the same username already exists!";
    }

    // If no errors, create a new Deliverer
    if (empty($errors)) {
        $deliveryUserDataSet->createDeliverer($delivererUsername, $delivererPassword, $delivererUserType);
    }
} elseif ($_POST['type'] == 'Parcel') {
    // Handling data for a Parcel type
    // Retrieving data from the form
    $parcelName = $_POST['name'];
    $parcelAddress1 = $_POST['address1'];
    $parcelAddress2 = $_POST['address2'] ?? '';
    $parcelPostcode = $_POST['postcode'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $parcelDeliverer = $_POST['deliverer'];
    $parcelStatus = $_POST['status'];

    // Validating parcel name and parcel addresses
    if (!Validator::validateString($parcelName, 1, 44)) {
        $errors['InvalidInput']['InvalidStringName'] = "Name must be between 1 and 44 characters!";
    }

    if (!Validator::validateString($parcelAddress1, 5, 44)) {
        $errors['InvalidInput']['InvalidStringAddress1'] = "Address 1 must be between 5 and 44 characters!";
    }

    // Checking and validating Address 2
    if (!empty($parcelAddress2)) {
        if (!Validator::validateString($parcelAddress2, 5, 44)) {
            $errors['InvalidInput']['InvalidStringAddress2'] = "Address 2 must be between 5 and 44 characters!";
        }
    }

    // Validating Postcode, Latitude, Longitude
    if (!Validator::validateString($parcelPostcode, 3, 7)) {
        $errors['InvalidInput']['InvalidPostcode'] = "Postcode must be between 3 and 7 characters!";
    }

    if (!Validator::isNumeric($latitude) || !Validator::isNumeric($longitude)) {
        $errors['InvalidInput']['NotIntegers'] = "Latitude and longitude must be float numbers!";
    }

    // Checking if the deliverer already exists or not
    if (!$deliveryUserDataSet->checkUserExists($parcelDeliverer)) {
        $errors['InvalidInput']['InvalidUsername'] = "Invalid deliverer. Try again! ";
    }

    // If no errors, create a new Parcel
    if (empty($errors)) {
        $deliveryPointDataSet->createParcel($parcelName, $parcelAddress1, $parcelAddress2, $parcelPostcode, $longitude, $latitude, $parcelDeliverer, $parcelStatus);
    }
}

// After processing, require the show.php controller for Managers
require_once("Controllers/Managers/show.php");
exit();
