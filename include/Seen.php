<?php

class Seen {
    private $userID;
    private $filmID;
    private $rating;

    function __construct($userID, $filmID, $rating = 0) {
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
        return $this->rating;
    }

    function setRating($rating) {
        $this->rating = $rating;
    }
}
