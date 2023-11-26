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
    return $_SERVER['REQUEST_URI'] === $value;
}

function login($username, $id)
{
    $_SESSION['user'] = [
        'username' => $username,
        'id' => $id
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

