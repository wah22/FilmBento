<?php

abstract class Controller {

    protected $userModel;
    protected $filmModel;
    protected $seenModel;

    protected $view;

    /*
     * Initiates the view,
     * if a function is specified it calls that function, if not it calls the index function
     */
    function __construct() {
        $this->userModel = new UserModel();
        $this->filmModel = new FilmModel();
        $this->seenModel = new SeenModel();

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