<?php

/** Film
* Holds a film's data
* Used by views and controllers.
* Setting up Film objects is done by the FilmModel
*/

class Film implements Linkable {

    protected $id;
    protected $title;
    protected $year;
    protected $userWhoAddedId;
    protected $meta = array();

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
        $title = str_replace('&', 'and', $title);
        $this->title = $title;
    }

    function getYear() {
        return $this->year;
    }

    function setYear($year) {
        $this->year = $year;
    }

    function getUserWhoAddedID() {
        return $this->userWhoAddedID;
    }

    function setUserWhoAddedID($id) {
        $this->userWhoAddedID = $id;
    }

    function getPath () {
        $path = BASE_URL . '/films/' . urlencode($this->getTitle()) . "_" . $this->getYear();
        return $path;
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

    function setMeta($type, $value) {
        $this->meta[$type] = $value;
    }
}

