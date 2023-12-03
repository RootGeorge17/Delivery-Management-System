<?php
$view = new stdClass();
$view->pageTitle = 'Dashboard';

if (!authenticated()) {
    header('location: /login');
    exit();
}

require_once("Controllers/Managers/show.php");
exit();





