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
        
        $this->view->load('user_home_view', $data);
    }

    function seen () {
        $filmModel = new FilmModel();

        $film = $filmModel->getFilm('title', $_POST['film']);

        if ($film) {
            $location = $film->getPath();
            header("Location: $location");
        } else {
            $this->couldNotFindFilm();
            return;
        }

        $this->index();
    }

    function couldNotFindFilm() {
        $this->view->load('could_not_find_film_view');
    }
}
