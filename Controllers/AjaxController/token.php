<?php

if (isset($_SESSION['user']['ajaxToken'])) {
    $token = $_SESSION['user']['ajaxToken'];
    $response = array('token' => $token);
    echo json_encode($response);
} else {
    http_response_code(401);
}
