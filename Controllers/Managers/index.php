<?php
$view = new stdClass();
$view->pageTitle = 'Dashboard';

if (!authenticated()) {
    require_once("Views/Authentication/login.phtml");
    exit();
}

require_once("Controllers/Managers/show.php");
exit();





