<?php

class AddFilmController extends Controller {

    private $user;

    function  __construct() {
        parent::__construct();

        $this->user = LoginManager::getInstance()->getLoggedInUser();

        if (!LoginManager::getInstance()->userLoggedIn()) {
            throw new Exception('User must be logged in');
        }
    }

    function index() {
        $data = array();

        $this->view->load('add_film_view', $data);
    }

    function addFilm() {
        if (empty($_POST['title'])) {
            $this->index();
            return;
        }
        $filmModel = new FilmModel();

        $film = $filmModel->getFilm('title', $_POST['title']);

        if ($film) {
            $location = $film->getPath();
            header("Location: $location");
        }
        
        $filmModel->save($film);

        $location = "Location: " . $film->getPath();

        header($location);
    }
}