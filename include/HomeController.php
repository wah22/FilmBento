<?php

class HomeController extends Controller {
    function __construct() {
        parent::__construct();
    }

    function mainHome() {
        $data = array();

        $this->view->load('site_description_view', $data);
    }

    function index() {
        if (!LoginManager::getInstance()->userLoggedIn()) {;
            $this->mainHome();
            return;
        }


        $data = array();
        
        $data['user'] = LoginManager::getInstance()->getLoggedInUser();
        $data['films'] = array();

        $filmModel = new FilmModel();
        foreach ($filmModel->getAllFilms() as $film) {
            $user = LoginManager::getInstance()->getLoggedInUser();
            if (!$user->hasSeen($film)) {
                $data['films'][] = $film->getTitle();
            }
        }

        $this->view->load('user_home_view', $data);
    }

    function seen () {
        $filmModel = new FilmModel();

        try {
            $film = $filmModel->getFilm('title', $_POST['film']);
        } catch (Exception $e) {
                $this->couldNotFindFilm();
        }

        if (isset($film)) {

            $location = $film->getPath();
            header("Location: $location");
        }

        $this->index();
    }

    function couldNotFindFilm() {
        $this->view->load('could_not_find_film_view');
    }
}