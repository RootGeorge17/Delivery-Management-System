<?php

// Used for debugging purposes, it displays information about the provided $value
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die(); // It terminates the script's execution after displaying the variable's information so that we can inspect it.
}

// This function checks if the current request's URL matches the provided $value.
function isCurrentUrl($value) {
    $requestedPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return $requestedPath === $value;
}

// Function to log in a user and store their information in a session
function login($id, $username, $usertypeid, $usertypename)
{
    $loggedIn = true;

    $_SESSION['user'] = [
        'id' => $id,
        'username' => $username,
        'usertypeid' => $usertypeid,
        'usertypename' => $usertypename,
        'loggedIn' => $loggedIn,
        'currentTable' => null
    ];

    session_regenerate_id(true);
}

// Function to log out a user by destroying the session and clearing cookies
function logout()
{
    $_SESSION = [];
    session_destroy();

    $params = session_get_cookie_params();
    setcookie("PHPSESSID", '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

// Function to check if a user is authenticated by verifying session information
function authenticated(): bool
{
    if (isset($_SESSION['user']['loggedIn']))
    {
        return true;
    } else {
        return false;
    }
}

// Function to convert a textual status to its corresponding ID
function ParcelText($value)
{
    if($value == "Pending") {
        return Constants::PENDING;
    } elseif($value == "Shipped") {
        return Constants::SHIPPED;
    } elseif($value == "Out for delivery") {
        return Constants::OUT_FOR_DELIVERY;
    } elseif ($value == "Delivered") {
        return Constants::DELIVERED;
    }
}

// Function to redirect to the root if the current page is out of range
function redirectToRootIfOutOfRange($currentPage, $totalPages) {
    if ($currentPage < 1 || $currentPage > $totalPages) {
        header("Location: /"); // Redirect to the root
        exit; // Stop further execution
    }
}

