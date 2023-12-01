<?php

$router->get('/', 'Controllers/Managers/index.php');

$router->get('/deliveries', 'Controllers/Managers/index.php');
$router->post('/deliveries', 'Controllers/Managers/show.php');

$router->get('/users', 'Controllers/Managers/index.php');
$router->post('/users', 'Controllers/Managers/show.php');

$router->get('/login', 'Controllers/Authentication/index.php');
$router->post('/login', 'Controllers/Authentication/store.php');
$router->get('/signout', 'Controllers/Authentication/destroy.php');
