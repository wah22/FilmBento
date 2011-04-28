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
        if (!isset ($_POST['submit'])) {
            $this->index();
            return;
        }

        $errors = array();

        if (empty($_POST['title']) ||
            empty($_POST['year'])) {
            $errors[] = "Please fill out required fields";
        }

        if (empty($errors)) {
            $film = $this->filmModel->getFilm('title', $_POST['title']);

            $title = $_POST['title'];
            $year = $_POST['year'];
            
            if ($film) {
                if ($film->getYear() == $year) {
                    $location = $film->getPath();
                    header("Location: $location");
                    return;
                }
            }

            $film = new Film();
            $film->setTitle($title);
            $film->setYear($year);
            $film->setUserWhoAddedID($this->user->getID());

            $this->filmModel->create($film);

            $film = $this->filmModel->getFilm('title', $title);

            $film->setMeta('poster_link', $_POST['poster_url']);
            $film->setMeta('hashtag', $_POST['hashtag']);
            $film->setMeta('wiki_link', $_POST['wiki_link']);
            $film->setMeta('rt_link', $_POST['rt_link']);
            $film->setMeta('imdb_link', $_POST['imdb_link']);
            $film->setMeta('metacritic_link', $_POST['metacritic_link']);
            
            $this->filmModel->save($film);

            $location = "Location: " . $film->getPath();
            header($location);
        } else {
            $data['errors'] = $errors;
            $this->view->load('add_film_view', $data);
        }
    }
}
