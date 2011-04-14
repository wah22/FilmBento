<?php

class LoginController extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $data = array(
            'errors' => array()
        );

        $this->view->load('login_view', $data);
    }


    function login() {
        $errors = array();

       if (empty($_POST['identifier']) || empty($_POST['password'])) {
            $errors[] = "Please fill in both fields.";
        }

        if (!empty($_POST['identifier']) && !empty($_POST['password'])) {
            if (!LoginManager::getInstance()->logInUser($_POST['identifier'], $_POST['password'])) {
                $errors[] = "Wrong username or password.";
            }
        }

        if (!empty($errors)) {
            $data['errors'] = $errors;
            $this->view->load('login_view', $data);
        } else {
            header("Location: /");
        }
    }

    function forgotPassword () {
        $data = array();

        if (isset($_POST['email'])) {

            $newPassword = $this->genRandomString();

            $user = $this->userModel->getuser('email', $_POST['email']);

            if (!$user) {
                $data['errors'] = "Couldn't find a user with that email address...";
            } else {

                $user->setPassword(md5($newPassword));

                $this->userModel->save($user);

                $headers = "From: no-reply@filmbento.com";
                if (!mail($_POST['email'], 'FilmBento password reset',"Hi, this is an automatically generated email from FilmBento.\nForgot your password?\nIt's been reset to $newPassword", $headers ) )
                {
                    die('error sending email');
                }

                $data['reset'] = true;
            }
        }

        $this->view->load('forgot_password_view', $data);
    }

    function genRandomString() {
        $length = 10;
        $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
        $string = "";
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, 35)];
        }
        return $string;
    }
}