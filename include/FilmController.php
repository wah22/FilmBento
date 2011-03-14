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

            $data['user'] = LoginManager::getInstance()->getLoggedInUser();

            $this->view->load('film_view', $data);
        }
    }

    function seen () {

        $film = $this->model->getFilm('id', $_POST['film']);

        $user = LoginManager::getInstance()->getLoggedInUser();

        $seen = new Seen($user->getID(), $film->getID(), 0, time());

        $user->addToSeens($seen);

        $userModel = new UserModel();
        $userModel->save($user);

        $this->index();
    }

    function rate () {
        if (!isset($_POST['rating']) || empty($_POST['rating'])) {
            throw new Exception('Rating not specified');
        }

        $film = $this->model->getFilm('id', $_POST['film']);

        $user = LoginManager::getInstance()->getLoggedInUser();

        $user->setRating($film, $_POST['rating']);

        $userModel = new UserModel();
        $userModel->save($user);

        $this->index();
    }
}