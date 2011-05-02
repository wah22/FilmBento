<?php

abstract class Controller {

    protected $userModel;
    protected $filmModel;
    protected $seenModel;
    protected $listModel;

    protected $view;

    function __construct() {
        $this->userModel = new UserModel();
        $this->filmModel = new FilmModel();
        $this->seenModel = new SeenModel();
        $this->listModel = new FilmListModel();
        $this->view = new View();
    }

    abstract function index();

    function redirectToLogIn() {
        header("Location: /login");
    }

    function logOut() {
        LoginManager::getInstance()->logOut();

        header("Location: /");
    }
}
