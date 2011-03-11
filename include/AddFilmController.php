<?php

class AddFilmController {

    private $view;
    private $user;

    function  __construct() {
        $this->view = new View();
        $this->user = LoginManager::getInstance()->getLoggedInUser();

        if (!LoginManager::getInstance()->userLoggedIn()) {
            throw new Exception('User must be logged in');
        }

        if (isset($_POST['function']) && $_POST['function'] == 'addFilm') {
            $this->addFilm();
        } else {
             $this->index();
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

        $film = new Film();
        $film->setTitle($_POST['title']);

        $filmModel = new FilmModel();
        if ($filmModel->filmExists($film)) {
            throw new Exception('that film already exists');
        }
        $filmModel->save($film);

        $location = $film->getPath();

        echo $location;
    }
}