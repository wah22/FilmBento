<?php

class Seen {
    private $userID;
    private $filmID;
    private $rating;
    private $date;

    function __construct( $userID, $filmID, $rating, $date ) {
        $this->userID = $userID;
        $this->filmID = $filmID;
        $this->rating = $rating;
        $this->date = $date;
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

    function getDate() {
        return $this->date;
    }

    function whenSeen () {
        if ((time() - $this->date) < (60*2)) {
            $when = "Just now";
            return $when;
        }

        if ((time() - $this->date) < (60 * 60)) {
            $when = strval( round( (time() - $this->date) / 60 ) );
            $when .= " minutes ago";
            return $when;
        }

        if ((time() - $this->date) < 86400) {
            $when = strval( round( (time() - $this->date) / 60 / 60 ) );
            $when .= " hours ago";
            return $when;
        }

        return date('l, j F', $this->date);
    }
}
