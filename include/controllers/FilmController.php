<?php

class FilmController extends Controller{

    private $film;

    function __construct() {
        $filmModel = new FilmModel();
        $this->film = $filmModel->getFilm('title', $_GET['film']);
        parent::__construct();
    }

    function index() {
        $data = array(
            'film' => $this->film
        );

        $user = LoginManager::getInstance()->getLoggedInUser();
        $data['user'] = $user;

        if ($user && $this->seenModel->userHasSeen($user, $this->film)) {
            $seen = $this->seenModel->getSeen($user, $this->film);
            $data['hasSeen'] = true;
            $data['whenSeen'] = $seen->whenSeen();
            $data['tweeview'] = $seen->getTweeview();
        } else {
            $data['hasSeen'] = false;
        }

        if ($user && $this->seenModel->userHasRated($user, $this->film)) {
            $data['hasRated'] = true;
            $rating = $seen->getRating();
            $data['rating'] = $rating;
        } else {
            $data['hasRated'] = false;
        }

        $lastSeens = $this->seenModel->getFilmsLastSeens(10, $this->film);

        $lastSeensArray = array();
        foreach ($lastSeens as $lastSeen) {
            $user = $this->userModel->getUser('id', $lastSeen->getUserID());
            $lastSeenArray = array(
                'user' => $user->getHandle(),
                'path' => $user->getPath(),
                'rating' =>$lastSeen->getRating(),
                'tweeview' => $seen->getTweeview()
            );
            $lastSeensArray[] = $lastSeenArray;
        }

        $data['recentlySeens'] = $lastSeensArray;

        $userWhoAdded = $this->userModel->getUser('id', $this->film->getUserWhoAddedId());
        $data['addedBy'] = $userWhoAdded;

        $this->view->load('film_view', $data);
    }

    function seen () {
        if(empty($_POST['film']) || !LoginManager::getInstance()->userLoggedIn()) {
            $this->index();
            return;
        }
       
        $user = LoginManager::getInstance()->getLoggedInUser();

        if ($this->seenModel->userHasSeen($user, $this->film)) {
            $this->index();
            return;
        }

        $user = LoginManager::getInstance()->getLoggedInUser();
        $seen = new Seen($user->getID(), $this->film->getID(), 0, time());

        $this->seenModel->create($seen);

        $this->index();
    }

    function unsee() {
        if(empty($_POST['film']) || !LoginManager::getInstance()->userLoggedIn()) {
            $this->index();
            return;
        }

        $user = LoginManager::getInstance()->getLoggedInUser();
        $seen = $this->seenModel->getSeen($user, $this->film);

        $this->seenModel->delete($seen);

        $this->index();
    }

    function rate () {
        if (empty($_POST['rating'])) {
            $this->index();
            return;
        }

        $user = LoginManager::getInstance()->getLoggedInUser();

        $rating = $_POST['rating'];

        $seen = $this->seenModel->getSeen($user, $this->film);
        $seen->setRating($rating);
        $this->seenModel->save($seen);

        $this->index();
    }

    function tweeview () {
        if (empty($_POST['tweeview'])) {
            $this->index();
            return;
        }

        $user = LoginManager::getInstance()->getLoggedInUser();

        $tweeview = $_POST['tweeview'];

        $seen = $this->seenModel->getSeen($user, $this->film);
        $seen->setTweeview($tweeview);
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

    function edit() {
        if (isset($_POST['year'])) {
            $this->film->setyear($_POST['year']);
            $this->filmModel->save($this->film);
        }

        if (!empty($_POST['altTitle'])) {
            $this->film->setMeta('alt_title', $_POST['altTitle']);
        }

        if (!empty($_POST['posterLink'])) {
            $this->film->setMeta('poster_link', $_POST['posterLink']);
        }

        if (!empty($_POST['wikiLink'])) {
            $this->film->setMeta('wiki_link', $_POST['wikiLink']);
        }

        if (!empty($_POST['rtLink'])) {
            $this->film->setMeta('rt_link', $_POST['rtLink']);
        }

        if (!empty($_POST['imdbLink'])) {
            $this->film->setMeta('imdb_link', $_POST['imdbLink']);
        }

        if (!empty($_POST['metacriticLink'])) {
            $this->film->setMeta('metacritic_link', $_POST['metacriticLink']);
        }

        if (!empty($_POST['hashtag'])) {
            $this->film->setMeta('hashtag', $_POST['hashtag']);
        }

        if (isset($_POST['submit'])) {
            $this->filmModel->save($this->film);
            header('Location:' . $this->film->getPath());
        }

        $data = array (
            'film' => $this->film
        );

        $this->view->load('edit_film_view', $data);
    }
}
