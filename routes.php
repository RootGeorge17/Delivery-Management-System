<?php

if ($_SESSION['user']['usertypename'] == "Manager")
{
    $router->get('/', 'Controllers/Deliveries/index.php');

    $router->get('/deliveries', 'Controllers/Deliveries/index.php');
    $router->post('/deliveries', 'Controllers/Deliveries/show-deliveries.php');

    $router->get('/users', 'Controllers/Deliveries/index.php');
    $router->post('/users', 'Controllers/Deliveries/show-users.php');
} elseif ($_SESSION['user']['usertypename'] == "Deliverer") {

}


$router->get('/login', 'Controllers/Authentication/index.php');
$router->post('/login', 'Controllers/Authentication/store.php');
$router->get('/signout', 'Controllers/Authentication/destroy.php');
