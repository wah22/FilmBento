<?php

class Seen {
    private $userID;
    private $filmID;
    private $rating;
    private $date;

    function __construct( $userID, $filmID, $rating = 0, $date = 0 ) {
        $this->userID = $userID;
        $this->filmID = $filmID;
        $this->rating = $rating;
        if ($date == 0) {
            $date = time();
        }
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

        return date('l, j F', $this->date);
    }
}
