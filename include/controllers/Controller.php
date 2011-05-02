<?php

/**
* Controller
* The Base Controller class.
*/

abstract class Controller {

    // Each controller has a number of models loaded by default.
    // The models provide access to the database and handle the business logic of the application.
    protected $userModel;
    protected $filmModel;
    protected $seenModel;
    protected $listModel;

    // Each controller contains an instance of the View class that handles displaying the html pages.
    protected $view;

    // The constructor simply instantiates the models and view.
    function __construct() {
        $this->userModel = new UserModel();
        $this->filmModel = new FilmModel();
        $this->seenModel = new SeenModel();
        $this->listModel = new FilmListModel();
        $this->view = new View();
    }

    // The index() function is required by all children of the Controller class.
    // index() is called by default by index.php if no function has been specified.
    abstract function index();

    //sends the user to the login page
    function redirectToLogIn() {
        header("Location: /login");
    }

    // logs the user out and redirects to the home page
    function logOut() {
        LoginManager::getInstance()->logOut();
        header("Location: /");
    }
}
