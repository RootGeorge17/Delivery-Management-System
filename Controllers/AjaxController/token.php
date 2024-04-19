<?php

/**
 * PHP script to handle token generation and response for AJAX Transactions
 */

// Checks if the user's AJAX token is set in the session
if (isset($_SESSION['user']['ajaxToken'])) {
    $token = $_SESSION['user']['ajaxToken'];
    $response = array('token' => $token);
    echo json_encode($response); // If set, it encodes the token as a JSON response.
} else {
    // If not set, it returns a 401 Unauthorized status code.
    http_response_code(401);
}
