<?php
$view = new stdClass();
$view->pageTitle = 'Log in';

if (!authenticated()) {
    require_once("Views/Authentication/login.phtml");
    exit();
}

header('location: /');
exit();


