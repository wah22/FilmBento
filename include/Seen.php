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

    function getUserID() {
        return $this->userID;
    }

    function getFilmID() {
        return $this->filmID;
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
        if (date('l, j F', $this->date) == date('l, j F', time()) ) {
            return 'Today';
        }

        if (date('o', $this->date) != date('o', time())) {
            return date('l, j F o', $this->date);
        }

        return date('l, j F', $this->date);
    }
}
