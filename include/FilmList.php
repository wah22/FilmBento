<?php

class FilmList {

    private $id;
    private $name;
    private $seens = array();

    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    function getID() {
        return $this->id;
    }
    
    function getName() {
        return $this->name;
    }
    
    function getSeens() {
        return $this->seens;
    }
    
    function addSeen(Seen $seen) {
        foreach ($this->seens as $entry) {
            if ($entry->getFilm()->getID() == $seen->getFilm()->getID()) {
                throw new Exception('that film is already on the list');
            }
        }
        $this->seens[] = $seen;
    }

    function remove($filmID) {
        foreach ($this->seens as $key=>$seen) {
            if ($seen->getFilm()->getID() == $filmID) {
                unset($this->seens[$key]);
            }
        }

        $newSeens = array();

        foreach ($this->seens as $key=>$seen) {
            $newSeens[] = $seen;
        }

        $this->seens = $newSeens;
    }

    /*
     * Sorts all the films/seens in the list according to an array passed to it
     * The array must be in the format $rank=>filmID
     */
    function sort($array) {
        $newSeens = array();

        foreach ($array as $rank=>$filmID) {
            foreach ($this->seens as $seen) {
                if ($seen->getFilm()->getID() == $filmID) {
                    $newSeens[] = $seen;
                }
            }
        }

        $this->seens = $newSeens;
    }

    function hasFilm($film) {
        foreach ($this->seens as $seen) {
            if ($seen->getFilm()->getID() == $film->getID()) {
                return true;
            }
        }
        return false;
    }
}