<?php

abstract class Controller {

    protected $view;

    function __construct() {
        $this->view = new View();

        if (isset($_REQUEST['function'])) {
            $this->$_REQUEST['function']();
        } else {
            $this->index();
        }
    }

    abstract function index();

    function redirectToLogIn() {
        header("Location: /?controller=LoginController");
    }

    function logOut() {
        LoginManager::getInstance()->logOut();

        header("Location: /");
    }
}