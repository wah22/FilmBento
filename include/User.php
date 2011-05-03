<?php

/**
* User
* Essentially all this class does is stores and provides user data to views and controllers.
* Construction of User objects from the database is handled by the UserModel.
*/
class User implements Linkable {

    private $id;
    private $email;
    private $handle;
    private $password; //md5
    private $sex;
    private $dob;
    private $location;
    private $twitter;

    function __construct() {
    }

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

    function getHandle() {
        return $this->handle;
    }

    function setHandle($handle) {
        $this->handle = $handle;
    }

    function getPath() {
        return BASE_URL . '/' . $this->gethandle();
    }

    function getSex() {
        return $this->sex;
    }

    function setSex($sex) {
        $this->sex = $sex;
    }

    function getLocation() {
        $location = $this->location;
        $cleanLocation = htmlentities($location, ENT_QUOTES, "UTF-8");
        return $cleanLocation;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function getTwitter() {
        return $this->twitter;
    }

    function setTwitter($twitter) {
        $this->twitter = $twitter;
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
