<?php

session_start();

require_once('functions.php');
require_once('Models/Infrastructure/Database.php');
require_once('Models/Infrastructure/router.php'); // Last to require always

// send to login page if not logged in


