<?php

session_start();

require_once('../include/bootstrap.php');

// if a controller is specified load that controller
// otherwise load the default home controller
if (isset($_REQUEST['controller'])) {
    $controller =  new $_REQUEST['controller'];
} else {
    if (LoginManager::getInstance()->userLoggedIn()) {
        $controller = new HomeController();
    } else {
        $controller = new SiteDescriptionController();
    }
}

