<?php

class ListController {

    private $view;
    private $user;

    function __construct() {
        $this->view = new View();
        $this->user = LoginManager::getInstance()->getLoggedInUser();

        if (isset($_GET['function'])) {
            $function = $_GET['function'];
            if (function_exists($this->$function())) {
                $this->$function();
            }
        } else {
            $this->index();
        }
    }

    function index() {
        if (!LoginManager::getInstance()->userLoggedIn()) {
            throw new Exception('user not logged in');
        }

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
        $film = $filmModel->getFilm('title', $_GET['film']);

        if (!$film) {
            $this->view->load('could_not_find_film_view');
            return;
        }

        $seen = new Seen($this->user->getID(), $film->getID());
        $list = $this->user->getList($_GET['list']);
        $list->addSeen($seen);
        $userModel = new UserModel();
        $userModel->save($this->user);

        $location = "Location: /?controller=ListController&function=edit&list=" . $_GET['list'];
        header($location);
    }

    function removeFromList() {
        $this->user->getList($_GET['list'])->remove($_GET['film']);
        $userModel = new UserModel();
        $userModel->save($this->user);

        $location = "Location: /?controller=ListController&function=edit&list=" . $_GET['list'];
        header($location);
    }
}