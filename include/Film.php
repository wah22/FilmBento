<?php

class Film implements Linkable {

    private $id;
    private $title;
    private $year;
    private $seens = array();

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

    function getPath () {
        return '/?controller=FilmController&film=' . urlencode($this->getTitle());
    }
}