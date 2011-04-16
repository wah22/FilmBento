<?php

/*
 * The controller for the user's "Lists" page
 */
class ListController extends PrivateController implements Linkable{

    function __construct() {
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
                    'title' => $film->getTitle(),
                    'path' =>$film->getPath()
                );
                $filmsArray[] = $filmArray;
            }

            $listArray = array(
                'id' => $list->getID(),
                'name' => $list->getName(),
                'films' => $filmsArray,
                'maxEntries' => $list->getMaxEntries()
            );
            $data['lists'][] = $listArray;
        }

        $this->view->load('list_index_view', $data);
    }

    function add() {
        $allLists = array();
        foreach ($this->listModel->getAllLists() as $list) {
            if (!$this->listModel->listActive($this->user, $list)) {
                $user = $this->userModel->getUser('id', $list->getCreatedByID());
                $allLists[] = array(
                    'list' => $list,
                    'createdBy' => $user
                );
            }
        }
        $data['lists'] = $allLists;

        $this->view->load('add_list_view', $data);
    }

    function create() {
        if(isset($_POST['submit']) && !empty($_POST['name'])) {
            $list = $this->listModel->create($_POST['name'], $_POST['maxEntries'], $_POST['description'], $this->user->getID());
            $this->listModel->activateList($this->user, $list);
            $this->index();
            return;
        }
        $this->view->load('create_list_view');
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

        if (!$film) {
            $this->view->load('could_not_find_film_view');
            return;
        }

        $list = $this->listModel->getList($this->user, $_REQUEST['list']);
        $list->addEntry($film->getID());
        $this->listModel->save($list);

        $this->index();
    }

    function removeFromList() {
        $user = LoginManager::getInstance()->getLoggedInUser();

        $list = $this->listModel->getList($user, $_REQUEST['list']);

        $list->remove($_REQUEST['film']);
        
        $this->listModel->save($list);

        $this->index();
    }

    function activateList() {
        if (isset($_GET['list'])) {
            $list = $this->listModel->getList($this->user, $_GET['list']);
            $this->listModel->activateList($this->user, $list);
        }
        header ('Location:' . $this->getPath());
    }

    function deactivateList() {
        if (isset($_GET['list'])) {
            $list = $this->listModel->getList($this->user, $_GET['list']);
            $this->listModel->deactivateList($this->user, $list);
        }
        header ('Location:' . $this->getPath());
    }

    function getPath() {
        $path = '/lists';
        return $path;
    }
}