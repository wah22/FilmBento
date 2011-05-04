<?php

class AccountSettingsController extends PrivateController {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $data = array(
            'user' => $this->user,
            'timezones' => $this->getTimezones()
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

        if (!empty($_POST['location']) && $_POST['location'] != $this->user->getLocation()) {
            $location = $_POST['location'];
            $this->user->setLocation($location);
            $this->userModel->save($this->user);
        }

        if (!empty($_POST['sex']) && $_POST['sex'] != $this->user->getSex()) {
            $sex = $_POST['sex'];
            $this->user->setSex($sex);
            $this->userModel->save($this->user);
        }

        if (!empty($_POST['twitter']) && $_POST['twitter'] != $this->user->getTwitter()) {
            $twitter = $_POST['twitter'];
            $this->user->setTwitter($twitter);
            $this->userModel->save($this->user);
        }

        if (!empty($_POST['timezone']) && $_POST['timezone'] != $this->user->getTimezone()) {
            $timezone = $_POST['timezone'];
            $this->user->setTimezone($timezone);
            $this->userModel->save($this->user);
        }

        $data['user'] = $this->user;
        $data['errors'] = $errors;
        $data['timezones'] = $this->getTimezones();
        $this->view->load('account_settings_view', $data);
    }

    function deleteAccount() {
        $this->seenModel->deleteAllUsersSeens($this->user);
        $this->userModel->delete($this->user);
        $this->view->load('bai_view');
    }

    // Returns all timezones in an array
    private function getTimezones() {
        $timezones = DateTimeZone::listAbbreviations();
        $timezoneIDs = array();
        foreach ($timezones as $timezone) {
            foreach ($timezone as $zone) {
                if ( preg_match( '/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $zone['timezone_id'] ) ) {
                    $timezoneIDs[] = $zone['timezone_id'];
                }
            }
        }
        sort($timezoneIDs);
        $timezoneIDs = array_unique($timezoneIDs);
        
        return $timezoneIDs;
    }
}
