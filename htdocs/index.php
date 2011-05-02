<?php

session_start();

require_once('../include/bootstrap.php');

// if a controller is specified load that controller
// otherwise load the default home controller
if (isset($_REQUEST['controller'])) {
    $controller =  new $_REQUEST['controller'];
} else {
    $controller = new HomeController();
}

// if a function has been specified execute it, if not execute the default function (index())
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
    $controller->$function();
} else {
    $controller->index();
}
