<?php

session_start();

require_once('../include/bootstrap.php');

if (isset($_REQUEST['controller'])) {
    $controller =  new $_REQUEST['controller'];
} else {
    $controller = new HomeController();
}

