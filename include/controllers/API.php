<?php

class API extends Controller {
    function __construct() {
        parent::__construct();
    }

    function index() {
        echo "Oh hai. This is the FilmBento API.";
    }

    /*
     * displays films titles of returned search results of $_GET['query'] in json format
     */
    function search() {
        if ( ! isset($_GET['query']) || empty($_GET['query']) ) {
            return false;
        }

        $filmModel = new FilmModel();
        $films = $filmModel->search(urldecode($_GET['query']));
        
        $results = array();
        foreach($films as $film) {
            $results[] = $film->getTitle();
        }

        $json = json_encode((object)$results);
        echo $json;
    }

    function userList() {
        if (! isset($_GET['user']) || empty($_GET['user'])
             || ! isset($_GET['list']) || empty($_GET['list']) ) {
            return false;
        }

        $userModel = new UserModel();
        
        $user = $userModel->getUser('id', $_GET['user']);

        $list = $user->getList($_GET['list']);

        $films = array();

        foreach ($list->getSeens() as $seen) {
            $film = $seen->getFilm();
            $title = $film->getTitle();
            $films[] = $title;
        }

        $jsonFilms = json_encode((object)$films);

        echo $jsonFilms;
    }


}
