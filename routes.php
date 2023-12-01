<?php

$router->get('/', 'Controllers/Managers/index.php');
$router->post('/', 'Controllers/Managers/show.php');
$router->patch('/', 'Controllers/Managers/update.php');;

$router->get('/deliveries', 'Controllers/Managers/index.php');
$router->post('/deliveries', 'Controllers/Managers/show.php');
$router->patch('/deliveries', 'Controllers/Managers/update.php');;

$router->get('/users', 'Controllers/Managers/index.php');
$router->post('/users', 'Controllers/Managers/show.php');
$router->patch('/users', 'Controllers/Managers/update.php');;

$router->get('/login', 'Controllers/Authentication/index.php');
$router->post('/login', 'Controllers/Authentication/store.php');
$router->get('/signout', 'Controllers/Authentication/destroy.php');
