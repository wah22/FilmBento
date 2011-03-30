<?php

class JoinController extends Controller {

    function __construct() {
        parent::__construct();

        $data = array (
            'errors' => array()
        );
    }

    function  index() {
        $this->view->load('join_view');
    }

    function submit() {
        $errors = array();
        
        if (empty($_POST['email']) || empty($_POST['handle']) || empty($_POST['password']) || empty($_POST['password2'])) {
            $errors[] = "Please fill out all form fields.";
        }

        if (!empty($_POST['email']) && !$this->checkEmail($_POST['email'])) {
            $errors[] = "Please enter a valid email address.";
        }

        if (!empty($_POST['password']) && !empty($_POST['password2']) && $_POST['password'] != $_POST['password2']) {
            $errors[] = "Passwords do not match. Please try again.";
        }

        if (! empty($_POST['email'])) {
            $userModel = new UserModel();
            if ($userModel->getUser('email', $_POST['email'])) {
                $errors[] = "That email address is already associated with an account!";
            }
        }

         if (! empty($_POST['handle'])) {
            $userModel = new UserModel();
            if ($userModel->getUser('handle', $_POST['handle'])) {
                $errors[] = "Sorry, that handle has already been taken.";
            }
        }

        if (!empty($errors)) {
            $data['errors'] = $errors;
            $this->view->load('join_view', $data);
        } else {
            $userModel = new UserModel();
            $userModel->create($_POST['email'], $_POST['handle'], $_POST['password']);

            LoginManager::getInstance()->logInUser($_POST['handle'], $_POST['password']);

            header("Location:/");
        }
    }

    function checkEmail($email) {
        if (preg_match('|^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$|i', $email)) {
            return true;
        } else {
            return false;
        }
    }
}