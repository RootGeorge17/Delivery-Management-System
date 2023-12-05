<?php
// Starting a PHP session
session_start();

// Requiring Router Files to route user
require_once('Models/Core/Router.php');
use Core\Router;

require_once('functions.php'); // Including functions file
require_once('Models/Core/Constants.php'); // Including Constants file

// Creating an instance of the Router class
$router = new Router();

// Retrieving defined routes from routes.php file
$routes = require ('routes.php');

// Parsing the requested URI and determining the request method
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

// Routing the URI and method
$router->route($uri, $method);
