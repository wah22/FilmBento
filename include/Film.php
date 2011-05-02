<?php

class Film implements Linkable {

    private $id;
    private $title;
    private $year;
    private $userWhoAddedId;
    private $meta = array();

    function getID() {
        return $this->id;
    }
    
    function setID($id) {
        $this->id = $id;
    }
    
    function getTitle() {
        if (preg_match('(\d{4}$)', $this->title)) {
            return '';
        }
        return $this->title;
    }

    function setTitle($title) {
        $title = str_replace('&', 'and', $title);
        $this->title = $title;
    }

    function getYear() {
        return $this->year;
    }

    function setyear($year) {
        $this->year = $year;
    }

    function setUserWhoAddedID($id) {
        $this->userWhoAddedID = $id;
    }

    function getUserWhoAddedID() {
        return $this->userWhoAddedID;
    }

    function getPath () {
        $path = BASE_URL . '/films/' . urlencode($this->getTitle()) . "_" . $this->getYear();
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
