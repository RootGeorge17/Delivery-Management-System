<?php

$router->get('/', 'Controllers/Deliveries/index.php');
$router->get('/deliveries', 'Controllers/Deliveries/index.php');
$router->get('/deliverers', 'Controllers/Deliveries/index.php');
$router->post('/deliveries', 'Controllers/Deliveries/show-deliveries.php');
$router->post('/deliverers', 'Controllers/Deliveries/show-users.php');

$router->get('/login', 'Controllers/Authentication/index.php');
$router->post('/login', 'Controllers/Authentication/store.php');
$router->get('/signout', 'Controllers/Authentication/destroy.php');
