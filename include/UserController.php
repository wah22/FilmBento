<?php

class UserController {
    
    private $model;
    private $view;

    function __construct() {
        $this->model = new UserModel();
        $this->view = new View();

        // load the default page
        $this->index();
     }

    function index() {
        if( isset($_GET['user']) ) {
            $user = $this->model->getUser('handle', $_GET['user']);
            $data = array ( 'user' => $user);
            $this->view->load('user_view', $data);
        }
    }
}