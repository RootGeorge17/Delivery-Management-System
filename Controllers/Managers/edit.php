<?php
// Requiring necessary classes
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');
require_once('Models/Core/Validator.php');

// Creating instances of classes
$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();
$errors = [];

// Handling assign deliverer post request
if ($_POST['type'] == 'AssignDeliverer') {
    // Retrieving username, id from the form submission
    $assignedDeliverer = $_POST['username'];
    $parcelID = $_POST['_id'];

    // Checking if the assigned Deliverer exists, then assigning them to the Parcel
    if ($deliveryUserDataSet->checkUserExists($assignedDeliverer)) {
        $deliveryPointDataSet->assignDeliverer($parcelID, $assignedDeliverer);
    } else {
        // If doesn't exist, throw error
        $errors['InvalidInput']['InvalidUsername'] = "Username Not Found. Try again!";
    }

    // Handling edit user post request
} elseif ($_POST["type"] == "EditUser") {
    // Retrieving username, password, id from the form submission
    $delivererUsername = $_POST['username'];
    $delivererPassword = $_POST['password'];
    $delivererID = $_POST['_id'];

    // Validating username and password
    if (!Validator::validateString($delivererUsername, 1, 44)) {
        $errors['InvalidInput']['InvalidStringUsername'] = "UserName must be between 1 and 44 characters!";
    }

    if (!Validator::validateString($delivererPassword, 5, 44)) {
        $errors['InvalidInput']['InvalidStringPassword'] = "Password must be between 5 and 44 characters!";
    }

    // Retrieving previous username
    $previousUsername = $deliveryUserDataSet->getUsername($delivererID);

    // Checking for duplicate username, throwing an error if there is a duplicate
    if ($deliveryUserDataSet->checkUserExists($delivererUsername) && $previousUsername != $delivererUsername) {
        $errors['InvalidInput']['DuplicateUsername'] = "User with the same username already exists!";
    }

    if (empty($errors)) {
        // Updating user information if no errors
        if (!$_POST['password'] == null) {
            $deliveryUserDataSet->updateDeliverer($delivererID, $delivererUsername, $delivererPassword);
        } else {
            $deliveryUserDataSet->updateDelivererNoPassword($delivererID, $delivererUsername);
        }
    }
} elseif ($_POST["type"] == "EditParcel") {
    // Retrieving information from the form submission
    $parcelID = $_POST['_id'];
    $parcelName = $_POST['name'];
    $parcelAddress1 = $_POST['address1'];
    $parcelAddress2 = $_POST['address2'] ?? '';
    $parcelPostcode = $_POST['postcode'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $parcelDeliverer = $_POST['deliverer'];
    $parcelStatus = $_POST['status'];

    $status = ParcelText($parcelStatus); // Get status id based on status text

    // Validating and checking if the deliverer exists else getting its id from the username
    if (!$deliveryUserDataSet->checkUserExists($parcelDeliverer)) {
        $errors['InvalidInput']['InvalidUsername'] = "Invalid deliverer. Try again! ";
    } else {
        $parcelDelivererID = $deliveryUserDataSet->getUserID($parcelDeliverer);
    }

    // Validating latitude, longitude, and other parcel details
    if (!Validator::isNumeric($latitude) || !Validator::isNumeric($longitude)) {
        $errors['InvalidInput']['NotIntegers'] = "Latitude and longitude must be integers!";
    }

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

    // If no errors, update the parcel information
    if (empty($errors)) {
        $deliveryPointDataSet->updateParcelWithoutPhoto($parcelID, $parcelName, $parcelAddress1, $parcelAddress2, $parcelPostcode, $longitude, $latitude, $parcelDelivererID, $status);
    }
}

// After processing, require the show.php controller for Managers
require_once("Controllers/Managers/show.php");
exit();
