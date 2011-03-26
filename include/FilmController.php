<?php

class FilmController extends Controller{

    private $model;

    function __construct () {
        $this->model = new FilmModel();
        
        parent::__construct();
    }

    function index() {
        if (isset($_GET['film'])) {
            $film = $this->model->getFilm('title', $_GET['film']);
            $data = array(
                'film' => $film
            );

            $user = LoginManager::getInstance()->getLoggedInUser();
            $data['user'] = $user;

            $seenModel = new SeenModel();

            if ($seenModel->userHasSeen($user, $film)) {
                $data['hasSeen'] = true;
            } else {
                $data['hasSeen'] = false;
            }

            if ($seenModel->userHasRated($user, $film)) {
                $data['hasRated'] = true;

                $seen = $seenModel->getSeen($user, $film);
                $rating = $seen->getRating();
                $data['rating'] = $rating;
            } else {
                $data['hasRated'] = false;
            }

            $userModel = new UserModel();

            $seenModel = new SeenModel();
            $lastSeens = $seenModel->getFilmsLastSeens(10, $film);

            $lastSeensArray = array();
            foreach ($lastSeens as $lastSeen) {
                $user = $userModel->getUser('id', $lastSeen->getUserID());
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
        if(empty($_POST['film'])) {
            $this->index();
            return;
        }
       
        $film = $this->model->getFilm('id', $_POST['film']);
        $user = LoginManager::getInstance()->getLoggedInUser();
                
        $seenModel = new SeenModel();

        if ($seenModel->userHasSeen($user, $film)) {
            $this->index();
            return;
        }

        $seen = new Seen($user->getID(), $film->getID(), 0, time());

        $seenModel->create($seen);

        $this->index();
    }

    function rate () {
        if (empty($_POST['rating'])) {
            $this->index();
            return;
        }

        $film = $this->model->getFilm('id', $_POST['film']);

        $user = LoginManager::getInstance()->getLoggedInUser();

        $rating = $_POST['rating'];

        $seenModel = new SeenModel();
        $seen = $seenModel->getSeen($user, $film);
        $seen->setRating($rating);
        $seenModel->save($seen);

        $this->index();
    }

    function searchSeens() {
        if ( ! isset($_GET['query']) || empty($_GET['query'])
                || ! isset($_GET['user']) || empty($_GET['user'] )) {
            return false;
        }

        $filmModel = new FilmModel();
        $films = $filmModel->searchSeens($_GET['user'], urldecode($_GET['query']));

        $results = array();
        foreach($films as $film) {
            $results[] = $film->getTitle();
        }

        $json = json_encode((object)$results);
        echo $json;
    }
}
