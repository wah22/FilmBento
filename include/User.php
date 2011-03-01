<?php

class User {

    private $id;
    private $email;
    private $handle;
    private $filmsSeen;

    function getID() {
        return $this->id;
    }

    function setID($id) {
        $this->id = $id;
    }
    
    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setHandle($handle) {
        $this->handle = $handle;
    }

    function getHandle() {
        return $this->handle;
    }

    function getSeenFilms() {
        return $this->filmsSeen;
    }

    function addToSeenFilms($film) {
        $this->filmsSeen[] = $film;
    }

}