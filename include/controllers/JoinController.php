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
            if ($this->userModel->getUser('email', $_POST['email'])) {
                $errors[] = "That email address is already associated with an account!";
            }
        }

         if (! empty($_POST['handle'])) {
             $handle = $_POST['handle'];
             if ($this->userModel->getUser('handle', $handle)) {
                $errors[] = "Sorry, that handle has already been taken.";
            }
            if(strlen($handle) < 3) {
                $errors[] = "Your name must be at least three characters long.";
            }
            if(strlen($handle) > 64) {
                $errors[] = "Your name must be less than 64 characters long.";
            }
            if (!preg_match('/^[a-zA-Z0-9]+$/',$handle)) {
                $errors[] = "Your chosen name contains invalid characters.";
            }
        }

        if (!empty($errors)) {
            $data['errors'] = $errors;
            $this->view->load('join_view', $data);
        } else {
            $this->userModel->create($_POST['email'], $_POST['handle'], $_POST['password']);

            //send confirm email
            $headers = "From: FilmBento <admin@filmbento.com>";

            $user=$this->userModel->getUser('email', $_POST['email']);

            $handle = $user->getHandle();
            $email = $user->getEmail();
            $message = "A new user has joined FilmBento.\nUsername: $handle\nEmail: $email";

            if (!mail('filmbento@gmail.com', 'A new user has signed up', $message, $headers ) )
            {
                die('There was an error sending the reset password email. Please contact filmbento@gmail.com');
            }

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