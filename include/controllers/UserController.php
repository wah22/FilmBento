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
        if( empty($_GET['user']) ) {
            header('Location: /');
        }
        
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

        $lists = $this->listModel->getLists($user);

        $listsOutput = array();

        foreach ($lists as $list) {
            $listOutput['name'] = $list->getName();

            foreach ($list->getEntries() as $entry) {
                $film = $this->filmModel->getFilm('id', $entry);
                $listOutput['films'][] = array(
                    'title' => $film->getTitle(),
                    'path' => $film->getPath()
                );
            }
            $listsOutput[] = $listOutput;
        }

        $data = array ( 'user' => $user,
                        'seens' => $seensArray,
                        'lists' => $listsOutput
                );
        
        $this->view->load('user_view', $data);
    }

    /*
     * Displays all the films the user has seen
     */
    function films() {
        if (empty($_GET['user']) || empty($_GET['page'])) {
            header('Location: /');
        }

        $user = $this->userModel->getuser('handle', $_GET['user']);

        $offset = ($_GET['page'] - 1) * 10;

        $seens = $this->seenModel->getLastSeens(100, $user, $offset);

        $seensOutput = array();

        foreach ($seens as $seen) {
            $film = $this->filmModel->getFilm('id', $seen->getFilmID());

            $array = array(
                'title' => $film->getTitle(),
                'path' => $film->getPath(),
                'rating' => $seen->getRating(),
                'when' => $seen->whenSeen()
            );

            $seensOutput[] = $array;
        }

        $data = array(
            'user' => $user,
            'seens' => $seensOutput
        );

        $this->view->load('user_all_films_view', $data);
    }
}
