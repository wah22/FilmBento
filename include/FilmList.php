<?php

class FilmList {

    private $id;
    private $userID;
    private $name;
    private $entries = array();

    function __construct($userID, $id, $name) {
        $this->userID= $userID;
        $this->id = $id;
        $this->name = $name;
    }

    function getID() {
        return $this->id;
    }

    function getUserID() {
        return $this->userID;
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
        $this->entries[] = $newEntry;
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
}