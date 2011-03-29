<?php

class AccountSettingsController extends PrivateController {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $userOutput = array(
            'email' => $this->user->getEmail()
        );

        $data = array(
            'user' => $userOutput
        );

        $this->view->load('account_settings_view', $data);
    }

    function save() {
        if(!empty($_POST['email'])) {
            $email = $_POST['email'];

            if ($email != $this->user->getEmail()) {
                $this->user->setEmail($email);

                $this->userModel->save($this->user);
            }
        }

        if(!empty($_POST['password'])) {
            $password = $_POST['password'];

            if ( md5($password) != $this->user->getPassword()) {
                $this->user->setPassword(md5($password));
                
                $this->userModel->save($this->user);

                LoginManager::getInstance()->LogInUser($this->user->gethandle(), $password);
            }
        }

        $this->index();
    }
}