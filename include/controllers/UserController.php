<?php

class UserController extends Controller {
    
    private $model;

    function __construct() {
        $this->model = new UserModel();

        parent::__construct();
     }

     /*
      * Displays the user profile specified
      * or if a user not specified redirects
      */
    function index() {
        if( isset($_GET['user']) ) {
            $user = $this->model->getUser('handle', $_GET['user']);
            $data = array ( 'user' => $user);
            $this->view->load('user_view', $data);
        } else {
            header('Location: /');
        }
    }
}