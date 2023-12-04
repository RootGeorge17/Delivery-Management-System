<?php
session_start();

require_once('Models/Core/Router.php');
use Core\Router;

require_once('functions.php');
require_once('Models/Core/Constants.php');

$router = new Router();
$routes = require ('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);