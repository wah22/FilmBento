<?php

class HomeController extends PrivateController {
    
    function __construct() {
        parent::__construct();
    }

    /*
     * Displays the users home page
     */
    function index() {
        $data = array();
        $data['user'] = LoginManager::getInstance()->getLoggedInUser();
        $data['recentlyAddedFilms'] = $this->filmModel->getRecentlyAdded(10);
        $this->view->load('user_home_view', $data);
    }

    /*
     * Called when a user enters a film into the "what have you seen?" field
     * if the film exists it takes the user to that film's page
     * if not it loads the "huh?" page
     */
    function seen () {
        $title = $_POST['film'];
        $film = $this->filmModel->getFilm('title', $title);

        if ($film) {
            $location = $film->getPath();
            header("Location: $location");
        } else {
             $this->view->load('could_not_find_film_view');
        }
    }
}
