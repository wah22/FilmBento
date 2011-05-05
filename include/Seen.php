<?php

/** Seen
* A Seen object holds data on a "seen", the relationship between a User object and Film object when the user has seen the film
* It can optionally contain the user's rating and small review or "tweeview "
*/
class Seen {
    private $userID;
    private $filmID;
    private $rating;
    private $date;
    private $tweeview;

    function __construct( $userID, $filmID, $rating, $date, $tweeview = "" ) {
        $this->userID = $userID;
        $this->filmID = $filmID;
        $this->rating = $rating;
        $this->date = $date;
        $this->tweeview = $tweeview;
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

    function getTweeview() {
        return $this->tweeview;
    }

    function setTweeview($tweeview) {
        $this->tweeview = $tweeview;
    }

    function getDate() {
        return $this->date;
    }

    // Gets a string that says when the seen occurred
    function whenSeen () {
        $date = new DateTime(date("Y-m-d H:i:s", $this->date));

        // If a user is logged in format the date to their timezone
        if (LoginManager::getInstance()->UserLoggedIn()) {
            $loggedInUser = LoginManager::getInstance()->getLoggedInUser();
            $date->setTimezone(new DateTimeZone($loggedInUser->getTimezone()));
        }

        $formattedDate = $date->format('l, j M');

        return $formattedDate;
    }
}
