<?php

class Controller {

    protected $view;

    function __construct() {
        $this->view = new View();

        if (isset($_REQUEST['function'])) {
            $this->$_REQUEST['function']();
        } else {
            $this->index();
        }
    }

    function logOut() {
        LoginManager::getInstance()->logOut();

        header("Location: /");
    }
}