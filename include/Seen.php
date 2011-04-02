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
        if ($date = 0) {
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
