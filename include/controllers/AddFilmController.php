<?php

class AddFilmController extends PrivateController {

    function  __construct() {
        if (!LoginManager::getInstance()->userLoggedIn()) {
            $this->redirectToLogin();
        }

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
        if (empty($_POST['title']) || empty($_POST['year'])) {
            $this->index();
            return;
        }
        $filmModel = new FilmModel();

        $film = $filmModel->getFilm('title', $_POST['title']);

        if ($film) {
            $location = $film->getPath();
            header("Location: $location");
        } else {
            $film = new Film();
            $film->setTitle($_POST['title']);
            $film->setYear($_POST['year']);

            $filmModel->save($film);

            $location = "Location: " . $film->getPath();

            header($location);
        }
    }
}