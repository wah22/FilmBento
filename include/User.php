<?php

class User implements Linkable {

    private $id;
    private $email;
    private $handle;
    private $lists = array();
    private $password; //md5
    private $sex;
    private $dob;
    private $location;

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
        return BASE_URL . '/' . $this->gethandle();
    }

    function setSex($sex) {
        $this->sex = $sex;
    }

    function getSex() {
        return $this->sex;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function getLocation() {
        return $this->location;
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

    function getDOB() {
        return $this->dob;
    }

    function setDOB($dob) {
        if ($dob == -62169982479) {
            $this->dob = false;
        } else {
            $this->dob = $dob;
        }
    }

    function getAge() {
        if (!$this->getDOB()) {
            return false;
        }

        $age = date('Y', time()) - date('Y', $this->getDOB());
        if(date("z",time()) < date("z",$this->getDOB())) $age--;
        return $age;
    }

    function getAvatar() {
        $hash = md5( strtolower( trim( $this->getEmail() ) ) );
        $default = "mm"; //mystery man
        $url = "http://www.gravatar.com/avatar/$hash?s=200&d=$default";
        return $url;
    }
}
