<?php

/*
 * The controller for the user's "Lists" page
 */
class ListController extends PrivateController {

    function __construct() {
        if (!LoginManager::getInstance()->userLoggedIn()) {
            $this->redirectToLogin();
        }
        
        $this->user = LoginManager::getInstance()->getLoggedInUser();

        parent::__construct();
    }

    function index() {
        $data = array();

        $user = LoginManager::getInstance()->getLoggedInUser();
        $data['user'] = $user;

        $data['lists'] = array();

        $lists = $this->listModel->getLists($user);

        foreach ($lists as $list) {
            $filmsArray = array();

            foreach ($list->getEntries() as $entry) {
                $film = $this->filmModel->getFilm('id', $entry);
                $filmArray = array(
                    'id' => $film->getID(),
                    'title' => $film->getTitle()
                );
                $filmsArray[] = $filmArray;
            }

            $listArray = array(
                'id' => $list->getID(),
                'name' => $list->getName(),
                'films' => $filmsArray
            );
            $data['lists'][] = $listArray;
        }

        $this->view->load('list_index_view', $data);
    }

    function edit() {
        if (!isset($_GET['list'])) {
            header('Location: /');
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
        $user = LoginManager::getInstance()->getLoggedInUser();
        $list = $this->listModel->getList($user, $_GET['list']);
        $list->sort($_POST['recordsArray']);
        $this->listModel->save($list);
        echo 'sorted';
    }

    function addToList() {
        $film = $this->filmModel->getFilm('title', urldecode($_REQUEST['film']));
        $user = LoginManager::getInstance()->getLoggedInUser();

        if (!$film) {
            $this->view->load('could_not_find_film_view');
            return;
        }

        $list = $this->listModel->getList($user, $_REQUEST['list']);
        $list->addEntry($film->getID());
        $this->listModel->save($list);

        print_r($list);

        $this->index();
    }

    function removeFromList() {
        $user = LoginManager::getInstance()->getLoggedInUser();

        $list = $this->listModel->getList($user, $_REQUEST['list']);

        $list->remove($_REQUEST['film']);
        
        $this->listModel->save($list);

        $this->index();
    }
}