<?php

class ListController extends Controller {
    
    private $user;

    function __construct() {
        if (!LoginManager::getInstance()->userLoggedIn()) {
            $this->redirectToLogin();
        }
        
        $this->user = LoginManager::getInstance()->getLoggedInUser();

        parent::__construct();
    }

    function index() {
        $data = array();

        $data['lists'] = array();

        $user = LoginManager::getInstance()->getLoggedInUser();

        $data['user'] = $user;

        $this->view->load('list_index_view', $data);
    }

    function edit() {
        if (!isset($_GET['list'])) {
            throw new Exception('a list must be specified');
        }

        $data = array();

        $data['user'] = $this->user;
        $data['list'] = $this->user->getList($_GET['list']);

        $data['films'] = array();
        $filmModel = new FilmModel();
        $films = $filmModel->getAllFilms();
        foreach ($films as $film) {
            if (! $data['list']->hasFilm($film) && $this->user->hasSeen($film)) {
                $data['films'][] = $film->getTitle();
            }
        }

        $this->view->load('list_edit_view', $data);
    }

    function sort() {
        $list = $this->user->getList($_GET['list']);
        $list->sort($_POST['recordsArray']);

        $userModel = new UserModel();
        $userModel->save($this->user);
    }

    function addToList() {
        $filmModel = new FilmModel();
        $film = $filmModel->getFilm('title', urldecode($_GET['film']));

        if (!$film) {
            $this->view->load('could_not_find_film_view');
            return;
        }

        $seen = $this->user->getSeen($film);
        $list = $this->user->getList($_GET['list']);
        $list->addSeen($seen);
        $userModel = new UserModel();
        $userModel->save($this->user);
    }

    function removeFromList() {
        $this->user->getList($_GET['list'])->remove($_GET['film']);
        $userModel = new UserModel();
        $userModel->save($this->user);
    }
}