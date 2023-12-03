<?php
$view = new stdClass();
$view->pageTitle = 'Log in';

if (!authenticated()) {
    require_once('Models/Core/Antispam.php');
    $antiSpam = new AntiSpam();
    $_SESSION['antiSpamRandomBytes'] = $antiSpam::getRandomBytes();

    require_once("Views/Authentication/login.phtml");
    exit();
}

header('location: /');
exit();

