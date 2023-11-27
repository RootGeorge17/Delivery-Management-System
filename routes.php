<?php
$router->get('/', 'Controllers/Deliveries/index.php');
$router->post('/', 'Controllers/Deliveries/show.php');

$router->get('/login', 'Controllers/Authentication/index.php');
$router->post('/login', 'Controllers/Authentication/store.php');
$router->get('/signout', 'Controllers/Authentication/destroy.php');
