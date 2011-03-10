<?php

class User implements Linkable {

    private $id;
    private $email;
    private $handle;
    private $seens = array();
    private $lists = array();
    private $password; //md5

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

    function getSeens() {
        return $this->seens;
    }

    function getRatingOf($film) {
        foreach ($this->seens as $seen) {
            if ($seen->getFilm()->getID() == $film->getID()) {
                if ($seen->getRating()) {
                    $rating = $seen->getRating()->getValue();
                    return $rating;
                } else {
                    return '';
                }
            }
        }
        return false;
    }

    function hasSeen($film) {
        foreach ($this->seens as $seen) {
            if ($seen->getFilm()->getID() == $film->getID()) {
                return true;
            }
        }
        return false;
    }

    function setSeen($film) {
        $seen = new Seen($this->id, $film->getID(), 1);
        $this->addToSeens($seen);
    }

    function addToSeens($seen) {
        foreach ($this->seens as $entry) {
            if ($entry->getFilm()->getID() == $seen->getFilm()->getID()) {
                foreach ($this->seens as $seen) {
                    echo $seen->getFilm()->getTitle();
                }
                throw new Exception('User has already seen that film!');
            }
        }
        $this->seens[] = $seen;
    }

    function getPath() {
        return '/?controller=UserController&user=' . $this->gethandle();
    }

    function getList($listID) {
        foreach ($this->lists as $list) {
            if ($list->getID() == $listID) {
                return $list;
            }
        }
        throw new Exception('That list could not be found');
    }

    function getLists() {
        return $this->lists;
    }
    
    function addList($list) {
        $this->lists[] = $list;
    }

    function getPassword() {
        return $this->password;
    }

    function setPassword($password) {
        $this->password = $password;
    }
}