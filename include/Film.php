<?php

class Film implements Linkable {

    private $id;
    private $title;
    private $year;
    private $seens = array();
    private $userWhoAddedId;

    function getID() {
        return $this->id;
    }
    
    function setID($id) {
        $this->id = $id;
    }
    
    function getTitle() {
        return $this->title;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function getYear() {
        return $this->year;
    }

    function setyear($year) {
        $this->year = $year;
    }

    function getSeens() {
        return $this->seens;
    }

    function addToSeens($seen) {
        $this->seens[] = $seen;
    }

    function setUserWhoAddedID($id) {
        $this->userWhoAddedID = $id;
    }

    function getUserWhoAddedID() {
        return $this->userWhoAddedID;
    }

    function getPath () {
        return '/films/' . urlencode($this->getTitle());
    }
}