<?php

/**
 * PHP script to handle updating the delivery status of a delivery point
 */

// Requiring necessary classes
require_once('Models/Deliveries/DeliveryPointDataSet.php');

// Creating an instance of DeliveryPointDataSet
$deliveryPointDataSet = new DeliveryPointDataSet();

// Get the new status provided by user, delivery point ID and token from the GET request
$status = $_GET['status'];
$id = $_GET['id'];
$token = $_GET['token'];

/**
 * Helper function to get the numeric status code based on the status word.
 *
 * @param string $statusWord The status word (e.g., 'Pending', 'Shipped', 'Out for delivery', 'Delivered').
 * @return string The numeric status code corresponding to the status word from the database.
 */
function getStatusNumber($statusWord) {
    if ($statusWord == 'Pending') {
        return '1';
    } elseif ($statusWord == 'Shipped') {
        return '2';
    } elseif ($statusWord == 'Out for delivery') {
        return '3';
    } elseif ($statusWord == 'Delivered') {
        return '4';
    }
}

// Handle update request for "Deliverer" user type
if($_SESSION['user']['usertypename'] == "Deliverer")
{
    if (isset($_SESSION['user']['ajaxToken'])) {
        $userToken = $_SESSION['user']['ajaxToken'];

        // Check if the provided token matches the user's token
        if (!isset($token) || $token !== $userToken) {
            $data = new stdClass();
            $data->error = "No data for you sir";
            echo json_encode($data);
            exit;
        } else {
            // Check if the status is 'delivered' or 'no_answer'
            if ($status === 'delivered' || $status === 'no_answer') {
                // Fetch the current delivery status
                $currentStatus = $deliveryPointDataSet->getDeliveryPointStatus($id);

                if ($status === 'delivered') {
                    if ($currentStatus !== '4') { // '4' represents the 'Delivered' status
                        // Update the delivery status to 'Delivered'
                        $deliveryPointDataSet->updateStatusDeliveryPoint($id, '4');
                        echo 'Status updated to "Delivered"';
                    } else {
                        echo 'Delivery is already marked as delivered';
                    }
                } elseif ($status === 'no_answer') {
                    $deliveryPointDataSet->updateStatusDeliveryPoint($id, '3');
                    echo 'Status updated to "Out for delivery"';
                }
            } else {
                echo 'Invalid status value';
            }
        }
    }
}

// Handle update request for "Manager" user type
if($_SESSION['user']['usertypename'] == "Manager")
{
    if (isset($_SESSION['user']['ajaxToken'])) {
        $userToken = $_SESSION['user']['ajaxToken'];

        // Check if the provided token matches the user's token
        if (!isset($token) || $token !== $userToken) {
            $data = new stdClass();
            $data->error = "No data for you sir";
            echo json_encode($data);
            exit;
        } else {
            $validStatuses = ['pending', 'shipped', 'out for delivery', 'delivered'];
            if (in_array(strtolower($status), $validStatuses)) {
                // Fetch the current delivery status
                $statusID = getStatusNumber($status);

                // Update the delivery status based on the new status
                $deliveryPointDataSet->updateStatusDeliveryPoint($id, $statusID);
                echo "Status updated to \"$status\"";
            } else {
                echo 'Invalid status value';
            }
        }
    }
}





