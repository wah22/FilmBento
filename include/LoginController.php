<?php

class LoginController extends Controller {

    function __construct() {
        parent::__construct();

        $this->index();
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
}