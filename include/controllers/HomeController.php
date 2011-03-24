<?php

class HomeController extends Controller {
    
    function __construct() {
        parent::__construct();
    }

    /*
     * If a user is not logged in they will be shown the main home page
     * Logged in users will be shown their own home page
     */
    function index() {
        if (!LoginManager::getInstance()->userLoggedIn()) {;
            $this->mainHome();
            return;
        }

        $data = array();
        $data['user'] = LoginManager::getInstance()->getLoggedInUser();
        $this->view->load('user_home_view', $data);
    }

    /*
     * The page shown if a user is not logged in
     */
    function mainHome() {
        $this->view->load('site_description_view');
    }

    /*
     * Called when a user enters a film into the "what have you seen?" field
     * if the film exists it takes the user to that film's page
     * if not it loads the "huh?" page
     */
    function seen () {
        $filmModel = new FilmModel();

        $film = $filmModel->getFilm('title', $_POST['film']);

        if ($film) {
            $location = $film->getPath();
            header("Location: $location");
        } else {
             $this->view->load('could_not_find_film_view');
        }
    }
}
