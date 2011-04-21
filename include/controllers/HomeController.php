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

        $recentlyAddedFilms = $this->filmModel->getRecentlyAdded(3);
        $recentlyAddedFilmsOutput = array();
        foreach ($recentlyAddedFilms as $film) {
            $recentSeensOP = array();
            $recentSeens = $this->seenModel->getFilmsLastSeens(1, $film, 'hasTweeview');
            foreach($recentSeens as $seen) {
                $recentSeensOP[] = array(
                    'seen' => $seen,
                    'user' => $this->userModel->getuser('id', $seen->getUserID())
                            );
            }

            $recentlyAddedFilmsOutput[] = array(
                'film' => $film,
                'averageRating' => $this->seenModel->getAverageRating($film),
                'recentSeens' => $recentSeensOP
            );
        }
        $data['recentlyAddedFilms'] = $recentlyAddedFilmsOutput;

        $recentSeensOutput = array();
        $recentSeens = $this->seenModel->getRecentSeens(10);
        foreach ($recentSeens as $seen) {
            $recentSeensOutput[] = array(
                'user' => $this->userModel->getUser('id', $seen->getUserID()),
                'film' => $this->filmModel->getFilm('id', $seen->getFilmID()),
                'seen' => $seen
            );
        }

        $data['recentlySeens'] = $recentSeensOutput;

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
