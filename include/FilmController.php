<?php

class FilmController {

    private $model;
    private $view;

    function __construct () {
        $this->model = new FilmModel();
        $this->view = new View();

        if (isset($_GET['function'])) {
            $function = $_GET['function'];
            if (function_exists($this->$function())) {
                $this->$function();
            }
        }

        $this->index();
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

        $film = $this->model->getFilm('title', $_GET['film']);

        $user = LoginManager::getInstance()->getLoggedInUser();

        $seen = new Seen($user->getID(), $film->getID());

        $user->addToSeens($seen);

        $userModel = new UserModel();
        $userModel->save($user);
    }
}