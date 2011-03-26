<?php

class UserController extends Controller {

    function __construct() {
        parent::__construct();
     }

     /*
      * Displays the user profile specified
      * or if a user not specified redirects
      */
    function index() {
        if( isset($_GET['user']) ) {
            $user = $this->userModel->getUser('handle', $_GET['user']);

            $seens = $this->seenModel->getLastSeens(10, $user);

            $seensArray = array();

            foreach ($seens as $seen) {
                $film = $this->filmModel->getFilm('id', $seen->getFilmID());
                
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
