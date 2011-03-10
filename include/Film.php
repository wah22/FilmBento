<?php

class Film implements Linkable {

    private $id;
    private $title;
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