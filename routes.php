<?php

$router->get('/', 'Controllers/Managers/index.php');
$router->post('/', 'Controllers/Managers/show.php');
$router->edit('/', 'Controllers/Managers/edit.php');
$router->update('/', 'Controllers/Managers/update.php');;
$router->delete('/', 'Controllers/Managers/delete.php');;

$router->get('/users', 'Controllers/Managers/index.php');
$router->post('/users', 'Controllers/Managers/show.php');
$router->delete('/users', 'Controllers/Managers/delete.php');;

$router->get('/login', 'Controllers/Authentication/index.php');
$router->post('/login', 'Controllers/Authentication/store.php');
$router->get('/signout', 'Controllers/Authentication/destroy.php');
