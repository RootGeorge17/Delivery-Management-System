<?php
$routes = require_once("routes.php");

// Function to route the request to the appropriate controller
function routeToController($uri, $routes) {
    // Check if the requested path exists in the routes array
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri]; // If a match is found, require the corresponding controller file
    } else {
        abort(); // If no match is found, abort with a 404 error
    }
}

// Function to handle error responses
function abort($code = 404) {
    http_response_code($code); // Set the HTTP response code (default is 404, but can be customized)

    require "Views/{$code}.php"; // Include the corresponding error view based on the provided code

    die(); // Terminate script execution to prevent further processing
}

$uri = parse_url($_SERVER['REQUEST_URI'])['path']; // Extract the path component from the current request's URI

routeToController($uri, $routes); // Route the request using the extracted $uri and the defined $routes