<?php

class AccountSettingsController extends PrivateController {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $data = array(
            'user' => $this->user
        );

        $this->view->load('account_settings_view', $data);
    }

    function save() {
        $errors = array();
        if(!empty($_POST['email']) && $_POST['email'] != $this->user->getEmail()) {
            $email = $_POST['email'];

            if (!$this->userModel->getUser('email',$email)) {
                $this->user->setEmail($email);
                $this->userModel->save($this->user);
            } else {
                $errors[] = "That email address is already associated with an account.";
            }
        }

        if(!empty($_POST['dob'])) {
            $dob = date($_POST['dob']);
            
            if ($dob != $this->user->getDOB()) {
                $this->user->setDOB(strtotime($dob));
                $this->userModel->save($this->user);
            }
        } else {
            $this->user->setDOB(false);
            $this->userModel->save($this->user);
        }

        if(!empty($_POST['password'])) {
            $password = $_POST['password'];

            if ( md5($password) != $this->user->getPassword()) {
                $this->user->setPassword(md5($password));
                
                $this->userModel->save($this->user);

                LoginManager::getInstance()->LogInUser($this->user->gethandle(), $password);
            }
        }

        if ($_POST['location'] != $this->user->getLocation()) {
            $location = $_POST['location'];
            $this->user->setLocation($location);
            $this->userModel->save($this->user);
        }

        if ($_POST['sex'] != $this->user->getSex()) {
            $sex = $_POST['sex'];
            $this->user->setSex($sex);
            $this->userModel->save($this->user);
        }

        $data['user'] = $this->user;
        $data['errors'] = $errors;
        $this->view->load('account_settings_view', $data);
    }

    function deleteAccount() {
        $this->seenModel->deleteAllUsersSeens($this->user);
        $this->userModel->delete($this->user);
        $this->view->load('bai_view');
    }
}
