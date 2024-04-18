<?php
// Requiring necessary classes
require_once('Models/Deliveries/DeliveryPointDataSet.php');

// Creating an instance of DeliveryPointDataSet
$deliveryPointDataSet = new DeliveryPointDataSet();

$status = $_GET['status'];
$id = $_GET['id'];
$token = $_GET['token'];

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

if($_SESSION['user']['usertypename'] == "Deliverer")
{
    if (isset($_SESSION['user']['ajaxToken'])) {
        $userToken = $_SESSION['user']['ajaxToken'];

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

if($_SESSION['user']['usertypename'] == "Manager")
{
    if (isset($_SESSION['user']['ajaxToken'])) {
        $userToken = $_SESSION['user']['ajaxToken'];

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





