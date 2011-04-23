<?php

class LoginManager {
    private static $instance;

    private function __contruct() {
    }

    static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new LoginManager();
        }
        return self::$instance;
    }

    function userLoggedIn() {
        if (isset($_SESSION['loggedInUserHandle']) && isset($_SESSION['loggedInUserPassword'])) {
            if ($this->checkCredentials($_SESSION['loggedInUserHandle'], $_SESSION['loggedInUserPassword'])) {
                return true;
            }
        } else {
            return false;
        }
    }

    function getLoggedInUser() {
        if (isset($_SESSION['loggedInUserHandle'])) {
            $userModel = new UserModel();
            $user = $userModel->getUser('handle', $_SESSION['loggedInUserHandle']);
            return $user;
        } else {
            return false;
        }
    }

    function logInUser($handle, $password) {
        if ($this->checkCredentials($handle, md5($password))) {
            $userModel = new UserModel();
            $user = $userModel->getUser('handle', $handle);
            if (!$user) {
                $user = $userModel->getUser('email', $handle);
            }
            $_SESSION['loggedInUserHandle'] = $user->getHandle();
            $_SESSION['loggedInUserPassword'] = $user->getPassword();
            return true;
        } else {
            return false;
        }
    }

    function logOut() {
        session_unset();
        session_destroy();
    }

    function checkCredentials ($handle, $password) {
        $userModel = new UserModel();
        $user = $userModel->getUser('handle', $handle);
        if ($user && $user->getPassword() == $password) {
            return true;
        } else {
            $user = $userModel->getUser('email', $handle);
            if ($user && $user->getPassword() == $password) {
                return true;
            } 
        }
        return false;
    }
}
