<?php

class UserController {
    
    private $model;
    private $view;

    function __construct() {
        $this->model = new UserModel();
        $this->view = new View();

        // load the default page
        $this->userPage();
     }

    function userPage() {
        if( isset($_GET['user']) ) {
            $user = $this->model->getUser($_GET['user']);
            $data = array ( 'user' => $user);
            $this->view->load('user_view', $data);
        }
    }
}