<?php

class Seen {
    private $userID;
    private $filmID;
    private $rating;

    function __construct($userID, $filmID, $rating = 1) {
        $this->userID = $userID;
        $this->filmID = $filmID;
        $this->rating = $rating;
    }

    function getUser() {
        $userModel = new UserModel();
        $user = $userModel->getUser('id', $this->userID);
        return $user;
    }

    function getFilm() {
        $filmModel = new FilmModel();
        $film = $filmModel->getFilm('id', $this->filmID);
        return $film;
    }

    function getRating() {
        if ($this->rating->getValue()) {
            return $this->rating;
        } else {
            return false;
        }
    }
}
