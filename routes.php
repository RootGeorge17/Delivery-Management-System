<?php
// Define routes for authentication: login, logout
$router->get('/login', 'Controllers/Authentication/index.php');
$router->post('/login', 'Controllers/Authentication/store.php');
$router->get('/signout', 'Controllers/Authentication/destroy.php');

$router->get('/token', 'Controllers/AjaxController/token.php');

// Define routes based on user type if the user is logged in and has a user type set
if (authenticated()) {
    // Routes for Manager role
    if ($_SESSION['user']['usertypename'] == "Manager") {
        $router->get('/', 'Controllers/Managers/index.php');
        $router->post('/', 'Controllers/Managers/show.php');
        $router->edit('/', 'Controllers/Managers/edit.php');
        $router->delete('/', 'Controllers/Managers/delete.php');;
        $router->create('/', 'Controllers/Managers/create.php');;
        $router->search('/', 'Controllers/Managers/search.php');;
        $router->filterAndOrder('/', 'Controllers/Managers/search.php');;

        $router->get('/users', 'Controllers/Managers/index.php');
        $router->post('/users', 'Controllers/Managers/show.php');
        $router->edit('/users', 'Controllers/Managers/edit.php');
        $router->delete('/users', 'Controllers/Managers/delete.php');;
        $router->create('/users', 'Controllers/Managers/create.php');;
        $router->search('/users', 'Controllers/Managers/search.php');;
        $router->filterAndOrder('/', 'Controllers/Managers/search.php');;

        // AJAX CONTROLLERS
        $router->get('/livesearch', 'Controllers/AjaxController/livesearch.php');
        $router->get('/map', 'Controllers/AjaxController/deliveryPoints.php');
        $router->get('/point', 'Controllers/AjaxController/deliveryPoint.php');
        $router->get('/point', 'Controllers/AjaxController/deliveryPoint.php');
        $router->get('/update', 'Controllers/AjaxController/updateDeliveryStatus.php');

    } elseif ($_SESSION['user']['usertypename'] == "Deliverer") {
        // Routes for Deliverer role
        $router->get('/', 'Controllers/Deliverers/index.php');
        $router->post('/', 'Controllers/Deliverers/show.php');
        $router->search('/', 'Controllers/Deliverers/search.php');;
        $router->filterAndOrder('/', 'Controllers/Managers/search.php');;

        // AJAX CONTROLLERS
        $router->get('/livesearch', 'Controllers/AjaxController/livesearch.php');
        $router->get('/map', 'Controllers/AjaxController/deliveryPoints.php');
        $router->get('/point', 'Controllers/AjaxController/deliveryPoint.php');
        $router->get('/update', 'Controllers/AjaxController/updateDeliveryStatus.php');
    }
} else {
    $router->get('/', 'Controllers/Authentication/index.php');
}


