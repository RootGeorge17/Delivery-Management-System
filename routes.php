<?php
$router->get('/', 'Controllers/Deliveries/index.php');

$router->get('/login', 'Controllers/Authentication/login.php');
$router->post('/login', 'Controllers/Authentication/store.php');

$router->get('/signout', 'Controllers/Authentication/signout.php');
