<?php

class FilmList {

    private $id;
    private $userID;
    private $name;
    private $entries = array();
    private $maxEntries;
    private $createdByID;
    private $description;

    function __construct($userID = 0, $id = 0, $name= "", $maxEntries = 10) {
        $this->userID= $userID;
        $this->id = $id;
        $this->name = $name;
        $this->maxEntries = $maxEntries;
    }

    function setID($id) {
        $this->id = $id;
    }

    function getID() {
        return $this->id;
    }

    function getUserID() {
        return $this->userID;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getName() {
        return $this->name;
    }
    
    function getEntries() {
        return $this->entries;
    }
    
    function addEntry($newEntry) {
        foreach ($this->entries as $entry) {
            if ($entry == $newEntry) {
                return;
            }
        }
        if (count($this->entries) < $this->maxEntries || $this->maxEntries == 0) {
             $this->entries[] = $newEntry;
        }
    }

    function setMaxEntries($maxEntries) {
        $this->maxEntries = $maxEntries;
    }

    function getMaxEntries() {
        return $this->maxEntries;
    }

    function remove($filmID) {
        foreach ($this->entries as $key=>$entry) {
            if ($entry == $filmID) {
                unset($this->entries[$key]);
            }
        }

        $newEntries = array();

        foreach ($this->entries as $key=>$entry) {
            $newEntries[] = $entry;
        }

        $this->entries = $newEntries;
    }

    /*
     * Sorts all the films/seens in the list according to an array passed to it
     * The array must be in the format $rank=>filmID
     */
    function sort($array) {
        $this->entries = $array;
    }

    function hasFilm($film) {
        foreach ($this->seens as $seen) {
            if ($seen == $film->getID()) {
                return true;
            }
        }
        return false;
    }

    function setCreatedByID($id) {
        $this->createdByID = $id;
    }

    function getCreatedByID() {
        return $this->createdByID;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function getDescription() {
        return $this->description;
    }
}