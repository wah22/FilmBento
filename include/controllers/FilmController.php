<?php

class FilmController extends Controller{

    function __construct () {
        parent::__construct();
    }

    function index() {
        if (isset($_GET['film'])) {
            $film = $this->filmModel->getFilm('title', $_GET['film']);
            $data = array(
                'film' => $film
            );

            $user = LoginManager::getInstance()->getLoggedInUser();
            $data['user'] = $user;

            if ($this->seenModel->userHasSeen($user, $film)) {
                $seen = $this->seenModel->getSeen($user, $film);

                $data['hasSeen'] = true;
                $data['whenSeen'] = $seen->whenSeen();
            } else {
                $data['hasSeen'] = false;
            }

            if ($this->seenModel->userHasRated($user, $film)) {
                $data['hasRated'] = true;
                $rating = $seen->getRating();
                $data['rating'] = $rating;
            } else {
                $data['hasRated'] = false;
            }

            $lastSeens = $this->seenModel->getFilmsLastSeens(10, $film);

            $lastSeensArray = array();
            foreach ($lastSeens as $lastSeen) {
                $user = $this->userModel->getUser('id', $lastSeen->getUserID());
                $lastSeenArray = array(
                    'user' => $user->getHandle(),
                    'path' => $user->getPath()
                );
                $lastSeensArray[] = $lastSeenArray;
            }

            $data['recentlySeens'] = $lastSeensArray;

            $this->view->load('film_view', $data);
        }
    }

    function seen () {
        if(empty($_POST['film']) || !LoginManager::getInstance()->userLoggedIn()) {
            $this->index();
            return;
        }
       
        $film = $this->filmModel->getFilm('id', $_POST['film']);
        $user = LoginManager::getInstance()->getLoggedInUser();

        if ($this->seenModel->userHasSeen($user, $film)) {
            $this->index();
            return;
        }

        $user = LoginManager::getInstance()->getLoggedInUser();
        $seen = new Seen($user->getID(), $film->getID());

        $this->seenModel->create($seen);

        $this->index();
    }

    function unsee() {
        if(empty($_POST['film']) || !LoginManager::getInstance()->userLoggedIn()) {
            $this->index();
            return;
        }

        $user = LoginManager::getInstance()->getLoggedInUser();
        $film = $this->filmModel->getFilm('id', $_POST['film']);
        $seen = $this->seenModel->getSeen($user, $film);

        $this->seenModel->delete($seen);

        $this->index();
    }

    function rate () {
        if (empty($_POST['rating'])) {
            $this->index();
            return;
        }

        $film = $this->filmModel->getFilm('id', $_POST['film']);

        $user = LoginManager::getInstance()->getLoggedInUser();

        $rating = $_POST['rating'];

        $seen = $this->seenModel->getSeen($user, $film);
        $seen->setRating($rating);
        $this->seenModel->save($seen);

        $this->index();
    }

    function searchSeens() {
        if ( ! isset($_GET['query']) || empty($_GET['query'])
                || ! isset($_GET['user']) || empty($_GET['user'] )) {
            return false;
        }

        $films = $filmModel->searchSeens($_GET['user'], urldecode($_GET['query']));

        $results = array();
        foreach($films as $film) {
            $results[] = $film->getTitle();
        }

        $json = json_encode((object)$results);
        echo $json;
    }
}
