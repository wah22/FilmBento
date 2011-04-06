<?php

class Film implements Linkable {

    private $id;
    private $title;
    private $year;
    private $seens = array();
    private $userWhoAddedId;
    private $meta = array();

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
        $path = '/films/' . urlencode($this->getTitle());
        return $path;
    }

    function setMeta($type, $value) {
        $this->meta[$type] = $value;
    }

    function getMeta($metaToGet) {
        if (isset($this->meta[$metaToGet])) {
            return $this->meta[$metaToGet];
        } else {
            return false;
        }
    }

    function getAllMeta() {
        return $this->meta;
    }
}
