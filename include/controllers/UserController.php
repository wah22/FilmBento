<?php

class UserController extends Controller {
    
    private $model;

    function __construct() {
        $this->model = new UserModel();

        parent::__construct();
     }

     /*
      * Displays the user profile specified
      * or if a user not specified redirects
      */
    function index() {
        if( isset($_GET['user']) ) {
            $user = $this->model->getUser('handle', $_GET['user']);

            $seenModel = new SeenModel();
            $seens = $seenModel->getLastSeens(10, $user);

            $seensArray = array();

            $filmModel = new FilmModel();

            foreach ($seens as $seen) {
                $film = $filmModel->getFilm('id', $seen->getFilmID());
                
                $array = array(
                    'title' => $film->getTitle(),
                    'path' => $film->getPath(),
                    'rating' => $seen->getRating(),
                    'when' => $seen->whenSeen()
                );

                $seensArray[] = $array;
            }

            $data = array ( 'user' => $user,
                            'seens' => $seensArray);
            $this->view->load('user_view', $data);
        } else {
            header('Location: /');
        }
    }
}