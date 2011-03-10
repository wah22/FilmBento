<?php

class HomeController extends Controller {
    function __construct() {
        parent::__construct();

        if (LoginManager::getInstance()->userLoggedIn()) {;
            $this->userHome();
        } else {
            $this->mainHome();
        }
    }

    function mainHome() {
        $data = array();

        $this->view->load('site_description_view', $data);
    }

    function userHome() {
        $data = array();
        
        $data['user'] = LoginManager::getInstance()->getLoggedInUser();
        $data['films'] = array();

        $filmModel = new FilmModel();
        foreach ($filmModel->getAllFilms() as $film) {
            $user = LoginManager::getInstance()->getLoggedInUser();
            if (!$user->hasSeen($film)) {
                $data['films'][] = $film->getTitle();
            }
        }

        $this->view->load('user_home_view', $data);
    }

    function seen () {
        $filmModel = new FilmModel();

        $film = $filmModel->getFilm('title', $_POST['film']);

        if ($film) {
   
            $seen = new Seen(LoginManager::getInstance()->getLoggedInUser()->getID(), $film->getID());

            $user = LoginManager::getInstance()->getLoggedInUser();

            $user->addToSeens($seen);

            $userModel = new UserModel();

            $userModel->save($user);
        }
    }

}