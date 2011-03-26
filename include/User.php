<?php

class User implements Linkable {

    private $id;
    private $email;
    private $handle;
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