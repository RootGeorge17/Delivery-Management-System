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

function logout()
{
    $_SESSION = [];
    session_destroy();

    $params = session_get_cookie_params();
    setcookie("PHPSESSID", '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

function authenticated(): bool
{
    if (isset($_SESSION['user']['loggedIn']))
    {
        return true;
    } else {
        return false;
    }
}
